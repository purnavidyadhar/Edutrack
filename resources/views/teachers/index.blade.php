@extends('layouts.dashboard')

@section('header', 'Manage Teachers')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Overview
    </a>
    <a href="{{ route('teachers.index') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="graduation-cap" class="w-4 h-4"></i> Teachers
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('classes.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="book-open" class="w-4 h-4"></i> Classes
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <p class="text-gray-500 font-medium">Manage and monitor all institutional teaching staff.</p>
        <button class="px-5 py-2.5 bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-500/20 hover:bg-brand-600 transition-all flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Register Teacher
        </button>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Teacher Info</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Email</th>
                        <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Date Joined</th>
                        <th class="px-8 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white/30">
                    @foreach($teachers as $teacher)
                    <tr class="hover:bg-white/80 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">{{ substr($teacher->user->name, 0, 1) }}</div>
                                <p class="font-bold text-gray-900">{{ $teacher->user->name }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-medium text-gray-500">{{ $teacher->user->email }}</td>
                        <td class="px-8 py-5 text-sm font-medium text-gray-400">{{ $teacher->created_at->format('M d, Y') }}</td>
                        <td class="px-8 py-5 text-right">
                            <button class="text-xs font-bold text-brand-500 hover:text-brand-700">Manage Account</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 border-t border-gray-100 bg-white/50">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection
