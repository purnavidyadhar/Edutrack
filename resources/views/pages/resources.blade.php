@extends('layouts.public')
@section('title', 'Resources')
@section('content')
<div class="py-24 px-6 max-w-7xl mx-auto space-y-16">
    <div class="text-center space-y-4">
        <h1 class="text-5xl font-display font-extrabold text-brand-950">Educational Resources</h1>
        <p class="text-xl text-[#64748B] max-w-2xl mx-auto font-medium">Empower slow learners with premium materials, targeted worksheets, and learning activities.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
        $resources = [
            ['title' => 'Fundamental Math Worksheets', 'category' => 'Worksheets', 'difficulty' => 'Beginner', 'subject' => 'Mathematics'],
            ['title' => 'Visual Science Concept Maps', 'category' => 'Concept Maps', 'difficulty' => 'Intermediate', 'subject' => 'Science'],
            ['title' => 'English Grammar Video Lessons', 'category' => 'Video Lessons', 'difficulty' => 'All Levels', 'subject' => 'English'],
            ['title' => 'Historical Timeline Activity', 'category' => 'Remedial Activities', 'difficulty' => 'Beginner', 'subject' => 'History'],
            ['title' => 'Gamified Science Quiz Pack', 'category' => 'Practice Quizzes', 'difficulty' => 'All Levels', 'subject' => 'Science'],
            ['title' => 'Effective Study Guide 2026', 'category' => 'Teacher Guides', 'difficulty' => 'Expert', 'subject' => 'General'],
        ];
        @endphp

        @foreach($resources as $item)
        <div class="glass-card overflow-hidden group">
            <div class="h-40 bg-gradient-to-br from-brand-500/10 to-accent/10 flex items-center justify-center border-b border-gray-100">
                <i data-lucide="file-text" class="w-12 h-12 text-brand-500 group-hover:scale-110 transition-transform"></i>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2 py-0.5 bg-brand-50 text-brand-600 text-[10px] font-bold rounded uppercase tracking-widest">{{ $item['category'] }}</span>
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded uppercase tracking-widest">{{ $item['difficulty'] }}</span>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $item['title'] }}</h4>
                <p class="text-sm text-gray-500 mb-6">Subject: {{ $item['subject'] }}</p>
                <div class="flex items-center justify-between">
                    <button onclick="alert('Starting download: {{ $item['title'] }} PDF worksheet package...')" class="text-sm font-bold text-brand-500 hover:text-brand-700 transition-colors">Download PDF</button>
                    <button onclick="alert('Opening secure interactive browser viewer for: {{ $item['title'] }}...')" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 transition-all">View Online</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
