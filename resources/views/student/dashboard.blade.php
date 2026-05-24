@extends('layouts.dashboard')
@section('title', 'Student Learning Space')
@section('content')
<div class="space-y-8 animate-fadeInUp">
    <!-- Header Hero Section -->
    <section class="glass-panel relative overflow-hidden p-8 md:p-10">
        <div class="relative grid lg:grid-cols-[1.5fr_1fr] gap-10 items-center">
            <div class="space-y-6 animate-slideInLeft">
                <div class="inline-flex items-center gap-2 rounded-full bg-purple-50 border border-purple-100 px-4 py-2 text-purple-700 text-xs font-black uppercase tracking-widest">
                    <i data-lucide="sparkles" class="w-4 h-4 animate-spin-slow"></i> Personal Learning Journey
                </div>
                <h1 class="font-display font-black text-4xl md:text-5xl tracking-tight leading-[1.02] text-slate-900">
                    Welcome back, <span class="gradient-title">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-slate-600 text-base leading-relaxed max-w-2xl font-medium">
                    Your simplified learning workspace. Review your active remedial plans, complete your daily missions, and ask for teacher support anytime you get stuck.
                </p>
                <div class="flex flex-wrap gap-3 pt-2">
                    <span class="btn-primary badge-enter">
                        <i data-lucide="award" class="w-5 h-5 text-yellow-400"></i> {{ $badge }}
                    </span>
                    @if($activePlan)
                        <a href="{{ route('student.plan.show', $activePlan) }}" class="btn-secondary btn-animated hover:shadow-lg transition-all">
                            <i data-lucide="map" class="w-5 h-5"></i> Open Detailed Plan
                        </a>
                    @endif
                </div>
            </div>

            <!-- Readiness Circular Indicator -->
            <div class="glass-panel p-6 bg-white/40 backdrop-blur-md animate-slideInRight border border-white/60">
                <p class="mini-label">Overall Readiness</p>
                <div class="mt-5 flex items-center gap-6">
                    <div class="progress-ring w-32 h-32 rounded-full grid place-items-center animate-scaleIn" style="--p:{{ $progressPercent }}">
                        <div class="w-22 h-22 rounded-full bg-white grid place-items-center">
                            <span class="font-display font-black text-3xl text-slate-800">{{ $progressPercent }}%</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-display font-black text-2xl text-purple-700">{{ $student->risk_level }}</h3>
                        <p class="text-slate-500 mt-2 text-xs leading-relaxed font-semibold">Calculated from marks, attendance, and plan check-ins.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Consolidated Stats Bar -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-5">
        <div class="glass-panel p-5 bg-white/50 hover:bg-white/80 transition-all border border-white/50 text-center md:text-left">
            <p class="mini-label">Avg Marks</p>
            <div class="mt-2 font-display font-black text-3xl text-blue-600">{{ $avgScore }}%</div>
        </div>
        <div class="glass-panel p-5 bg-white/50 hover:bg-white/80 transition-all border border-white/50 text-center md:text-left">
            <p class="mini-label">Attendance</p>
            <div class="mt-2 font-display font-black text-3xl text-indigo-600">{{ $attendance }}%</div>
        </div>
        <div class="glass-panel p-5 bg-white/50 hover:bg-white/80 transition-all border border-white/50 text-center md:text-left">
            <p class="mini-label">Completed Plans</p>
            <div class="mt-2 font-display font-black text-3xl text-emerald-600">{{ $completedPlans }}</div>
        </div>
        <div class="glass-panel p-5 bg-white/50 hover:bg-white/80 transition-all border border-white/50 text-center md:text-left">
            <p class="mini-label">Roll & Class</p>
            <div class="mt-2 font-display font-black text-lg text-slate-800 truncate">{{ $student->roll_number }}</div>
            <p class="text-[10px] font-black uppercase text-slate-400 mt-1">{{ $student->eduClass?->name ?? 'Unassigned' }}</p>
        </div>
    </section>

    <!-- Main Workspace Grid -->
    <section class="grid xl:grid-cols-2 gap-8">
        <!-- Left Side: Remedial Plan & Confidence Check-in -->
        <div class="space-y-8">
            <div class="glass-panel overflow-hidden">
                <div class="p-6 border-b border-white/60 bg-gradient-to-r from-blue-50/30 to-purple-50/30">
                    <p class="mini-label">Assigned Remedial Support</p>
                    <h2 class="font-display font-black text-2xl mt-1 text-slate-900">My Active Learning Plan</h2>
                </div>
                <div class="p-6 space-y-6">
                    @if($activePlan)
                        <div class="bg-white/40 border border-white/60 p-5 rounded-2xl">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h3 class="font-display font-black text-2xl text-slate-800">{{ $activePlan->subject }}</h3>
                                    <p class="text-slate-600 mt-2 text-sm leading-relaxed">{{ $activePlan->learning_issue }}</p>
                                </div>
                                <span class="status-badge bg-blue-50 text-blue-700 py-1.5 px-3 rounded-full text-xs font-black">
                                    <span class="status-dot bg-blue-600"></span> Active
                                </span>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="rounded-full bg-blue-50/80 text-blue-700 px-3 py-1 text-xs font-black border border-blue-100">
                                    Style: {{ $activePlan->preferred_style }}
                                </span>
                                <span class="rounded-full bg-purple-50/80 text-purple-700 px-3 py-1 text-xs font-black border border-purple-100">
                                    Duration: {{ $activePlan->duration }}
                                </span>
                            </div>
                        </div>

                        <!-- 1-Click Confidence Check-in -->
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-indigo-50/50 to-purple-50/50 border border-indigo-100/60">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-600 grid place-items-center shrink-0">
                                    <i data-lucide="heart-handshake" class="w-5 h-5 animate-pulse"></i>
                                </div>
                                <div>
                                    <h4 class="font-display font-black text-lg text-slate-800">Daily Confidence Tracker</h4>
                                    <p class="text-xs text-slate-500 mt-1">Select an option below to instantly tell your teacher how you are managing this topic.</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('student.plan.confidence', $activePlan) }}" method="POST" class="mt-4 grid grid-cols-3 gap-3">
                                @csrf
                                <button type="submit" name="confidence" value="confused" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white hover:bg-red-50 border border-slate-200 hover:border-red-300 transition duration-200 group">
                                    <span class="text-3xl group-hover:scale-125 transition">😟</span>
                                    <span class="text-[11px] font-black text-red-600 mt-2 uppercase tracking-wider">Confused</span>
                                </button>
                                <button type="submit" name="confidence" value="getting_it" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white hover:bg-amber-50 border border-slate-200 hover:border-amber-300 transition duration-200 group">
                                    <span class="text-3xl group-hover:scale-125 transition">😐</span>
                                    <span class="text-[11px] font-black text-amber-600 mt-2 uppercase tracking-wider">Getting it</span>
                                </button>
                                <button type="submit" name="confidence" value="confident" class="flex flex-col items-center justify-center p-3 rounded-xl bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition duration-200 group">
                                    <span class="text-3xl group-hover:scale-125 transition">🙂</span>
                                    <span class="text-[11px] font-black text-emerald-600 mt-2 uppercase tracking-wider">Confident</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl grid place-items-center mx-auto mb-4 animate-bounce-custom">
                                <i data-lucide="check-circle" class="w-8 h-8"></i>
                            </div>
                            <h3 class="font-display font-black text-2xl text-slate-800">All caught up!</h3>
                            <p class="text-slate-500 mt-2 text-sm max-w-sm mx-auto">You do not have any active remedial plans assigned. Keep maintaining your scores!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Missions Board -->
            <div class="glass-panel p-6">
                <p class="mini-label">Missions</p>
                <h2 class="font-display font-black text-2xl mt-1 mb-5">Today's Micro Missions</h2>
                <div class="space-y-4">
                    @foreach($missionList as $mission)
                    <div class="rounded-2xl bg-white/50 border border-white/60 p-4 flex gap-4 hover:bg-blue-50/50 transition-all">
                        <div class="w-10 h-10 rounded-2xl bg-white text-blue-600 grid place-items-center shrink-0 animate-float">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between gap-3">
                                <strong class="text-slate-800">{{ $mission['title'] }}</strong>
                                <span class="status-badge text-[10px] font-black text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">
                                    {{ $mission['status'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">{{ $mission['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Side: Focus Areas & Help Requests, and Teacher Feedback -->
        <div class="space-y-8">
            <!-- Focus Areas with doubts trigger -->
            <div class="glass-panel p-6">
                <p class="mini-label">Academics</p>
                <h2 class="font-display font-black text-2xl mt-1 mb-2">Subject Performance & Help</h2>
                <p class="text-xs text-slate-500 mb-5">Identify your weak spots and immediately clear doubts with your class teacher.</p>
                
                <div class="space-y-5">
                    @foreach($weakSubjects as $item)
                    <div class="p-4 rounded-2xl bg-white/40 border border-white/50">
                        <div class="flex justify-between font-bold text-sm">
                            <span class="text-slate-800">{{ $item['subject'] }}</span>
                            <span class="text-orange-600 font-extrabold">{{ $item['score'] }}%</span>
                        </div>
                        <div class="mt-2 h-2.5 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500" style="width: {{ $item['score'] }}%"></div>
                        </div>
                        <div class="flex justify-between items-center mt-2.5">
                            <p class="text-[11px] text-slate-500 font-semibold italic">{{ $item['tip'] }}</p>
                            
                            <!-- Help Request Toggle Details -->
                            <details class="group">
                                <summary class="list-none flex items-center gap-1 cursor-pointer text-xs font-black text-blue-600 hover:text-blue-800 transition">
                                    <span>Ask Doubt</span>
                                    <span class="group-open:rotate-180 transition-transform"><i data-lucide="chevron-down" class="w-3.5 h-3.5"></i></span>
                                </summary>
                                <div class="fixed inset-0 bg-slate-900/10 backdrop-blur-sm z-40 hidden group-open:block" onclick="this.parentElement.removeAttribute('open')"></div>
                                <div class="absolute right-6 left-6 mt-2 p-4 rounded-2xl bg-white border border-slate-200 shadow-xl z-50 animate-fadeInUp group-open:block max-w-sm">
                                    <h4 class="font-display font-black text-sm text-slate-800 mb-1">Ask doubt: {{ $item['subject'] }}</h4>
                                    <p class="text-[11px] text-slate-500 mb-3">Your question will be added to the teacher's pending help queue.</p>
                                    <form action="{{ route('student.help.store') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="subject" value="{{ $item['subject'] }}">
                                        <div>
                                            <textarea name="message" rows="3" placeholder="Tell your teacher what is confusing you..." class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50" required></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="this.closest('details').removeAttribute('open')" class="btn-secondary !py-1.5 !px-3 text-xs w-full justify-center">Cancel</button>
                                            <button type="submit" class="btn-primary !py-1.5 !px-3 text-xs w-full justify-center">
                                                <i data-lucide="send" class="w-3.5 h-3.5"></i> Ask doubt
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </details>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Feedback from Teachers -->
            <div class="glass-panel p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="mini-label">💌 Communication</p>
                        <h2 class="font-display font-black text-2xl mt-1">Feedback from Teachers</h2>
                    </div>
                    <span class="status-badge text-xs font-black bg-blue-50 text-blue-700 py-1 px-2.5 rounded-full">
                        {{ count($feedbacks ?? []) }} Messages
                    </span>
                </div>

                @if (($feedbacks ?? collect())->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-3xl grid place-items-center mx-auto mb-3">
                            <i data-lucide="message-square" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-display font-black text-lg text-slate-800">No feedback yet</h3>
                        <p class="text-slate-500 mt-1 text-xs">When teachers send encouragement or tips, they will appear here!</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($feedbacks->take(3) as $feedback)
                            <div class="rounded-2xl p-4 border border-white/60 bg-white/50 border-l-4 
                                {{ $feedback->type === 'achievement' ? 'border-green-500' : 
                                   ($feedback->type === 'encouragement' ? 'border-blue-500' :
                                   ($feedback->type === 'improvement' ? 'border-orange-500' : 'border-indigo-500')) }}">
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded
                                        {{ $feedback->type === 'achievement' ? 'bg-green-100 text-green-800' : 
                                           ($feedback->type === 'encouragement' ? 'bg-blue-100 text-blue-800' :
                                           ($feedback->type === 'improvement' ? 'bg-orange-100 text-orange-800' : 'bg-indigo-100 text-indigo-800')) }}">
                                        {{ $feedback->type }}
                                    </span>
                                    <time class="text-[10px] text-slate-400 font-bold">{{ $feedback->created_at->format('M d, Y') }}</time>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm mt-2">{{ $feedback->title }}</h4>
                                <p class="text-slate-600 text-xs mt-1 leading-relaxed">{{ $feedback->feedback }}</p>
                                <div class="mt-3 flex justify-between items-center text-[10px] text-slate-400 font-bold">
                                    <span>From: {{ $feedback->teacher->user->name }}</span>
                                    @if (!$feedback->is_read)
                                        <form action="{{ route('feedback.markRead', $feedback) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:underline">Mark as read</button>
                                        </form>
                                    @else
                                        <span class="text-emerald-600">✓ Read</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
