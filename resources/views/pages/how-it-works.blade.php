@extends('layouts.public')
@section('title', 'How It Works')
@section('content')
<div class="max-w-4xl mx-auto space-y-16 py-8">
    <div class="text-center space-y-4">
        <h2 class="text-4xl font-display font-extrabold text-gray-900">How It Works</h2>
        <p class="text-lg text-gray-500 font-medium">A structured 7-step approach to educational empowerment.</p>
    </div>

    <div class="space-y-12">
        @php
        $steps = [
            ['title' => 'Step 1: Student Data Collection', 'desc' => 'The system collects marks, attendance, assignments, quizzes, and participation data.', 'icon' => 'database'],
            ['title' => 'Step 2: Performance Analysis', 'desc' => 'The system analyzes academic performance, learning patterns, and engagement levels.', 'icon' => 'line-chart'],
            ['title' => 'Step 3: Slow Learner Identification', 'desc' => 'Students are classified based on a multi-factor risk score and subject-wise weaknesses.', 'icon' => 'user-check'],
            ['title' => 'Step 4: Remedial Plan Creation', 'desc' => 'Teachers create personalized, structured remedial teaching plans based on student needs.', 'icon' => 'wand-2'],
            ['title' => 'Step 5: Innovative Teaching Support', 'desc' => 'Suggesting modern methods like visual learning, gamification, and activity-based learning.', 'icon' => 'lightbulb'],
            ['title' => 'Step 6: Progress Monitoring', 'desc' => 'Teachers track improvement weekly or monthly using interactive charts and reports.', 'icon' => 'trending-up'],
            ['title' => 'Step 7: Capacity Building', 'desc' => 'The system helps students improve confidence, participation, and learning habits.', 'icon' => 'sparkles'],
        ];
        @endphp

        @foreach($steps as $index => $step)
        <div class="flex gap-8 relative">
            @if(!$loop->last)
                <div class="absolute left-[27px] top-14 bottom-[-48px] w-1 bg-brand-100 rounded-full"></div>
            @endif
            <div class="w-14 h-14 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center shrink-0 relative z-10 shadow-sm">
                <i data-lucide="{{ $step['icon'] }}" class="w-7 h-7 text-brand-500"></i>
            </div>
            <div class="glass-card p-8 flex-1 bg-white">
                <span class="text-xs font-black text-brand-500 uppercase tracking-[0.2em] mb-2 block">Level {{ $index + 1 }}</span>
                <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $step['title'] }}</h4>
                <p class="text-gray-500 font-medium leading-relaxed">{{ $step['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
