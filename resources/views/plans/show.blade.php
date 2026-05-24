@extends('layouts.dashboard')

@section('header', 'Remedial Plan Details')

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
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between mb-2">
        <a href="{{ route('teacher.dashboard') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 flex items-center gap-2 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-[#eaeaea] hover:border-gray-300 text-sm font-semibold text-gray-700 rounded-lg shadow-sm transition-all flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i> Print Plan
            </button>
            @if($plan->status === 'Active')
                <form action="{{ route('plans.complete', $plan->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-sm font-semibold rounded-lg shadow-sm shadow-brand-500/20 transition-all flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4 text-brand-100"></i> Mark Completed
                    </button>
                </form>
            @else
                <div class="px-4 py-2 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold rounded-lg shadow-sm flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i> Plan Completed
                </div>
            @endif
        </div>
    </div>

    <!-- Top Card -->
    <div class="vercel-card p-8">
        <div class="flex items-start justify-between border-b border-[#eaeaea] pb-6 mb-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center border border-brand-100 text-brand-600 font-display font-bold text-2xl">
                    {{ substr($plan->student->user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-display font-bold text-gray-900">{{ $plan->student->user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Roll Number: {{ $plan->student->roll_number }} • Risk Score: <span class="font-bold text-orange-600">{{ number_format($plan->student->risk_score, 1) }}</span></p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60 uppercase tracking-widest"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Active Plan</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Subject</p>
                <p class="text-sm font-semibold text-gray-900">{{ $plan->subject }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Duration</p>
                <p class="text-sm font-semibold text-gray-900">{{ $plan->duration }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Assigned Teacher</p>
                <p class="text-sm font-semibold text-gray-900">{{ $plan->teacher->user->name }}</p>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Methodology</p>
                <p class="text-sm font-semibold text-brand-600">{{ $plan->preferred_style }}</p>
            </div>
        </div>
    </div>

    <!-- AI Plan Output -->
    <div class="vercel-card overflow-hidden">
        <div class="bg-[#fafafa] border-b border-[#eaeaea] px-8 py-5 flex items-center justify-between">
            <h3 class="font-display font-bold text-gray-900 flex items-center gap-2">
                <i data-lucide="sparkles" class="w-4 h-4 text-brand-600"></i> AI Generated Strategy
            </h3>
        </div>
        <div class="p-8 prose prose-sm max-w-none text-gray-600">
            {!! Str::markdown($plan->generated_plan) !!}
        </div>
    </div>

    <!-- Progress Tracking Section -->
    <div class="vercel-card overflow-hidden">
        <div class="bg-[#fafafa] border-b border-[#eaeaea] px-8 py-5 flex items-center justify-between">
            <h3 class="font-display font-bold text-gray-900">Tracking & Progress</h3>
            <button onclick="document.getElementById('progressModal').classList.remove('hidden')" class="text-sm font-semibold text-brand-600 hover:text-brand-800 transition-colors flex items-center gap-1">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Record
            </button>
        </div>

        <!-- Add Progress Modal -->
        <div id="progressModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-display font-bold text-gray-900">Record Progress</h3>
                    <button onclick="document.getElementById('progressModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                
                <form action="{{ route('plans.progress', $plan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Observations / Notes</label>
                        <textarea name="notes" required rows="3" placeholder="Describe current concepts mastered, areas still needing support..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-950 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all resize-none"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Improvement Rate (%)</label>
                        <input type="number" name="improvement_percentage" required min="0" max="100" placeholder="e.g. 15" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-950 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('progressModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">Cancel</button>
                        <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-md transition-all">Save Progress</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="p-0">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#eaeaea]">
                        <th class="px-8 py-3 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Date</th>
                        <th class="px-8 py-3 text-[11px] font-bold text-gray-500 uppercase tracking-widest">Notes</th>
                        <th class="px-8 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-widest">Improvement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eaeaea] bg-white text-sm">
                    @forelse($plan->progressRecords as $record)
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="px-8 py-4 text-gray-600">{{ $record->created_at->format('M d, Y') }}</td>
                        <td class="px-8 py-4 text-gray-900">{{ $record->notes }}</td>
                        <td class="px-8 py-4 text-right">
                            <span class="inline-flex items-center gap-1 font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-md border border-green-100">
                                <i data-lucide="trending-up" class="w-3 h-3"></i> +{{ $record->improvement_percentage }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-8 text-center text-sm text-gray-500 font-medium">No progress records added yet. Monitor the student and record outcomes here.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
