@extends('layouts.dashboard')

@section('header', 'Generate Remedial Plan')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-0.5">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-0.5">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('plans.index') }}" class="sidebar-link active flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-0.5">
        <i data-lucide="clipboard-list" class="w-4 h-4"></i> Remedial Plans
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="vercel-card overflow-hidden">
        <div class="border-b border-[#eaeaea] px-8 py-6 bg-white">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-brand-50 flex items-center justify-center text-brand-600">
                    <i data-lucide="wand-2" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-display font-bold text-gray-900">Plan Generator</h2>
                    <p class="text-sm text-gray-500">Configure parameters to generate a targeted intervention plan.</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('plans.store') }}" method="POST" class="p-8 space-y-6 bg-white">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Target Student</label>
                    <select name="student_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                        <option value="">Select an at-risk student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->user->name }} (Score: {{ number_format($student->risk_score, 1) }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Weak Subject</label>
                    <select name="subject" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                        <option value="Mathematics">Mathematics</option>
                        <option value="Science">Science</option>
                        <option value="English">English</option>
                        <option value="History">History</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Primary Learning Issue</label>
                <textarea name="learning_issue" required rows="3" placeholder="Describe the specific concepts the student is struggling with..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Recommended Style</label>
                    <select name="preferred_style" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                        <option value="Visual Learning">Visual Learning</option>
                        <option value="Peer-to-Peer Mentoring">Peer-to-Peer Mentoring</option>
                        <option value="Activity-Based">Activity-Based Learning</option>
                        <option value="Micro-Learning">Micro-Learning</option>
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Plan Duration</label>
                    <select name="duration" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                        <option value="2 Weeks">2 Weeks</option>
                        <option value="4 Weeks">4 Weeks</option>
                        <option value="8 Weeks">8 Weeks</option>
                        <option value="Entire Semester">Entire Semester</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end border-t border-[#eaeaea]">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg shadow-sm shadow-brand-500/20 flex items-center gap-2 transition-all">
                    <i data-lucide="sparkles" class="w-4 h-4"></i> Generate Structured Plan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
