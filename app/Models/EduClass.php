<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EduClass extends Model
{
    protected $guarded = [];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
