@extends('layouts.dashboard')

@section('header', 'Edit Student Details')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('plans.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="wand-2" class="w-4 h-4"></i> AI Remedial Plans
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass-card overflow-hidden">
        <div class="border-b border-gray-100 px-8 py-6 bg-white/50">
            <h2 class="text-xl font-display font-bold text-gray-900">Modify Student Profile</h2>
            <p class="text-sm text-gray-500 mt-1">Update demographic and course details for {{ $student->user->name }}.</p>
        </div>
        
        <form action="{{ route('students.update', $student->id) }}" method="POST" class="p-8 space-y-6 bg-white/30">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $student->user->name) }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $student->user->email) }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Roll Number</label>
                    <input type="text" name="roll_number" value="{{ old('roll_number', $student->roll_number) }}" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Class / Department</label>
                    <select name="edu_class_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('edu_class_id', $student->edu_class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 mt-6 flex items-center justify-end border-t border-gray-100">
                <a href="{{ route('students.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors mr-4">Cancel</a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] flex items-center gap-2 transition-all">
                    Save Changes <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
