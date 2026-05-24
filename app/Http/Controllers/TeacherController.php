<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Mark;
use App\Models\ProgressRecord;
use App\Models\RemedialPlan;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherFeedback;
use App\Models\Announcement;
use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $teacher = $user->teacher ?: Teacher::firstOrCreate(['user_id' => $user->id]);

        $students = Student::with(['user', 'eduClass', 'marks.subject', 'attendances', 'remedialPlans.progressRecords'])->get();
        $totalStudents = $students->count();
        $slowLearnersCount = $students->where('risk_score', '<', 60)->count();
        $needsAttentionCount = $students->whereBetween('risk_score', [60, 74.99])->count();
        $criticalCount = $students->where('risk_score', '<', 40)->count();
        $plansAssigned = RemedialPlan::count();
        $avgImprovement = round(ProgressRecord::avg('improvement_percentage') ?? 0, 1);
        $classAverage = round(Mark::avg('marks_obtained') ?? 0, 1);
        $avgAttendance = round(Attendance::avg('percentage') ?? 0, 1);

        $priorityStudents = Student::with(['user', 'eduClass', 'marks.subject', 'attendances', 'remedialPlans'])
            ->orderBy('risk_score', 'asc')
            ->take(6)
            ->get()
            ->map(function ($student) {
                $weakSubject = $student->marks->sortBy('marks_obtained')->first();
                $student->weak_subject = $weakSubject?->subject?->name ?? 'Not assessed';
                $student->latest_attendance = round($student->attendances->avg('percentage') ?? 0, 1);
                $student->plan_status = $student->remedialPlans->where('status', 'Active')->count() ? 'Plan Active' : 'Needs Plan';
                return $student;
            });

        $subjectWeaknesses = Mark::with('subject')
            ->get()
            ->groupBy(fn($mark) => $mark->subject?->name ?? 'Unknown')
            ->map(fn($marks) => round($marks->avg('marks_obtained'), 1))
            ->sort();

        $teachingQueue = $priorityStudents->map(function ($student) {
            $score = (float) $student->risk_score;
            $strategy = $score < 40 ? '1:1 concept rescue + parent update' : ($score < 60 ? 'Small group bridge session' : 'Practice booster + weekly check');
            return [
                'name' => $student->user->name,
                'class' => $student->eduClass?->name ?? 'Unassigned',
                'risk' => round($score, 1),
                'weak_subject' => $student->weak_subject,
                'strategy' => $strategy,
            ];
        });

        $recentActivities = ProgressRecord::with('remedialPlan.student.user')->latest()->take(5)->get();
        $riskLabels = ['Critical', 'Slow', 'Attention', 'Good'];
        $riskData = [
            $students->where('risk_score', '<', 40)->count(),
            $students->whereBetween('risk_score', [40, 59.99])->count(),
            $students->whereBetween('risk_score', [60, 74.99])->count(),
            $students->where('risk_score', '>=', 75)->count(),
        ];

        // Load recent feedbacks sent by this teacher
        $recentFeedbacks = TeacherFeedback::where('teacher_id', $teacher->id)
            ->latest()
            ->with('student.user')
            ->take(6)
            ->get();

        // Load pending student help requests
        $helpRequests = HelpRequest::where('status', 'pending')
            ->with('student.user')
            ->latest()
            ->get();

        // Load active announcements
        $announcements = Announcement::whereIn('audience', ['all', 'teachers'])
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'totalStudents', 'slowLearnersCount', 'needsAttentionCount', 'criticalCount', 'plansAssigned',
            'avgImprovement', 'classAverage', 'avgAttendance', 'priorityStudents', 'subjectWeaknesses',
            'teachingQueue', 'recentActivities', 'riskLabels', 'riskData', 'recentFeedbacks', 'helpRequests', 'announcements'
        ));
    }

    public function resolveHelpRequest(Request $request, HelpRequest $helpRequest)
    {
        $helpRequest->update(['status' => 'resolved']);
        return back()->with('success', 'Help request from ' . $helpRequest->student->user->name . ' marked as resolved.');
    }
}
