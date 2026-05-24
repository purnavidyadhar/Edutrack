@extends('layouts.dashboard')

@section('header', 'Administrative Tools')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Overview
    </a>
    <a href="{{ route('teachers.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="graduation-cap" class="w-4 h-4"></i> Faculty Management
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Student Database
    </a>
    <a href="{{ route('classes.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="book-open" class="w-4 h-4"></i> Institutional Classes
    </a>
    <a href="{{ route('admin.tools') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="sliders" class="w-4 h-4"></i> Admin Tools
    </a>
    <a href="{{ route('reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Analytics Reports
    </a>
@endsection

@section('content')
<div class="space-y-8 animate-fadeInUp">
    <!-- Hero Banner -->
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-950 via-slate-900 to-indigo-950 rounded-[32px] p-8 md:p-10 border border-white/10 shadow-2xl">
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-blue-500 rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
        <div class="relative z-10 space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md text-blue-200 rounded-full text-xs font-bold uppercase tracking-widest border border-white/5">
                <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-yellow-400"></i> Override Console
            </div>
            <h2 class="text-3xl md:text-4xl font-display font-extrabold text-white tracking-tight leading-none">
                System Overrides & Messaging
            </h2>
            <p class="text-indigo-200/90 font-medium text-sm max-w-xl">
                As a system administrator, you have full override write capabilities on student performance records, attendance files, teacher feedbacks, and global communication templates.
            </p>
        </div>
    </div>

    <!-- Main Tabs Navigation -->
    <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-2">
        <button onclick="switchTab('tab-overrides')" id="btn-tab-overrides" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold text-slate-800 bg-white shadow-sm border border-slate-100 hover:bg-slate-50 transition-all">
            🎯 Student Overrides
        </button>
        <button onclick="switchTab('tab-feedback')" id="btn-tab-feedback" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all">
            💬 Feedback Moderation
        </button>
        <button onclick="switchTab('tab-announcements')" id="btn-tab-announcements" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all">
            📢 Global Announcements
        </button>
    </div>

    <!-- TAB 1: STUDENT OVERRIDES -->
    <div id="tab-overrides" class="tab-content space-y-8">
        <div class="grid lg:grid-cols-[1fr_1.5fr] gap-8">
            <!-- Selector Panel -->
            <div class="glass-panel p-6 bg-white/50 space-y-6">
                <h3 class="font-display font-black text-xl text-slate-900">Select Student</h3>
                <form method="GET" action="{{ route('admin.tools') }}" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Student Name</label>
                        <select name="student_id" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Choose student to edit --</option>
                            @foreach($students as $st)
                                <option value="{{ $st->id }}" {{ request('student_id') == $st->id ? 'selected' : '' }}>
                                    {{ $st->user->name }} (Roll: {{ $st->roll_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <noscript>
                        <button type="submit" class="btn-primary w-full justify-center">Load Student Data</button>
                    </noscript>
                </form>

                @if($selectedStudent)
                    <div class="p-5 rounded-2xl bg-white border border-slate-100 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white font-black grid place-items-center text-sm">
                                {{ substr($selectedStudent->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-950 text-sm">{{ $selectedStudent->user->name }}</h4>
                                <p class="text-xs text-slate-400">Class: {{ $selectedStudent->eduClass->name ?? 'Unassigned' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 border-t border-slate-50 pt-3 text-center">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Risk Score</p>
                                <p class="text-lg font-black text-blue-600 mt-1">{{ number_format($selectedStudent->risk_score, 1) }}%</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Risk Level</p>
                                <p class="text-xs font-black text-slate-700 mt-1.5 truncate">{{ $selectedStudent->risk_level }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Editor Panel -->
            <div class="glass-panel p-6 bg-white/50 space-y-8">
                @if(!$selectedStudent)
                    <div class="text-center py-16 text-slate-400">
                        <i data-lucide="user-search" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                        <p class="text-sm font-semibold">Select a student on the left to begin editing their records.</p>
                    </div>
                @else
                    <!-- Sub-section: Attendance Override -->
                    <div class="space-y-4">
                        <h4 class="font-display font-bold text-lg text-slate-900 border-b border-slate-100 pb-2">1. Attendance Percentage Override</h4>
                        <form action="{{ route('admin.tools.updateAttendance') }}" method="POST" class="grid md:grid-cols-[2fr_1fr] gap-4 items-end bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Overall Attendance (%)</label>
                                <input type="number" step="0.1" min="0" max="100" name="percentage" value="{{ $studentAttendance?->percentage ?? '' }}" placeholder="e.g. 85.5" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <button type="submit" class="btn-primary justify-center !py-3">Save Attendance</button>
                        </form>
                    </div>

                    <!-- Sub-section: Marks Override -->
                    <div class="space-y-4">
                        <h4 class="font-display font-bold text-lg text-slate-900 border-b border-slate-100 pb-2">2. Subject Marks Override</h4>
                        <form action="{{ route('admin.tools.updateMarks') }}" method="POST" class="space-y-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Subject</label>
                                    <select name="subject_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="">-- Choose Subject --</option>
                                        @foreach($subjects as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Assessment Type</label>
                                    <select name="exam_type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <option value="Mid Term">Mid Term</option>
                                        <option value="Final Exam">Final Exam</option>
                                        <option value="quiz">Quiz / Unit Test</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Marks Obtained</label>
                                    <input type="number" step="0.1" min="0" max="100" name="marks_obtained" placeholder="e.g. 78.5" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Marks</label>
                                    <input type="number" min="1" name="total_marks" value="100" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary w-full justify-center !py-3">Save / Overwrite Marks</button>
                        </form>
                    </div>

                    <!-- Current Subject Marks List -->
                    <div class="space-y-3">
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Current Academic Profile</h5>
                        <div class="border border-slate-100 rounded-2xl overflow-hidden bg-white">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Subject</th>
                                        <th class="px-5 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Exam Type</th>
                                        <th class="px-5 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Marks</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($studentMarks as $mk)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="px-5 py-3.5 font-bold text-slate-800">{{ $mk->subject->name ?? 'Subject' }}</td>
                                            <td class="px-5 py-3.5 text-slate-500">{{ $mk->exam_type }}</td>
                                            <td class="px-5 py-3.5 text-right font-black text-blue-600">{{ $mk->marks_obtained }} / {{ $mk->total_marks }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-5 py-6 text-center text-slate-400">No marks recorded.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- TAB 2: FEEDBACK MODERATION -->
    <div id="tab-feedback" class="tab-content hidden space-y-6">
        <div class="glass-panel p-6 bg-white/50 space-y-6">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h3 class="font-display font-black text-xl text-slate-900">Moderate Teacher Feedback</h3>
                <span class="status-badge bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-xs font-black">{{ $feedbacks->count() }} Feedbacks</span>
            </div>

            <div class="grid gap-4">
                @forelse($feedbacks as $fb)
                    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between gap-4">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <strong class="text-slate-900">{{ $fb->student->user->name }}</strong>
                                    <span class="text-xs text-slate-400">from Teacher: {{ $fb->teacher->user->name }}</span>
                                </div>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="status-badge text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded
                                        {{ $fb->type === 'achievement' ? 'bg-green-100 text-green-800' : 
                                           ($fb->type === 'encouragement' ? 'bg-blue-100 text-blue-800' :
                                           ($fb->type === 'improvement' ? 'bg-orange-100 text-orange-800' : 'bg-indigo-100 text-indigo-800')) }}">
                                        {{ $fb->type }}
                                    </span>
                                    @if($fb->rating)
                                        <span class="text-xs flex gap-0.5 text-yellow-400">
                                            @for($i = 1; $i <= $fb->rating; $i++) ⭐ @endfor
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs text-slate-400 font-bold whitespace-nowrap">{{ $fb->created_at->format('M d, Y') }}</span>
                        </div>

                        <!-- Expandable Moderation Form -->
                        <details class="group mt-2">
                            <summary class="list-none flex items-center gap-1 cursor-pointer text-xs font-black text-blue-600 hover:text-blue-800">
                                <span>Edit Feedback Details</span>
                                <span class="group-open:rotate-180 transition-transform"><i data-lucide="chevron-down" class="w-3.5 h-3.5"></i></span>
                            </summary>
                            <form action="{{ route('admin.tools.updateFeedback', $fb) }}" method="POST" class="mt-4 p-4 rounded-xl border border-slate-100 bg-slate-50/50 space-y-4">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Feedback Title</label>
                                        <input type="text" name="title" value="{{ $fb->title }}" class="w-full text-xs rounded-lg border border-slate-200 p-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Rating (1-5)</label>
                                        <input type="number" min="1" max="5" name="rating" value="{{ $fb->rating }}" class="w-full text-xs rounded-lg border border-slate-200 p-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Type</label>
                                        <select name="type" class="w-full text-xs rounded-lg border border-slate-200 p-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                                            <option value="achievement" {{ $fb->type === 'achievement' ? 'selected' : '' }}>Achievement</option>
                                            <option value="encouragement" {{ $fb->type === 'encouragement' ? 'selected' : '' }}>Encouragement</option>
                                            <option value="improvement" {{ $fb->type === 'improvement' ? 'selected' : '' }}>Improvement</option>
                                            <option value="progress" {{ $fb->type === 'progress' ? 'selected' : '' }}>Progress</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Feedback Message</label>
                                    <textarea name="feedback" rows="3" class="w-full text-xs rounded-lg border border-slate-200 p-2.5 focus:outline-none focus:ring-1 focus:ring-blue-500" required>{{ $fb->feedback }}</textarea>
                                </div>
                                <button type="submit" class="btn-primary !py-2 !px-4 text-xs font-bold">Update Feedback</button>
                            </form>
                        </details>

                        <div class="mt-3 p-3.5 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 text-sm leading-relaxed">
                            <strong>"{{ $fb->title }}"</strong> — {{ $fb->feedback }}
                        </div>

                        <div class="mt-4 flex gap-2 justify-end">
                            <form action="{{ route('admin.tools.deleteFeedback', $fb) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher feedback?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 transition flex items-center gap-1.5">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Delete Feedback
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-slate-400">
                        <i data-lucide="message-square" class="w-12 h-12 mx-auto mb-3 text-slate-300 animate-pulse"></i>
                        <p class="text-sm font-semibold">No feedback records found in the database.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 3: GLOBAL ANNOUNCEMENTS -->
    <div id="tab-announcements" class="tab-content hidden space-y-8">
        <div class="grid lg:grid-cols-[1fr_1.5fr] gap-8">
            <!-- Composer Card -->
            <div class="glass-panel p-6 bg-white/50 space-y-6">
                <h3 class="font-display font-black text-xl text-slate-900">Compose Notice</h3>
                <form action="{{ route('admin.tools.storeAnnouncement') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target Audience</label>
                        <select name="audience" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="all">Everyone (All users)</option>
                            <option value="teachers">Teachers Only</option>
                            <option value="students">Students Only</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Notice Title</label>
                        <input type="text" name="title" placeholder="e.g. Schedule Update or Maintenance notice" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Announcement Message</label>
                        <textarea name="message" rows="5" placeholder="Type announcement details here..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center !py-3 flex items-center gap-2">
                        <i data-lucide="send" class="w-4 h-4"></i> Broadcast Announcement
                    </button>
                </form>
            </div>

            <!-- Recent Broadcasts -->
            <div class="glass-panel p-6 bg-white/50 space-y-6">
                <h3 class="font-display font-black text-xl text-slate-900">Broadcast History</h3>
                <div class="space-y-4">
                    @forelse($announcements as $ann)
                        <div class="bg-white border border-slate-100 p-5 rounded-2xl shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start gap-3">
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-base">{{ $ann->title }}</h4>
                                        <span class="inline-block px-2.5 py-0.5 rounded bg-purple-50 text-purple-700 text-[10px] font-black uppercase mt-1">
                                            Audience: {{ $ann->audience }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-400 font-bold whitespace-nowrap">{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-700 text-sm leading-relaxed">
                                    {{ $ann->message }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(function(el) {
        el.classList.add('hidden');
    });

    // Remove active styles from buttons
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.classList.remove('text-slate-800', 'bg-white', 'shadow-sm', 'border', 'border-slate-100');
        btn.classList.add('text-slate-500');
    });

    // Show selected tab content
    document.getElementById(tabId).classList.remove('hidden');

    // Add active styles to clicked button
    const activeBtn = document.getElementById('btn-' + tabId);
    activeBtn.classList.remove('text-slate-500');
    activeBtn.classList.add('text-slate-800', 'bg-white', 'shadow-sm', 'border', 'border-slate-100');
}
</script>
@endsection
