@extends('layouts.dashboard')

@section('header', 'Add New Student')

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
<div class="max-w-2xl mx-auto animate-fadeInUp">
    <div class="glass-card overflow-hidden enhanced-card">
        <div class="border-b border-gray-100 px-8 py-6 bg-gradient-to-r from-blue-50 to-purple-50 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-32 h-32 bg-blue-200 rounded-full blur-2xl opacity-30 animate-float"></div>
            <div class="relative z-10">
                <h2 class="text-xl font-display font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl grid place-items-center animate-scaleIn">
                        <i data-lucide="user-plus" class="w-6 h-6"></i>
                    </div>
                    Register New Student
                </h2>
                <p class="text-sm text-gray-500 mt-2">Add a new student to EduTrack's intelligent learning system.</p>
            </div>
        </div>
        
        <form action="{{ route('students.store') }}" method="POST" class="p-8 space-y-6 bg-white/30">
            @csrf
            
            <div class="space-y-2 animate-slideInLeft">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4 text-blue-600"></i> Full Name
                </label>
                <input type="text" name="name" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm placeholder-gray-400" placeholder="e.g. Jane Doe">
            </div>

            <div class="space-y-2 animate-slideInRight">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4 text-blue-600"></i> Email Address
                </label>
                <input type="email" name="email" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm placeholder-gray-400" placeholder="student@example.com">
            </div>

            <div class="grid grid-cols-2 gap-6 animate-fadeInUp">
                <div class="space-y-2 animate-slideInLeft">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                        <i data-lucide="hash" class="w-4 h-4 text-blue-600"></i> Roll Number
                    </label>
                    <input type="text" name="roll_number" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm placeholder-gray-400" placeholder="e.g. CS-2023-01">
                </div>
                
                <div class="space-y-2 animate-slideInRight">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                        <i data-lucide="book" class="w-4 h-4 text-blue-600"></i> Class / Department
                    </label>
                    <select name="edu_class_id" required class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all shadow-sm">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-6 mt-6 flex items-center justify-end border-t border-gray-100 gap-3 animate-slideInRight">
                <a href="{{ route('students.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-800 transition-colors btn-animated">Cancel</a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] flex items-center gap-2 transition-all btn-animated">
                    <i data-lucide="check-circle" class="w-5 h-5 animate-pulse-custom"></i> Register Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
