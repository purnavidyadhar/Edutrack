<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\EduClass;
use App\Models\Mark;
use App\Models\Subject;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'eduClass']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('roll_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('edu_class_id', $request->class_id);
        }

        if ($request->filled('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $students = $query->orderBy('risk_score', 'asc')->paginate(15)->withQueryString();
        $classes = EduClass::all();

        return view('students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = EduClass::all();
        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'edu_class_id' => 'required|exists:edu_classes,id',
            'roll_number' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'edu_class_id' => $request->edu_class_id,
            'roll_number' => $request->roll_number,
            'risk_score' => 85, // Default safe score
            'risk_level' => 'Good Performer'
        ]);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['user', 'eduClass', 'marks.subject', 'remedialPlans.progressRecords', 'attendances']);
        
        // Calculate averages for the profile view
        $avgMarks = $student->marks->avg('marks_obtained') ?? 0;
        $attendance = $student->attendances->avg('percentage') ?? 0;
        
        return view('students.show', compact('student', 'avgMarks', 'attendance'));
    }

    public function evaluate(Student $student)
    {
        $student->recalculateRiskScore();

        return redirect()->back()->with('success', 'Evaluation updated from real marks, attendance and progress records. Score: ' . round($student->risk_score, 1) . ' (' . $student->risk_level . ')');
    }

    public function edit(Student $student)
    {
        $classes = EduClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'edu_class_id' => 'required|exists:edu_classes,id',
            'roll_number' => 'required|string',
        ]);

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $student->update([
            'edu_class_id' => $request->edu_class_id,
            'roll_number' => $request->roll_number,
        ]);

        return redirect()->route('students.index')->with('success', 'Student details updated successfully.');
    }

    public function destroy(Student $student)
    {
        $user = $student->user;
        $student->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('students.index')->with('success', 'Student record deleted successfully.');
    }
}
