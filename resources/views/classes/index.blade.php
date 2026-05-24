@extends('layouts.dashboard')

@section('header', 'Institutional Classes')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Overview
    </a>
    <a href="{{ route('teachers.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="graduation-cap" class="w-4 h-4"></i> Teachers
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('classes.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="book-open" class="w-4 h-4"></i> Classes
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500 font-medium">Manage and organize all institutional departments and classes.</p>
        <button class="px-5 py-2.5 bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-500/20 hover:bg-brand-600 transition-all flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> New Class
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classes as $class)
        <div class="glass-card p-8 group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-500 group-hover:bg-brand-500 group-hover:text-white transition-all">
                    <i data-lucide="book-open" class="w-7 h-7"></i>
                </div>
                <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full uppercase tracking-widest">{{ $class->department ?? 'General' }}</span>
            </div>
            <h4 class="text-2xl font-display font-black text-gray-900 mb-1">{{ $class->name }}</h4>
            <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">{{ $class->students_count }} Students Enrolled</p>
            <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-6">
                <button class="text-sm font-bold text-brand-500 hover:text-brand-700">View Roster</button>
                <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:border-brand-500 hover:text-brand-500 transition-all"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
