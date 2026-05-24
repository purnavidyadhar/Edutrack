<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\RemedialPlan;
use App\Models\Mark;
use App\Models\EduClass;
use App\Models\Subject;

class ReportsController extends Controller
{
    public function index()
    {
        // Analytics Cards
        $totalStudents = Student::count();
        $avgScore = Mark::avg('marks_obtained') ?? 0;
        $atRiskCount = Student::where('risk_score', '<', 75)->count();
        $improvementRate = 12.5; // Simulated for demo
        $completedPlans = RemedialPlan::where('status', 'Completed')->count();

        // Chart Data (Fully dynamic)
        $performanceTrend = \App\Models\Mark::selectRaw('DATE(created_at) as date, AVG(marks_obtained) as avg_score')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->take(6)
            ->pluck('avg_score')
            ->map(function($score) { return round($score, 1); })
            ->toArray();
            
        $classDistribution = [
            'labels' => EduClass::pluck('name')->toArray(),
            'data' => EduClass::withCount(['students as slow_learners_count' => function($query) {
                $query->where('risk_score', '<', 60);
            }])->get()->pluck('slow_learners_count')->toArray()
        ];
        
        $weaknesses = Mark::where('marks_obtained', '<', 50)
            ->with('subject')
            ->get()
            ->groupBy(function($mark) {
                return $mark->subject ? $mark->subject->name : 'Unknown';
            })
            ->map->count();
            
        $subjectWeakness = [
            'labels' => $weaknesses->keys()->toArray(),
            'data' => $weaknesses->values()->toArray()
        ];

        return view('pages.reports', compact(
            'totalStudents', 'avgScore', 'atRiskCount', 'improvementRate', 
            'completedPlans', 'performanceTrend', 'classDistribution', 'subjectWeakness'
        ));
    }
}
