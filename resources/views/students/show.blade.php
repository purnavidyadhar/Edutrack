@extends('layouts.dashboard')

@section('header', 'Student Profile')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
@endsection

@section('content')
<div class="space-y-6 max-w-5xl mx-auto animate-fadeInUp">
    
    <div class="flex items-center gap-2 mb-4 animate-slideInLeft">
        <a href="{{ route('students.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors"><i data-lucide="arrow-left" class="w-4 h-4"></i> Back</a>
    </div>

    <!-- Hero Profile Card -->
    <div class="glass-card p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden enhanced-card animate-slideInDown">
        <div class="absolute right-0 top-0 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50 animate-pulse-custom"></div>
        <div class="flex items-center gap-6 relative z-10">
            <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-display font-bold text-4xl shadow-[0_0_30px_rgba(59,130,246,0.3)] animate-scaleIn">
                {{ substr($student->user->name, 0, 1) }}
            </div>
            <div class="animate-slideInLeft">
                <h1 class="text-3xl font-display font-bold text-gray-900">{{ $student->user->name }}</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Roll: {{ $student->roll_number }} • Class: {{ $student->eduClass->name ?? 'N/A' }} • {{ $student->user->email }}</p>
                <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white border border-gray-200 shadow-sm status-badge">
                    Risk Score: <span class="text-blue-600 text-sm">{{ number_format($student->risk_score, 1) }}</span>
                </div>
            </div>
        </div>
        <div class="relative z-10 flex flex-wrap items-center gap-3 animate-slideInRight">
            <a href="{{ route('students.edit', $student->id) }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:shadow transition-all btn-animated">Edit</a>
            
            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student and all their records?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 text-sm font-bold rounded-xl shadow-sm transition-all btn-animated">Delete</button>
            </form>

            <form action="{{ route('students.evaluate', $student->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-brand-50 hover:bg-brand-100 border border-brand-200 text-brand-700 text-sm font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 btn-animated">
                    <i data-lucide="sparkles" class="w-4 h-4 text-brand-500 animate-spin-slow"></i> Evaluate Risk
                </button>
            </form>
            
            <a href="{{ route('plans.create') }}?student_id={{ $student->id }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] transition-all flex items-center gap-1.5 btn-animated">
                <i data-lucide="wand-2" class="w-4 h-4"></i> New Plan
            </a>

            <a href="{{ route('feedback.send', $student->id) }}" class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-bold rounded-xl shadow-[0_0_20px_rgba(16,185,129,0.3)] transition-all flex items-center gap-1.5 btn-animated">
                <i data-lucide="message-square" class="w-4 h-4"></i> Send Feedback
            </a>
        </div>
    </div>

    <!-- Analytics Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 dashboard-grid">
        <div class="glass-card p-6 enhanced-card">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Average Marks</p>
            <div class="flex items-end gap-2">
                <h3 class="font-display text-4xl font-extrabold text-gray-900">{{ number_format($avgMarks, 1) }}%</h3>
                <div class="w-8 h-8 text-emerald-500"><i data-lucide="trending-up" class="w-8 h-8 animate-float"></i></div>
            </div>
        </div>
        <div class="glass-card p-6 enhanced-card">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Attendance</p>
            <div class="flex items-end gap-2">
                <h3 class="font-display text-4xl font-extrabold text-gray-900">{{ number_format($attendance, 1) }}%</h3>
                <div class="w-8 h-8 text-blue-500"><i data-lucide="calendar-check" class="w-8 h-8 animate-pulse-custom"></i></div>
            </div>
        </div>
        <div class="glass-card p-6 enhanced-card">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Status Classification</p>
            <h3 class="font-display text-xl font-bold text-gray-900 mt-2">
                @if($student->risk_level === 'Critical Support Needed')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-red-50 text-red-700 border border-red-100 status-badge animate-pulse-custom"><span class="status-dot bg-red-500"></span>Critical</span>
                @elseif($student->risk_level === 'Slow Learner')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-orange-50 text-orange-700 border border-orange-100 status-badge"><span class="status-dot bg-orange-500"></span>Slow Learner</span>
                @elseif($student->risk_level === 'Needs Attention')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 status-badge"><span class="status-dot bg-yellow-500"></span>Needs Attention</span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-bold bg-green-50 text-green-700 border border-green-100 status-badge"><span class="status-dot bg-green-500"></span>Good</span>
                @endif
            </h3>
        </div>
    </div>

    <!-- Tabs Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-stagger">
        <!-- Academic Performance -->
        <div class="glass-card overflow-hidden flex flex-col enhanced-card">
            <div class="px-6 py-5 border-b border-gray-100 bg-white/50 animate-slideInLeft">
                <h3 class="font-display font-bold text-lg text-gray-900 flex items-center gap-2"><i data-lucide="book-open" class="w-5 h-5 text-blue-600 animate-float"></i>Academic Records</h3>
            </div>
            <div class="p-0 flex-1 bg-white/30">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-100 animate-stagger">
                        @forelse($student->marks as $mark)
                        <tr class="hover:bg-white/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $mark->subject->name ?? 'Subject' }}</td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $mark->exam_type }}</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-600">{{ $mark->marks_obtained }} / {{ $mark->total_marks }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 font-medium animate-slideUp">No marks recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Feedback Widget -->
        <div class="glass-card enhanced-card animate-slideInRight" style="animation-delay: 0.1s;">
            @include('feedback.quick-rating', ['student' => $student])
        </div>
    </div>

    <!-- Remedial Plans Section -->
    <div class="glass-card overflow-hidden enhanced-card">
        <div class="px-6 py-5 border-b border-gray-100 bg-white/50 animate-slideInLeft">
            <h3 class="font-display font-bold text-lg text-gray-900 flex items-center gap-2"><i data-lucide="lightbulb" class="w-5 h-5 text-purple-600 animate-float" style="animation-delay: 0.5s;"></i>Remedial Plans</h3>
        </div>
        <div class="p-6 bg-white/30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-stagger">
                @forelse($student->remedialPlans as $plan)
                <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm enhanced-card hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-gray-900">{{ $plan->subject }}</h4>
                        <span class="status-badge text-xs font-bold px-2 py-1 bg-blue-50 text-blue-600"><span class="status-dot bg-blue-600"></span>{{ $plan->status }}</span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-2">{{ $plan->learning_issue }}</p>
                    <a href="{{ route('plans.show', $plan->id) }}" class="mt-3 inline-flex text-sm font-bold text-blue-600 hover:text-blue-800 transition hover:underline"><i data-lucide="chevron-right" class="w-4 h-4"></i> View Details</a>
                </div>
                @empty
                <div class="text-center py-8 animate-slideUp col-span-full">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl grid place-items-center mx-auto mb-2">
                        <i data-lucide="inbox" class="w-6 h-6"></i>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">No active remedial plans.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Feedback History Section -->
    @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin')
        <div class="glass-card enhanced-card animate-slideInUp">
            <div class="px-6 py-5 border-b border-gray-100 bg-white/50 animate-slideInLeft">
                <h3 class="font-display font-bold text-lg text-gray-900 flex items-center gap-2"><i data-lucide="message-circle" class="w-5 h-5 text-green-600 animate-float"></i>Feedback Sent to This Student</h3>
            </div>
            <div class="p-6 bg-white/30">
                @php
                    $feedbacks = $student->feedbacks()->latest()->get();
                @endphp
                
                @if ($feedbacks->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl grid place-items-center mx-auto mb-2">
                            <i data-lucide="message-square" class="w-6 h-6"></i>
                        </div>
                        <p class="text-sm text-gray-500 font-medium">No feedback sent yet. Click "Send Feedback" above to get started!</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($feedbacks as $feedback)
                            <div class="bg-white border-l-4 rounded-lg p-4 
                                {{ $feedback->type === 'achievement' ? 'border-green-500 bg-gradient-to-r from-green-50' : 
                                   ($feedback->type === 'encouragement' ? 'border-blue-500 bg-gradient-to-r from-blue-50' :
                                   ($feedback->type === 'improvement' ? 'border-orange-500 bg-gradient-to-r from-orange-50' : 'border-indigo-500 bg-gradient-to-r from-indigo-50')) }}
                                to-transparent hover:shadow-md transition-all"
                                style="animation: slideInLeft 0.5s ease-out;">
                                
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold
                                                {{ $feedback->type === 'achievement' ? 'bg-green-100 text-green-800' : 
                                                   ($feedback->type === 'encouragement' ? 'bg-blue-100 text-blue-800' :
                                                   ($feedback->type === 'improvement' ? 'bg-orange-100 text-orange-800' : 'bg-indigo-100 text-indigo-800')) }}">
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
                                        </div>
                                        
                                        <h4 class="font-semibold text-gray-900">{{ $feedback->title }}</h4>
                                        <p class="text-sm text-gray-600">From: <strong>{{ $feedback->teacher->user->name }}</strong></p>
                                        <p class="text-sm text-gray-700 mt-2">{{ $feedback->feedback }}</p>
                                    </div>
                                    <time class="text-xs text-gray-500 whitespace-nowrap">
                                        {{ $feedback->created_at->format('M d, Y') }}
                                    </time>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
