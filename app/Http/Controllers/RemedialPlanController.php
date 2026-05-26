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

        $student = Student::findOrFail($request->student_id);
        $subjectName = $request->subject;
        $issue = $request->learning_issue;
        $style = $request->preferred_style;
        $duration = $request->duration;

        // Calculate student's marks percentage for this subject
        $subjectModel = Subject::where('name', $subjectName)->first();
        $marksPercentage = null;
        if ($subjectModel) {
            $totalObtained = \App\Models\Mark::where('student_id', $student->id)->where('subject_id', $subjectModel->id)->sum('marks_obtained');
            $totalPossible = \App\Models\Mark::where('student_id', $student->id)->where('subject_id', $subjectModel->id)->sum('total_marks');
            if ($totalPossible > 0) {
                $marksPercentage = ($totalObtained / $totalPossible) * 100;
            }
        }
        
        // Fallback to student's overall risk_score (which functions as their performance score index)
        if ($marksPercentage === null) {
            $marksPercentage = $student->risk_score;
        }
        $marksPercentage = round($marksPercentage, 1);

        // Determine student performance tier & pacing
        if ($marksPercentage < 45) {
            $perfLevel = 'Critical Intervention Required';
            $pacing = 'Repetitive, high-support, low-stakes pacing focused on basic foundations.';
        } elseif ($marksPercentage < 70) {
            $perfLevel = 'Targeted Skill Development';
            $pacing = 'Moderate pacing focused on bridging knowledge gaps and mid-level exercise drill sheets.';
        } else {
            $perfLevel = 'Academic Enrichment & Optimization';
            $pacing = 'Fast pacing focused on advanced application, past exam papers, and time-management strategies.';
        }

        // Generate customized plan content markdown
        $planContent = "## 📊 Individualized Remedial Plan: " . $student->user->name . "\n";
        $planContent .= "- **Subject:** " . $subjectName . "\n";
        $planContent .= "- **Academic Status:** " . $perfLevel . " (Current Subject Score: **" . $marksPercentage . "%**)\n";
        $planContent .= "- **Primary Target Gap:** " . $issue . "\n\n";

        $planContent .= "### 🎯 Learning Objective\n";
        if ($marksPercentage < 45) {
            $planContent .= "Re-establish basic concepts in " . $subjectName . " related to \"" . $issue . "\". Focus on fundamental rules and vocabulary before moving to standard curriculum application.\n\n";
        } elseif ($marksPercentage < 70) {
            $planContent .= "Bridge conceptual gaps in " . $subjectName . " regarding \"" . $issue . "\". Target core problem-solving models and standard worksheets to match class averages.\n\n";
        } else {
            $planContent .= "Optimize advanced performance in " . $subjectName . " for \"" . $issue . "\". Deep dive into high-difficulty topics, error analysis, and speed drilling.\n\n";
        }

        $planContent .= "### 🧠 Recommended Teaching Method: " . $style . "\n";
        $styleLower = strtolower($style);
        if (str_contains($styleLower, 'visual')) {
            $planContent .= "Use visual aids such as color-coded diagrams, mind maps, and interactive graphing utilities. For " . $subjectName . ", visually chart out \"" . $issue . "\" to make connections tangible.\n\n";
        } elseif (str_contains($styleLower, 'peer')) {
            $planContent .= "Pair the student with an academic buddy who has mastered " . $subjectName . ". Conduct joint study sprints where they explain concepts back and forth, focusing on: \"" . $issue . "\".\n\n";
        } elseif (str_contains($styleLower, 'activity') || str_contains($styleLower, 'hands-on')) {
            $planContent .= "Implement active retrieval and kinesthetic exercises (e.g. physical flashcards, flash-drills, virtual science labs, or gamified math quizzes). Focus directly on hands-on practice of \"" . $issue . "\".\n\n";
        } else {
            $planContent .= "Micro-Learning: Conduct short, focused 10-minute explanation blocks on \"" . $issue . "\", followed immediately by a single diagnostic question. Restrict practice load to maintain focus.\n\n";
        }

        $planContent .= "### ⏱️ Pacing Strategy & Rigor\n";
        $planContent .= "- **Pacing approach:** " . $pacing . "\n\n";

        $planContent .= "### 📅 Weekly Action Schedule (" . $duration . " Duration)\n";
        $durationLower = strtolower($duration);

        if (str_contains($durationLower, '2 week')) {
            $planContent .= "#### Week 1: Diagnostic & Foundation Building\n";
            $planContent .= "- **Goal:** Clarify baseline terminology and core definitions for \"" . $issue . "\" in " . $subjectName . ".\n";
            if ($marksPercentage < 45) {
                $planContent .= "- **Tasks:** Review fundamental formulas and simple examples. Complete 3 scaffolded homework exercises under direct teacher supervision using " . $style . ".\n";
            } else {
                $planContent .= "- **Tasks:** Resolve standard problem sets and map out dependencies using " . $style . ".\n";
            }
            $planContent .= "\n#### Week 2: Targeted Exercises & Assessment\n";
            $planContent .= "- **Goal:** Verify student comprehension under evaluation conditions.\n";
            if ($marksPercentage < 45) {
                $planContent .= "- **Tasks:** Complete a low-stakes 5-question quiz. Provide immediate corrective feedback.\n";
            } elseif ($marksPercentage < 70) {
                $planContent .= "- **Tasks:** Solve standard exam-style questions on \"" . $issue . "\" and log confidence scores.\n";
            } else {
                $planContent .= "- **Tasks:** Complete high-difficulty exercises under timed conditions (15 minutes limit).\n";
            }
        } elseif (str_contains($durationLower, '8 week')) {
            $planContent .= "#### Weeks 1-2: Prerequisite Diagnostic & Core Vocabulary\n";
            $planContent .= "- Focus on mapping definitions, simple arithmetic/reading, and resolving basic misconceptions about \"" . $issue . "\". Use " . $style . " format.\n\n";
            $planContent .= "#### Weeks 3-4: Controlled Skill Application\n";
            $planContent .= "- Introduce standard problems. Complete daily 10-minute practice worksheets targeting \"" . $issue . "\".\n\n";
            $planContent .= "#### Weeks 5-6: Independent Problem Solving\n";
            $planContent .= "- Transition student away from scaffolds. Student resolves intermediate worksheets in " . $subjectName . " independently.\n\n";
            $planContent .= "#### Weeks 7-8: Mock Assessments & Verification\n";
            $planContent .= "- Conduct timed assessment runs. Teacher reviews feedback ratings and completes evaluation loop.\n";
        } elseif (str_contains($durationLower, 'semester')) {
            $planContent .= "#### Month 1: Baseline Gap Analysis & Diagnostics\n";
            $planContent .= "- Conduct comprehensive reviews on " . $subjectName . " foundational chapters. Establish visual formula/concept index boards.\n\n";
            $planContent .= "#### Month 2: Guided Curriculum Alignment\n";
            $planContent .= "- Address \"" . $issue . "\" in alignment with class lectures. Deliver specialized " . $style . " worksheets weekly.\n\n";
            $planContent .= "#### Month 3: Speed & Rigor Sprints\n";
            $planContent .= "- Transition to mock exams and error journals. Review common pitfalls and self-correction techniques.\n\n";
            $planContent .= "#### Month 4: Final Mastery Review\n";
            $planContent .= "- Complete cumulative examinations and review progress records. Goal: Raise subject score past next milestone.\n";
        } else {
            // Default to 4 Weeks
            $planContent .= "#### Week 1: Foundational Review\n";
            $planContent .= "- **Goal:** Set up basic definitions and rules for \"" . $issue . "\" using " . $style . ".\n";
            $planContent .= "- **Activity:** Diagnostic check and 1-on-1 vocabulary/formula walkthrough.\n";
            
            $planContent .= "\n#### Week 2: Guided Practice\n";
            $planContent .= "- **Goal:** Bridge the primary learning issue through progressive difficulty exercises.\n";
            if ($marksPercentage < 45) {
                $planContent .= "- **Activity:** Solve 5 simplified worksheets together with the tutor. Focus on repeating rules.\n";
            } else {
                $planContent .= "- **Activity:** Complete standard exercise chapters with partial hints.\n";
            }

            $planContent .= "\n#### Week 3: Independent Practice\n";
            $planContent .= "- **Goal:** Build confidence and remove instructional scaffolds.\n";
            if ($marksPercentage < 45) {
                $planContent .= "- **Activity:** Solve standard worksheets independently. Flag difficult areas for Week 4 review.\n";
            } else {
                $planContent .= "- **Activity:** Complete timed quizzes and review error logs with the teacher.\n";
            }

            $planContent .= "\n#### Week 4: Final Evaluation\n";
            $planContent .= "- **Goal:** Validate comprehension and evaluate improvement percentage.\n";
            $planContent .= "- **Activity:** Administer final milestone evaluation. Recalculate student risk rating.\n";
        }

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
