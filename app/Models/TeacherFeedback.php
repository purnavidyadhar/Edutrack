<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherFeedback extends Model
{
    protected $table = 'teacher_feedbacks';
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
