@extends('layouts.dashboard')

@section('title', 'My Feedback History')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <section class="neo-card relative overflow-hidden p-7 md:p-10 animate-fadeInUp">
        <div class="orb w-72 h-72 bg-blue-400 -top-20 -right-20 animate-float"></div>
        <div class="relative animate-slideInLeft">
            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 border border-blue-100 px-4 py-2 text-blue-700 text-xs font-black uppercase tracking-widest mb-5">
                <i data-lucide="inbox" class="w-4 h-4"></i> Message Center
            </div>
            <h1 class="font-display font-black text-4xl md:text-5xl tracking-tight leading-[1.02] mb-2">
                My <span class="gradient-title">Feedback History</span>
            </h1>
            <p class="text-slate-600 text-lg max-w-2xl">Review feedback from your teachers. This helps you track your progress and understand areas to focus on.</p>
        </div>
    </section>

    <!-- Stats Row -->
    <div class="grid sm:grid-cols-3 gap-5 dashboard-grid">
        <div class="soft-card p-6 enhanced-card">
            <p class="mini-label">Total Feedback</p>
            <div class="mt-4 font-display font-black text-4xl">{{ $feedbacks->total() }}</div>
            <p class="text-sm text-slate-500 mt-2">Messages from teachers</p>
        </div>
        <div class="soft-card p-6 enhanced-card">
            <p class="mini-label">Unread</p>
            <div class="mt-4 font-display font-black text-4xl text-blue-600">
                {{ $feedbacks->getCollection()->where('is_read', false)->count() }}
            </div>
            <p class="text-sm text-slate-500 mt-2">New messages</p>
        </div>
        <div class="soft-card p-6 enhanced-card">
            <p class="mini-label">Recent Type</p>
            <div class="mt-4 font-display font-black text-2xl">
                @php
                    $lastType = $feedbacks->getCollection()->first()?->type ?? 'progress';
                    echo match($lastType) {
                        'achievement' => '🌟 Achievement',
                        'encouragement' => '💪 Encouragement',
                        'improvement' => '⚡ Improvement',
                        default => '📈 Progress'
                    };
                @endphp
            </div>
            <p class="text-sm text-slate-500 mt-2">Latest message type</p>
        </div>
    </div>

    <!-- Feedback List -->
    <section class="space-y-4 animate-fadeInUp">
        @if ($feedbacks->isEmpty())
            <div class="soft-card p-12 text-center enhanced-card">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl grid place-items-center mx-auto mb-4">
                    <i data-lucide="inbox" class="w-10 h-10"></i>
                </div>
                <h3 class="font-display font-black text-2xl mt-4">No feedback yet</h3>
                <p class="text-slate-500 mt-2">Your teachers will share feedback here to help you improve. Check back soon!</p>
            </div>
        @else
            <div class="space-y-4 animate-stagger">
                @foreach ($feedbacks as $feedback)
                    <div class="soft-card p-6 border-l-4 enhanced-card hover:shadow-lg transition-all
                        {{ $feedback->type === 'achievement' ? 'border-green-500 bg-gradient-to-r from-green-50' : 
                           ($feedback->type === 'encouragement' ? 'border-blue-500 bg-gradient-to-r from-blue-50' :
                           ($feedback->type === 'improvement' ? 'border-orange-500 bg-gradient-to-r from-orange-50' : 'border-indigo-500 bg-gradient-to-r from-indigo-50')) }}
                        to-transparent"
                        style="animation: slideInLeft 0.5s ease-out;">
                        
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-black
                                        {{ $feedback->type === 'achievement' ? 'bg-green-200 text-green-800' : 
                                           ($feedback->type === 'encouragement' ? 'bg-blue-200 text-blue-800' :
                                           ($feedback->type === 'improvement' ? 'bg-orange-200 text-orange-800' : 'bg-indigo-200 text-indigo-800')) }}">
                                        @switch($feedback->type)
                                            @case('achievement')
                                                🌟 Achievement
                                                @break
                                            @case('encouragement')
                                                💪 Encouragement
                                                @break
                                            @case('improvement')
                                                ⚡ Improvement
                                                @break
                                            @default
                                                📈 Progress
                                        @endswitch
                                    </span>
                                    
                                    @if ($feedback->rating)
                                        <span class="text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $feedback->rating)
                                                    <span class="text-yellow-400">⭐</span>
                                                @else
                                                    <span class="text-gray-300">⭐</span>
                                                @endif
                                            @endfor
                                        </span>
                                    @endif
                                    
                                    @if (!$feedback->is_read)
                                        <span class="animate-pulse inline-block w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                
                                <h3 class="text-lg font-black text-gray-900">{{ $feedback->title }}</h3>
                                <p class="text-sm text-slate-600 mt-1">From: <strong>{{ $feedback->teacher->user->name }}</strong></p>
                            </div>
                            
                            <div class="text-right">
                                <time class="text-sm text-slate-500 font-bold block">
                                    {{ $feedback->created_at->format('M d, Y') }}
                                </time>
                                <p class="text-xs text-slate-400 mt-1">{{ $feedback->created_at->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-70 rounded-lg p-4 mb-4">
                            <p class="text-gray-900 text-base leading-relaxed">{{ $feedback->feedback }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500">
                                @if (!$feedback->is_read)
                                    <span class="text-blue-600 font-bold">🔵 New</span>
                                @else
                                    <span class="text-green-600 font-bold">✓ Read</span>
                                @endif
                            </span>
                            
                            @if (!$feedback->is_read)
                                <form action="{{ route('feedback.markRead', $feedback) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-bold transition hover:underline">
                                        Mark as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($feedbacks->hasPages())
                <div class="mt-8">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        @endif
    </section>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('student.dashboard') }}" class="btn-secondary btn-animated hover:shadow-lg">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
    </div>
</div>
@endsection
