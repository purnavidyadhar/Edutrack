<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eduClass()
    {
        return $this->belongsTo(EduClass::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function remedialPlans()
    {
        return $this->hasMany(RemedialPlan::class);
    }

    public function progressRecords()
    {
        return $this->hasMany(ProgressRecord::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(TeacherFeedback::class);
    }

    public function helpRequests()
    {
        return $this->hasMany(HelpRequest::class);
    }

    public function recalculateRiskScore()
    {
        $this->load(['marks', 'attendances']);

        $examScore = $this->marks()->avg('marks_obtained') ?? 0;
        $quizScore = $this->marks()->where('exam_type', 'quiz')->avg('marks_obtained') ?? $examScore;
        $assignmentCompletion = \App\Models\Assignment::where('student_id', $this->id)->avg('score') ?? $examScore;
        $attendance = $this->attendances()->avg('percentage') ?? 0;

        $progressSignal = \App\Models\ProgressRecord::where('student_id', $this->id)->avg('improvement_percentage') ?? 0;
        $participation = min(100, max(0, 55 + $progressSignal));

        $riskScore = ($examScore * 0.40) + ($quizScore * 0.15) + ($assignmentCompletion * 0.15) + ($attendance * 0.20) + ($participation * 0.10);

        $riskLevel = 'Good Performer';
        if ($riskScore < 40) {
            $riskLevel = 'Critical Support Needed';
        } elseif ($riskScore < 60) {
            $riskLevel = 'Slow Learner';
        } elseif ($riskScore < 75) {
            $riskLevel = 'Needs Attention';
        }

        $this->update([
            'risk_score' => round($riskScore, 2),
            'risk_level' => $riskLevel
        ]);
    }
}
