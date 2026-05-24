<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Mark;

class MarksController extends Controller
{
    public function create()
    {
        $students = Student::with('user')->get();
        $subjects = Subject::all();
        return view('marks.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric',
            'exam_type' => 'required|string',
        ]);

        Mark::create($request->all());

        return redirect()->route('teacher.dashboard')->with('success', 'Marks uploaded successfully.');
    }
}
