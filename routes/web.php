<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RemedialPlanController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\TeacherManagementController;
use App\Http\Controllers\ClassManagementController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'welcome'])->name('welcome');
Route::get('/about', fn() => view('pages.about'))->name('about');
Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');
Route::view('/features', 'pages.features')->name('features');
Route::view('/resources', 'pages.resources')->name('resources');
Route::view('/contact', 'pages.contact')->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    })->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/teachers', [TeacherManagementController::class, 'index'])->name('teachers.index');
        Route::get('/classes', [ClassManagementController::class, 'index'])->name('classes.index');
        Route::get('/admin/tools', [AdminController::class, 'showTools'])->name('admin.tools');
        Route::post('/admin/tools/update-marks', [AdminController::class, 'updateMarks'])->name('admin.tools.updateMarks');
        Route::post('/admin/tools/update-attendance', [AdminController::class, 'updateAttendance'])->name('admin.tools.updateAttendance');
        Route::post('/admin/tools/announcement', [AdminController::class, 'storeAnnouncement'])->name('admin.tools.storeAnnouncement');
        Route::post('/admin/tools/feedback/{feedback}/update', [AdminController::class, 'updateFeedback'])->name('admin.tools.updateFeedback');
        Route::delete('/admin/tools/feedback/{feedback}', [AdminController::class, 'deleteFeedback'])->name('admin.tools.deleteFeedback');
    });

    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
        Route::resource('students', StudentController::class);
        Route::post('students/{student}/evaluate', [StudentController::class, 'evaluate'])->name('students.evaluate');
        Route::resource('plans', RemedialPlanController::class)->except(['destroy']);
        Route::post('plans/{plan}/complete', [RemedialPlanController::class, 'complete'])->name('plans.complete');
        Route::post('plans/{plan}/progress', [RemedialPlanController::class, 'addProgress'])->name('plans.progress');
        Route::get('/marks/upload', [MarksController::class, 'create'])->name('marks.create');
        Route::post('/marks/store', [MarksController::class, 'store'])->name('marks.store');
        
        // Feedback routes
        Route::get('/students/{student}/feedback/send', [FeedbackController::class, 'showForm'])->name('feedback.send');
        Route::post('/students/{student}/feedback', [FeedbackController::class, 'sendFeedback'])->name('feedback.submit');
        Route::post('/students/{student}/rating', [FeedbackController::class, 'quickRating'])->name('feedback.rate');
        Route::post('/teacher/help-request/{helpRequest}/resolve', [TeacherController::class, 'resolveHelpRequest'])->name('teacher.help.resolve');
    });

    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/my-plan/{plan}', [StudentDashboardController::class, 'showPlan'])->name('student.plan.show');
        Route::post('/student/help-request', [StudentDashboardController::class, 'storeHelpRequest'])->name('student.help.store');
        Route::post('/plans/{plan}/confidence', [StudentDashboardController::class, 'submitConfidence'])->name('student.plan.confidence');
        
        // Feedback routes for students
        Route::get('/my-feedbacks', [FeedbackController::class, 'myFeedbacks'])->name('student.feedbacks');
        Route::post('/feedbacks/{feedback}/read', [FeedbackController::class, 'markAsRead'])->name('feedback.markRead');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
