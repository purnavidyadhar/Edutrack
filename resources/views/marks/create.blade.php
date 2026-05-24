@extends('layouts.dashboard')

@section('header', 'Upload Academic Records')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card overflow-hidden">
        <div class="border-b border-gray-100 px-8 py-6 bg-white/50">
            <h2 class="text-xl font-display font-bold text-gray-900">Enter Marks</h2>
            <p class="text-sm text-gray-500 mt-1">Upload subject-wise marks for algorithmic risk evaluation.</p>
        </div>
        
        <form action="{{ route('marks.store') }}" method="POST" class="p-8 space-y-6 bg-white/30">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Student</label>
                    <select name="student_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Subject</label>
                    <select name="subject_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Marks Obtained</label>
                    <input type="number" name="marks_obtained" required step="0.1" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Total Marks</label>
                    <input type="number" name="total_marks" required value="100" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Exam Type</label>
                    <select name="exam_type" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                        <option value="Mid Term">Mid Term</option>
                        <option value="Final Exam">Final Exam</option>
                        <option value="Unit Test">Unit Test</option>
                    </select>
                </div>
            </div>

            <div class="pt-6 mt-6 flex items-center justify-end border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] flex items-center gap-2 transition-all">
                    Upload Records <i data-lucide="upload" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
