@extends('layouts.public')
@section('title', 'Features')

@section('content')
<div class="py-24 px-6 max-w-7xl mx-auto space-y-16">
    <div class="text-center space-y-4">
        <h1 class="text-5xl font-display font-extrabold text-brand-950">Core Features</h1>
        <p class="text-xl text-[#64748B] max-w-2xl mx-auto font-medium">A comprehensive suite of tools designed for modern educational institutions.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="glass-card p-8 space-y-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xl font-bold text-brand-950">AI Risk Scoring</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Our multi-factor algorithm calculates risk scores based on exams, attendance, and participation in real-time.</p>
        </div>
        <div class="glass-card p-8 space-y-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 shadow-sm">
                <i data-lucide="wand-2" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xl font-bold text-brand-950">AI Remedial Plans</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Generate structured, week-by-week intervention strategies tailored to each student's specific learning style.</p>
        </div>
        <div class="glass-card p-8 space-y-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 shadow-sm">
                <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xl font-bold text-brand-950">Advanced Analytics</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Visualize institutional performance with heatmaps and trajectory charts that predict future outcomes.</p>
        </div>
    </div>
</div>
@endsection
