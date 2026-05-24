<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\RemedialPlan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function welcome()
    {
        $totalStudents = Student::count();
        $slowLearnersCount = Student::where('risk_score', '<', 60)->count();
        $interventionsCount = RemedialPlan::count();
        
        return view('welcome', compact('totalStudents', 'slowLearnersCount', 'interventionsCount'));
    }

    public function index()
    {
        return redirect()->route('dashboard');
    }
}
