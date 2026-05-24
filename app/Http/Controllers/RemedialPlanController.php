<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemedialPlan;
use App\Models\Student;
use App\Models\Subject;

class RemedialPlanController extends Controller
{
    public function index()
    {
        $plans = RemedialPlan::with(['student.user', 'teacher.user'])->latest()->get();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        $students = Student::where('risk_score', '<', 75)->with('user')->get();
        return view('plans.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string',
            'learning_issue' => 'required|string',
            'preferred_style' => 'required|string',
            'duration' => 'required|string',
        ]);

        // Simulated AI Logic for structured plan generation
        $issue = strtolower($request->learning_issue);
        $style = strtolower($request->preferred_style);
        
        $planContent = "### Learning Objective\nImprove fundamental understanding of " . $request->subject . " with a focus on resolving: " . $request->learning_issue . ".\n\n";
        
        $planContent .= "### Recommended Teaching Method\n";
        if (str_contains($style, 'visual')) {
            $planContent .= "Visual Learning: Use concept mapping, mind maps, and interactive video lessons. Visual aids will bridge the gap in comprehension.\n\n";
        } elseif (str_contains($style, 'peer')) {
            $planContent .= "Peer-to-Peer Mentoring: Pair the student with a high-performing classmate. Collaborative learning builds confidence.\n\n";
        } elseif (str_contains($style, 'activity')) {
            $planContent .= "Activity-Based Learning: Implement hands-on practice, physical models, or gamified quizzes to enforce active recall.\n\n";
        } else {
            $planContent .= "Micro-Learning: Break down complex topics into bite-sized 5-minute focused sessions followed by immediate practice.\n\n";
        }

        $planContent .= "### Weekly Action Plan ({$request->duration})\n";
        $planContent .= "- **Week 1:** Foundational review using targeted worksheets.\n";
        $planContent .= "- **Week 2:** Introduction of core concepts using the recommended method.\n";
        $planContent .= "- **Week 3:** Practical application and interactive assessment.\n";
        $planContent .= "- **Week 4:** Final evaluation and confidence-building exercises.\n";

        $user = auth()->user();
        $teacher = $user->teacher ?: \App\Models\Teacher::firstOrCreate(['user_id' => $user->id]);

        $plan = RemedialPlan::create([
            'student_id' => $request->student_id,
            'teacher_id' => $teacher->id,
            'subject' => $request->subject,
            'learning_issue' => $request->learning_issue,
            'preferred_style' => $request->preferred_style,
            'duration' => $request->duration,
            'generated_plan' => $planContent,
            'status' => 'Active'
        ]);

        return redirect()->route('plans.show', $plan->id)->with('success', 'Remedial Plan generated successfully.');
    }

    public function show(RemedialPlan $plan)
    {
        $plan->load(['student.user', 'teacher.user', 'progressRecords']);
        return view('plans.show', compact('plan'));
    }

    public function complete(RemedialPlan $plan)
    {
        $plan->update(['status' => 'Completed']);
        return redirect()->back()->with('success', 'Remedial plan has been marked as Completed.');
    }

    public function addProgress(Request $request, RemedialPlan $plan)
    {
        $request->validate([
            'notes' => 'required|string',
            'improvement_percentage' => 'required|integer|min:0|max:100',
        ]);

        \App\Models\ProgressRecord::create([
            'remedial_plan_id' => $plan->id,
            'student_id' => $plan->student_id,
            'notes' => $request->notes,
            'improvement_percentage' => $request->improvement_percentage,
        ]);

        return redirect()->back()->with('success', 'Progress record added successfully.');
    }
}
