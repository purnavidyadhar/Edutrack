<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\EduClass;
use App\Models\RemedialPlan;

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
}
