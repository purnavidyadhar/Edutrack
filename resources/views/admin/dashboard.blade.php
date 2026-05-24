@extends('layouts.dashboard')

@section('header', 'Institution Overview')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
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
    <a href="{{ route('reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Analytics Reports
    </a>
    <a href="{{ route('admin.tools') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="sliders" class="w-4 h-4"></i> Admin Tools
    </a>
@endsection

@section('content')
<div class="space-y-8 relative">

    <!-- Premium Hero Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-950 via-brand-900 to-indigo-950 rounded-[32px] p-8 md:p-10 border border-white/10 shadow-2xl shadow-brand-950/20 group animate-fade-in">
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-brand-500 rounded-full blur-[100px] opacity-25 group-hover:opacity-40 transition-opacity duration-700 pointer-events-none"></div>
        <div class="absolute -left-24 -bottom-24 w-96 h-96 bg-accent rounded-full blur-[100px] opacity-20 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md text-indigo-200 rounded-full text-xs font-bold uppercase tracking-widest border border-white/5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Portal Access: Administrator
                </div>
                <h2 class="text-3xl md:text-4xl font-display font-extrabold text-white tracking-tight leading-none">
                    Admin Control Panel
                </h2>
                <p class="text-indigo-100/90 font-medium text-sm md:text-base max-w-xl">
                    Managing institutional performance metrics, faculty workload, and automated student risk triggers.
                </p>
            </div>
            
            <a href="{{ route('admin.tools') }}" class="px-6 py-3.5 bg-white text-brand-950 text-sm font-black rounded-2xl hover:bg-slate-50 hover:shadow-lg transition-all flex items-center gap-2 btn-animated border border-white/20 self-start md:self-auto">
                <i data-lucide="sliders" class="w-5 h-5 text-brand-500"></i> Open Admin Tools
            </a>
        </div>
    </div>

    <!-- Cinematic High-Fidelity Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="glass-card glass-card-hover p-8 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-brand-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-5 mb-5">
                <div class="w-14 h-14 rounded-2xl bg-brand-50 flex items-center justify-center border border-brand-100/50 text-brand-500">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Students</p>
                    <h3 class="text-3xl font-display font-black text-brand-950 tracking-tight">{{ $totalStudents }}</h3>
                </div>
            </div>
            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-brand-500 w-[85%] rounded-full shadow-[0_0_8px_rgba(79,70,229,0.5)]"></div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="glass-card glass-card-hover p-8 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-accent/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-5 mb-5">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center border border-purple-100/50 text-accent">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Teachers</p>
                    <h3 class="text-3xl font-display font-black text-brand-950 tracking-tight">{{ $totalTeachers }}</h3>
                </div>
            </div>
            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-accent w-[92%] rounded-full shadow-[0_0_8px_rgba(124,58,237,0.5)]"></div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="glass-card glass-card-hover p-8 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-5 mb-5">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center border border-orange-100/50 text-orange-500">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Slow Learners</p>
                    <h3 class="text-3xl font-display font-black text-brand-950 tracking-tight">{{ $slowLearners }}</h3>
                </div>
            </div>
            <div class="inline-flex items-center gap-1 px-2.5 py-1 bg-orange-50 text-orange-700 text-xs font-bold rounded-lg border border-orange-100 mt-2">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Active Intervention Required
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass-card overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-white/50">
                <h3 class="font-display font-bold text-lg text-gray-900">Class-wise Enrollment</h3>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Class Name</th>
                            <th class="px-8 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Students</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($classDistribution as $class)
                        <tr>
                            <td class="px-8 py-4 text-sm font-bold text-gray-900">{{ $class->name }}</td>
                            <td class="px-8 py-4 text-right text-sm text-gray-600">{{ $class->students_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-white/50">
                <h3 class="font-display font-bold text-lg text-gray-900">Recently Registered Users</h3>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentUsers as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-xs">{{ substr($user->name, 0, 1) }}</div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-[11px] text-gray-500 font-medium uppercase tracking-widest">{{ $user->role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-right text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
