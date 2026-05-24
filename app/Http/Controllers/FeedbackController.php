<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TeacherFeedback;
use App\Models\Teacher;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function showForm(Student $student)
    {
        return view('feedback.send', ['student' => $student]);
    }

    public function sendFeedback(Request $request, Student $student)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'feedback' => 'required|string|max:1000',
            'type' => 'required|in:progress,encouragement,improvement,achievement',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $user = auth()->user();
        $teacher = $user->teacher ?: Teacher::firstOrCreate(['user_id' => $user->id]);

        TeacherFeedback::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'title' => $request->title,
            'feedback' => $request->feedback,
            'type' => $request->type,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Feedback sent to ' . $student->user->name . ' successfully!');
    }

    public function quickRating(Request $request, Student $student)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:200',
        ]);

        $user = auth()->user();
        $teacher = $user->teacher ?: Teacher::firstOrCreate(['user_id' => $user->id]);

        $messages = [
            5 => '🌟 Excellent work! Keep it up!',
            4 => '👍 Good progress! Well done!',
            3 => '📚 Doing well. Practice more!',
            2 => '⚡ Let\'s improve together!',
            1 => '💪 Don\'t give up! You can do better!',
        ];

        TeacherFeedback::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'title' => 'Quick Rating: ' . ['Poor', 'Needs Help', 'Average', 'Good', 'Excellent'][$request->rating - 1],
            'feedback' => $request->message ?? $messages[$request->rating],
            'type' => $request->rating >= 4 ? 'achievement' : ($request->rating <= 2 ? 'improvement' : 'progress'),
            'rating' => $request->rating,
        ]);

        return response()->json(['success' => true, 'message' => 'Rating sent!']);
    }

    public function markAsRead(TeacherFeedback $feedback)
    {
        $student = auth()->user()->student;
        if (!$student || $feedback->student_id !== $student->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $feedback->update(['is_read' => true]);
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Feedback marked as read.');
    }

    public function myFeedbacks()
    {
        $student = auth()->user()->student;
        if (!$student) {
            abort(403, 'Not a student account');
        }

        $feedbacks = $student->feedbacks()->latest()->paginate(10);
        return view('student.feedbacks', ['feedbacks' => $feedbacks]);
    }
}