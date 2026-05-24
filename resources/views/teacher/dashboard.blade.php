@extends('layouts.dashboard')
@section('title','Teacher Command Center')
@section('content')
<div class="space-y-8">
    <section class="glass-panel relative overflow-hidden p-8 md:p-10 animate-fadeInUp">
        <div class="relative grid lg:grid-cols-[1.5fr_1fr] gap-10 items-center">
            <div class="animate-slideInLeft space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 border border-blue-100 px-4 py-2 text-blue-700 text-xs font-black uppercase tracking-widest"><i data-lucide="radar" class="w-4 h-4 animate-spin-slow"></i> Slow Learner Intelligence</div>
                <h1 class="font-display font-black text-4xl md:text-5xl tracking-tight leading-[1.02] text-slate-900">Teacher <span class="gradient-title">Command Center</span></h1>
                <p class="text-slate-600 text-base leading-relaxed max-w-2xl">This workspace aggregates diagnostic signals across class grades to identify learners requiring priority support. Generate remedial plans, upload marks, and monitor intervention outcomes.</p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('plans.create') }}" class="btn-primary btn-animated hover:shadow-lg transition-all"><i data-lucide="wand-sparkles" class="w-5 h-5"></i> Generate Remedial Plan</a>
                    <a href="{{ route('marks.create') }}" class="btn-secondary btn-animated hover:shadow-lg transition-all"><i data-lucide="upload-cloud" class="w-5 h-5"></i> Upload Marks</a>
                    <a href="{{ route('students.create') }}" class="btn-secondary btn-animated hover:shadow-lg transition-all"><i data-lucide="user-plus" class="w-5 h-5"></i> Add Learner</a>
                </div>
            </div>
            
            <div class="glass-panel p-6 bg-white/40 backdrop-blur-md animate-slideInRight border border-white/60">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="mini-label">Priority Queue</p>
                        <h3 class="font-display font-black text-2xl text-slate-800">Intervention Queue</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 grid place-items-center animate-bounce-custom"><i data-lucide="alarm-clock" class="w-6 h-6"></i></div>
                </div>
                <div class="space-y-3 animate-stagger">
                    @foreach($teachingQueue->take(3) as $task)
                    <div class="rounded-2xl border border-white/40 bg-white/50 p-4 hover:bg-white/80 transition-all shadow-sm">
                        <div class="flex justify-between gap-3">
                            <strong class="text-slate-800">{{ $task['name'] }}</strong>
                            <span class="status-badge bg-red-50/80 text-red-600 font-extrabold text-xs py-1 px-2.5 rounded-full"><span class="status-dot bg-red-500"></span>Risk {{ $task['risk'] }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1.5">{{ $task['weak_subject'] }} • {{ $task['strategy'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="grid sm:grid-cols-2 xl:grid-cols-5 gap-5 dashboard-grid">
        @php
            $stats = [
                ['Students', $totalStudents, 'users-round', 'bg-blue-50 text-blue-600'],
                ['Critical', $criticalCount, 'siren', 'bg-red-50 text-red-600'],
                ['Slow Learners', $slowLearnersCount, 'heart-pulse', 'bg-orange-50 text-orange-600'],
                ['Plans', $plansAssigned, 'clipboard-check', 'bg-purple-50 text-purple-600'],
                ['Avg Growth', $avgImprovement.'%', 'trending-up', 'bg-emerald-50 text-emerald-600']
            ];
        @endphp
        @foreach($stats as $s)
        <div class="glass-panel p-6 cursor-pointer hover:bg-white/90">
            <div class="flex items-center justify-between"><p class="mini-label">{{ $s[0] }}</p><div class="w-11 h-11 rounded-2xl {{ $s[3] }} grid place-items-center animate-pulse-custom"><i data-lucide="{{ $s[2] }}" class="w-5 h-5"></i></div></div>
            <div class="mt-5 font-display text-4xl font-black">{{ $s[1] }}</div>
        </div>
        @endforeach
    </section>

    <section class="grid xl:grid-cols-[1.35fr_.65fr] gap-7 animate-stagger">
        <div class="glass-panel overflow-hidden">
            <div class="p-6 md:p-7 flex flex-wrap items-center justify-between gap-4 border-b border-white/60 animate-slideInLeft">
                <div><p class="mini-label">Explainable AI style output</p><h2 class="font-display font-black text-2xl">Priority Learner Board</h2></div>
                <a href="{{ route('students.index') }}" class="btn-secondary !py-3 btn-animated hover:shadow-lg">Open full records</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/40"><tr><th class="px-6 py-4 mini-label">Learner</th><th class="px-6 py-4 mini-label">Weak Area</th><th class="px-6 py-4 mini-label">Attendance</th><th class="px-6 py-4 mini-label">Support</th><th class="px-6 py-4 mini-label text-right">Action</th></tr></thead>
                    <tbody class="divide-y divide-white/40 animate-stagger">
                    @foreach($priorityStudents as $student)
                        <tr class="hover:bg-blue-50/40 transition-all">
                            <td class="px-6 py-5"><div class="flex items-center gap-3"><div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 text-white grid place-items-center font-black shadow-md">{{ substr($student->user->name,0,1) }}</div><div><strong class="text-slate-900">{{ $student->user->name }}</strong><p class="text-sm text-slate-500">{{ $student->eduClass?->name }} • Roll {{ $student->roll_number }}</p></div></div></td>
                            <td class="px-6 py-5"><span class="font-bold">{{ $student->weak_subject }}</span><div class="text-sm text-slate-500">Risk score <span class="text-red-600 font-bold">{{ number_format($student->risk_score,1) }}</span></div></td>
                            <td class="px-6 py-5"><div class="w-28 h-2 bg-slate-100 rounded-full overflow-hidden progress-bar-animated"><div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500" style="width: {{ $student->latest_attendance }}%"></div></div><div class="text-xs font-bold mt-1">{{ $student->latest_attendance }}%</div></td>
                            <td class="px-6 py-5"><span class="status-badge {{ $student->plan_status==='Plan Active'?'bg-emerald-50 text-emerald-700':'bg-orange-50 text-orange-700' }}"><span class="status-dot {{ $student->plan_status==='Plan Active'?'bg-emerald-500':'bg-orange-500' }}"></span>{{ $student->plan_status }}</span></td>
                            <td class="px-6 py-5 text-right"><a href="{{ route('students.show',$student) }}" class="font-black text-blue-600 hover:text-blue-800 transition hover:underline">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="space-y-7 animate-stagger">
            <div class="glass-panel p-6 animate-fadeInUp"><p class="mini-label">Class health map</p><h3 class="font-display font-black text-2xl mb-5">Risk Distribution</h3><div class="h-64"><canvas id="riskChart"></canvas></div></div>
            <div class="glass-panel p-6 animate-fadeInUp"><p class="mini-label">Subject weakness</p><h3 class="font-display font-black text-2xl mb-4">Lowest Averages</h3><div class="space-y-4 animate-stagger">@foreach($subjectWeaknesses->take(4) as $subject=>$avg)<div class="animate-slideInLeft"><div class="flex justify-between text-sm font-bold"><span>{{ $subject }}</span><span class="text-orange-600">{{ $avg }}%</span></div><div class="mt-2 h-3 bg-slate-100 rounded-full overflow-hidden progress-bar-animated"><div class="h-full bg-gradient-to-r from-orange-400 to-red-500" style="width: {{ $avg }}%"></div></div></div>@endforeach</div></div>
        </div>
    </section>

    <!-- Student Help Requests Section -->
    <section class="space-y-5 animate-fadeInUp">
        <div class="glass-panel p-7">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="mini-label">🙋 Student Help Queue</p>
                    <h2 class="font-display font-black text-2xl">Pending Doubt Help Requests</h2>
                </div>
                <span class="status-badge text-sm font-black bg-red-50 text-red-700 py-1 px-2.5 rounded-full">
                    <span class="status-dot bg-red-600"></span>
                    {{ $helpRequests->count() }} Pending Request{{ $helpRequests->count() !== 1 ? 's' : '' }}
                </span>
            </div>

            @if ($helpRequests->isEmpty())
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl grid place-items-center mx-auto mb-4">
                        <i data-lucide="check-check" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-display font-black text-xl text-slate-800">No pending help requests!</h3>
                    <p class="text-slate-500 mt-2 text-sm">All student doubts have been cleared. Excellent work!</p>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 animate-stagger">
                    @foreach ($helpRequests as $request)
                        <div class="rounded-2xl border border-white/60 bg-white/50 p-5 hover:shadow-lg transition-all flex flex-col justify-between" style="animation: slideInLeft 0.5s ease-out;">
                            <div>
                                <div class="flex justify-between items-start gap-4">
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $request->student->user->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $request->student->eduClass?->name ?? 'Unassigned' }} • Subject: <strong class="text-indigo-600">{{ $request->subject }}</strong></p>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold whitespace-nowrap">{{ $request->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-4 p-3 rounded-xl bg-white/60 border border-slate-100/50 text-slate-700 text-sm leading-relaxed min-h-[4rem] italic font-semibold">
                                    "{{ $request->message }}"
                                </div>
                            </div>
                            <div class="mt-5 flex gap-3">
                                <a href="{{ route('feedback.send', $request->student) }}" class="btn-secondary !py-2 !px-3 text-xs font-bold flex-1 justify-center">
                                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Send Tip
                                </a>
                                <form action="{{ route('teacher.help.resolve', $request) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="btn-primary !py-2 !px-3 text-xs font-bold w-full justify-center bg-emerald-600 hover:bg-emerald-700 text-white">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i> Resolve
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Recent Feedback Activity Section -->
    <section class="space-y-5 animate-fadeInUp">
        <div class="glass-panel p-7">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="mini-label">💬 Student Communication</p>
                    <h2 class="font-display font-black text-2xl">Recent Feedback Sent</h2>
                </div>
                <span class="status-badge text-sm font-black bg-purple-50 text-purple-700">
                    <span class="status-dot bg-purple-600"></span>
                    Track interactions
                </span>
            </div>

            @php
                $recentFeedbacks = $recentFeedbacks ?? collect();
            @endphp

            @if ($recentFeedbacks->isEmpty())
                <div class="text-center py-12 animate-slideUp">
                    <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-3xl grid place-items-center mx-auto mb-4">
                        <i data-lucide="message-square" class="w-10 h-10"></i>
                    </div>
                    <h3 class="font-display font-black text-xl">No feedback sent yet</h3>
                    <p class="text-slate-500 mt-2">Start sending feedback to students to track your interactions</p>
                    <a href="{{ route('students.index') }}" class="btn-primary mt-4 inline-block btn-animated">
                        <i data-lucide="users" class="w-4 h-4"></i> Go to Students
                    </a>
                </div>
            @else
                <div class="space-y-3 animate-stagger">
                    @foreach ($recentFeedbacks as $feedback)
                        <div class="rounded-2xl p-4 border-l-4 hover:shadow-lg transition-all border border-white/60 bg-white/50
                            {{ $feedback->type === 'achievement' ? 'border-green-500 bg-gradient-to-r from-green-50/50' : 
                               ($feedback->type === 'encouragement' ? 'border-blue-500 bg-gradient-to-r from-blue-50/50' :
                               ($feedback->type === 'improvement' ? 'border-orange-500 bg-gradient-to-r from-orange-50/50' : 'border-indigo-500 bg-gradient-to-r from-indigo-50/50')) }}
                            to-transparent"
                            style="animation: slideInLeft 0.5s ease-out;">
                            
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <strong class="text-gray-900">{{ $feedback->student->user->name }}</strong>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-bold
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
                                            <span class="text-xs flex gap-0">
                                                @for ($i = 1; $i <= $feedback->rating; $i++)
                                                    <span class="text-yellow-400">⭐</span>
                                                @endfor
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-700 font-semibold">{{ $feedback->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1 truncate">{{ $feedback->feedback }}</p>
                                </div>
                                <time class="text-xs text-slate-500 whitespace-nowrap font-bold">
                                    {{ $feedback->created_at->format('M d') }}
                                </time>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="grid lg:grid-cols-3 gap-7 dashboard-grid">
        <div class="glass-panel p-7 hover:bg-white/90"><div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 grid place-items-center mb-5 animate-float"><i data-lucide="brain-circuit" class="w-7 h-7"></i></div><h3 class="font-display font-black text-xl">Learning Gap Detector</h3><p class="text-slate-500 mt-2">Finds weak subjects from actual marks and separates critical, slow and attention learners.</p></div>
        <div class="glass-panel p-7 hover:bg-white/90"><div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 grid place-items-center mb-5 animate-float" style="animation-delay: 0.5s;"><i data-lucide="route" class="w-7 h-7"></i></div><h3 class="font-display font-black text-xl">Remedial Pathway</h3><p class="text-slate-500 mt-2">Teacher can assign visual, peer, activity or micro-learning plans and track improvement.</p></div>
        <div class="glass-panel p-7 hover:bg-white/90"><div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 grid place-items-center mb-5 animate-float" style="animation-delay: 1s;"><i data-lucide="message-circle-heart" class="w-7 h-7"></i></div><h3 class="font-display font-black text-xl">Viva-ready Evidence</h3><p class="text-slate-500 mt-2">Every number has a purpose: attendance, marks, progress records and support status.</p></div>
    </section>
</div>
@endsection
@section('scripts')
<script>
new Chart(document.getElementById('riskChart'),{type:'doughnut',data:{labels:@json($riskLabels),datasets:[{data:@json($riskData),backgroundColor:['#ef4444','#f97316','#f59e0b','#10b981'],borderWidth:0}]},options:{cutout:'68%',plugins:{legend:{position:'bottom',labels:{usePointStyle:true,boxWidth:8,font:{weight:'700'}}}}}});
</script>
@endsection
