<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\EduClass;
use App\Models\RemedialPlan;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\TeacherFeedback;
use App\Models\Announcement;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();
        $totalClasses = EduClass::count();
        $slowLearners = Student::where('risk_score', '<', 60)->count();
        $activePlans = RemedialPlan::where('status', 'Active')->count();
        
        $recentUsers = User::latest()->take(5)->get();
        $classDistribution = EduClass::withCount('students')->get();

        return view('admin.dashboard', compact(
            'totalTeachers', 'totalStudents', 'totalClasses', 'slowLearners', 'activePlans', 'recentUsers', 'classDistribution'
        ));
    }

    public function showTools(Request $request)
    {
        $students = Student::with('user', 'eduClass')->get();
        $subjects = Subject::all();
        $feedbacks = TeacherFeedback::with('student.user', 'teacher.user')->latest()->get();
        $announcements = Announcement::latest()->get();

        $selectedStudent = null;
        $studentMarks = collect();
        $studentAttendance = null;

        if ($request->has('student_id') && $request->student_id) {
            $selectedStudent = Student::with('user', 'marks.subject', 'attendances')->find($request->student_id);
            if ($selectedStudent) {
                $studentMarks = $selectedStudent->marks;
                $studentAttendance = $selectedStudent->attendances->first(); // Get the primary attendance record
            }
        }

        return view('admin.tools', compact(
            'students', 'subjects', 'feedbacks', 'announcements', 'selectedStudent', 'studentMarks', 'studentAttendance'
        ));
    }

    public function updateMarks(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1',
            'exam_type' => 'required|string|max:255',
        ]);

        $student = Student::findOrFail($request->student_id);

        Mark::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'exam_type' => $request->exam_type,
            ],
            [
                'marks_obtained' => $request->marks_obtained,
                'total_marks' => $request->total_marks,
            ]
        );

        $student->recalculateRiskScore();

        return redirect()->route('admin.tools', ['student_id' => $student->id])
            ->with('success', 'Student marks updated and risk score recalculated successfully!');
    }

    public function updateAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $student = Student::findOrFail($request->student_id);

        Attendance::updateOrCreate(
            ['student_id' => $request->student_id],
            ['percentage' => $request->percentage]
        );

        $student->recalculateRiskScore();

        return redirect()->route('admin.tools', ['student_id' => $student->id])
            ->with('success', 'Student attendance updated and risk score recalculated successfully!');
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'audience' => 'required|in:all,teachers,students',
        ]);

        Announcement::create($request->only('title', 'message', 'audience'));

        return redirect()->route('admin.tools')
            ->with('success', 'Global Announcement broadcasted successfully!');
    }

    public function updateFeedback(Request $request, TeacherFeedback $feedback)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'feedback' => 'required|string',
            'type' => 'required|in:achievement,encouragement,improvement,progress',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $feedback->update($request->only('title', 'feedback', 'type', 'rating'));

        return redirect()->route('admin.tools')
            ->with('success', 'Teacher feedback updated successfully!');
    }

    public function deleteFeedback(TeacherFeedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.tools')
            ->with('success', 'Teacher feedback deleted successfully!');
    }
}
