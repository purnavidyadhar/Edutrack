@extends('layouts.dashboard')

@section('header', 'Student Directory')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('plans.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="wand-2" class="w-4 h-4"></i> AI Remedial Plans
    </a>
@endsection

@section('content')
<div class="space-y-6 animate-fadeInUp">
    <div class="flex items-center justify-between">
        <p class="text-gray-500 font-medium">Manage and monitor all student performance records.</p>
        <div class="flex items-center gap-3">
            <a href="{{ route('students.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] transition-all flex items-center gap-2 btn-animated">
                <i data-lucide="plus" class="w-4 h-4"></i> Add New Student
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="glass-card p-6 bg-white animate-slideInDown">
        <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Search Student</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, roll..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    <div class="absolute left-3.5 top-3 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Class / Grade</label>
                <select name="class_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    <option value="">All Classes</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls->id }}" {{ request('class_id') == $cls->id ? 'selected' : '' }}>{{ $cls->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Risk Level</label>
                <select name="risk_level" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    <option value="">All Levels</option>
                    <option value="Good Performer" {{ request('risk_level') === 'Good Performer' ? 'selected' : '' }}>Good Performer</option>
                    <option value="Needs Attention" {{ request('risk_level') === 'Needs Attention' ? 'selected' : '' }}>Needs Attention</option>
                    <option value="Slow Learner" {{ request('risk_level') === 'Slow Learner' ? 'selected' : '' }}>Slow Learner</option>
                    <option value="Critical Support Needed" {{ request('risk_level') === 'Critical Support Needed' ? 'selected' : '' }}>Critical Support Needed</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 btn-animated">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'class_id', 'risk_level']))
                    <a href="{{ route('students.index') }}" class="py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-all flex items-center justify-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Card-based view instead of table -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 dashboard-grid">
        @forelse($students as $student)
        <div class="glass-card p-6 enhanced-card group hover:shadow-lg transition-all transform hover:scale-105 animate-fadeInUp">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-purple-50 border border-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg shadow-sm group-hover:shadow-md transition-all">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">
                        <span class="text-lg font-semibold text-slate-500">Score</span><br>
                        <span class="text-blue-600">{{ number_format($student->risk_score, 1) }}</span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="font-bold text-gray-900 text-lg truncate">{{ $student->user->name }}</h3>
                <p class="text-xs text-gray-500 mt-1 truncate">Roll: {{ $student->roll_number }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $student->user->email }}</p>
                <p class="text-xs text-gray-500 mt-2">Class: <span class="font-semibold text-gray-700">{{ $student->eduClass->name ?? 'N/A' }}</span></p>
            </div>

            <!-- Status Badge -->
            <div class="mb-4">
                @if($student->risk_level === 'Critical Support Needed')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-700 border border-red-100 shadow-sm animate-pulse-custom"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Critical</span>
                @elseif($student->risk_level === 'Slow Learner')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100 shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Slow Learner</span>
                @elseif($student->risk_level === 'Needs Attention')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Needs Attention</span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-100 shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Good</span>
                @endif
            </div>

            <!-- Action Button -->
            <a href="{{ route('students.show', $student->id) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-bold rounded-lg transition-all shadow-md hover:shadow-lg btn-animated">
                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i> View Profile
            </a>
        </div>
        @empty
        <div class="col-span-full glass-card p-12 text-center">
            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl grid place-items-center mx-auto mb-4">
                <i data-lucide="users-x" class="w-10 h-10"></i>
            </div>
            <h3 class="font-display font-bold text-lg text-gray-900">No students found</h3>
            <p class="text-sm text-gray-500 mt-2">Try adjusting your filters or add a new student.</p>
        </div>
        @endempty
    </div>

    <!-- Pagination -->
    <div class="glass-card p-4 bg-white/50">
        {{ $students->links() }}
    </div>
</div>
@endsection
