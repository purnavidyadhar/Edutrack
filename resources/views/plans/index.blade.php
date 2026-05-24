@extends('layouts.dashboard')

@section('header', 'AI Remedial Plans')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('plans.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="wand-2" class="w-4 h-4"></i> AI Remedial Plans
    </a>
    <a href="{{ route('reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Analytics
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500 font-medium">Review and monitor all student intervention strategies.</p>
        <a href="{{ route('plans.create') }}" class="px-5 py-2.5 bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-500/20 hover:bg-brand-600 transition-all flex items-center gap-2">
            <i data-lucide="sparkles" class="w-4 h-4"></i> Generate New Plan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
        <div class="glass-card p-8 group hover:scale-[1.02] transition-all duration-300">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-500">
                    <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                </div>
                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-widest {{ $plan->status === 'Active' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $plan->status }}
                </span>
            </div>
            
            <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $plan->student->user->name }}</h4>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ $plan->subject }}</p>
            
            <div class="space-y-3 mb-6">
                <div class="flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                    <span class="text-sm text-gray-600 font-medium">Duration: {{ $plan->duration }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="zap" class="w-4 h-4 text-brand-500"></i>
                    <span class="text-sm text-gray-600 font-medium">Style: {{ $plan->preferred_style }}</span>
                </div>
            </div>

            <a href="{{ route('plans.show', $plan->id) }}" class="w-full py-3 border border-gray-100 group-hover:border-brand-500 group-hover:bg-brand-500 group-hover:text-white text-gray-600 font-bold rounded-xl flex items-center justify-center gap-2 transition-all">
                View Plan Details <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
