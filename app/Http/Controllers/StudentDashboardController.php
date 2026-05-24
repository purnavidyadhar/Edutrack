<?php

namespace App\Http\Controllers;

use App\Models\EduClass;
use App\Models\RemedialPlan;
use App\Models\Student;
use App\Models\Announcement;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            $defaultClass = EduClass::first();
            $student = Student::create([
                'user_id' => $user->id,
                'edu_class_id' => $defaultClass?->id,
                'roll_number' => 'REG-' . $user->id,
                'risk_score' => 70,
                'risk_level' => 'Needs Attention',
            ]);
        }

        $student->load(['marks.subject', 'attendances', 'remedialPlans.progressRecords', 'eduClass']);

        $avgScore = round($student->marks->avg('marks_obtained') ?? 0, 1);
        $attendance = round($student->attendances->avg('percentage') ?? 0, 1);
        $activePlan = $student->remedialPlans->where('status', 'Active')->first();
        $completedPlans = $student->remedialPlans->where('status', 'Completed')->count();
        $performanceHistory = $student->marks->sortBy('created_at')->pluck('marks_obtained')->take(8)->values()->toArray();
        $performanceHistory = count($performanceHistory) ? $performanceHistory : [0];
        $weakSubjects = $student->marks->sortBy('marks_obtained')->take(3)->map(fn($mark) => [
            'subject' => $mark->subject?->name ?? 'Unknown',
            'score' => $mark->marks_obtained,
            'tip' => $mark->marks_obtained < 50 ? 'Revise basics today' : 'Practice 20 minutes',
        ])->values();

        $missionList = collect([
            ['title' => 'Watch one micro lesson', 'desc' => '10 minutes focused concept recap', 'status' => $activePlan ? 'Unlocked' : 'Optional'],
            ['title' => 'Solve 5 confidence questions', 'desc' => 'Small wins to build momentum', 'status' => 'Today'],
            ['title' => 'Ask one doubt', 'desc' => 'Use teacher support before next class', 'status' => 'Pending'],
        ]);

        $progressPercent = min(100, max(5, round(($avgScore * .55) + ($attendance * .25) + ((100 - $student->risk_score) * .20), 0)));
        $badge = $avgScore >= 75 ? 'Momentum Maker' : ($student->risk_score < 60 ? 'Comeback Starter' : 'Steady Improver');
        
        // Load recent feedbacks from teachers
        $feedbacks = $student->feedbacks()->latest()->get();

        // Load active announcements
        $announcements = Announcement::whereIn('audience', ['all', 'students'])
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'student', 'avgScore', 'attendance', 'activePlan', 'completedPlans', 'performanceHistory',
            'weakSubjects', 'missionList', 'progressPercent', 'badge', 'feedbacks', 'announcements'
        ));
    }

    public function showPlan(RemedialPlan $plan)
    {
        abort_unless($plan->student_id === auth()->user()->student?->id, 403);
        return view('plans.show', ['plan' => $plan->load(['student.user', 'teacher.user', 'progressRecords'])]);
    }

    public function storeHelpRequest(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $student = auth()->user()->student;
        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        \App\Models\HelpRequest::create([
            'student_id' => $student->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Help request submitted successfully! Your teacher has been notified.');
    }

    public function submitConfidence(Request $request, RemedialPlan $plan)
    {
        abort_unless($plan->student_id === auth()->user()->student?->id, 403);

        $request->validate([
            'confidence' => 'required|in:confused,getting_it,confident',
            'message' => 'nullable|string|max:255',
        ]);

        $smileys = [
            'confused' => '😟 Confused - Needs immediate help',
            'getting_it' => '😐 Getting it - Making progress',
            'confident' => '🙂 Confident - Understood the concept',
        ];

        \App\Models\ProgressRecord::create([
            'remedial_plan_id' => $plan->id,
            'student_id' => $plan->student_id,
            'notes' => 'Confidence Check-in: ' . $smileys[$request->confidence] . ($request->message ? ' • ' . $request->message : ''),
            'improvement_percentage' => $request->confidence === 'confident' ? 10 : ($request->confidence === 'getting_it' ? 5 : 0),
        ]);

        return back()->with('success', 'Thank you for checking in! Your teacher will see your confidence status.');
    }
}
