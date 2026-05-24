<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EduClass;

class ClassManagementController extends Controller
{
    public function index()
    {
        $classes = EduClass::withCount('students')->paginate(10);
        return view('classes.index', compact('classes'));
    }
}
