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
}
