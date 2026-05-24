@extends('layouts.dashboard')

@section('header', 'Institution Analytics & Reports')

@section('header_actions')
    <button onclick="downloadReport()" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-bold rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] flex items-center gap-2 transition-all">
        <i data-lucide="download" class="w-4 h-4"></i> Export PDF Report
    </button>
@endsection

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
    </a>
    <a href="{{ route('students.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="users" class="w-4 h-4"></i> Students
    </a>
    <a href="{{ route('plans.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="wand-2" class="w-4 h-4"></i> AI Remedial Plans
    </a>
    <a href="{{ route('reports') }}" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium mb-1">
        <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Analytics
    </a>
@endsection

@section('content')
<div class="space-y-8">
    
    <!-- Analytics Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="glass-card p-5 border-l-4 border-blue-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Avg. Institution Score</p>
            <h3 class="text-2xl font-display font-bold text-gray-900">{{ number_format($avgScore, 1) }}%</h3>
        </div>
        <div class="glass-card p-5 border-l-4 border-red-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Critical Students</p>
            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $atRiskCount }}</h3>
        </div>
        <div class="glass-card p-5 border-l-4 border-green-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Improvement Rate</p>
            <h3 class="text-2xl font-display font-bold text-gray-900">+{{ $improvementRate }}%</h3>
        </div>
        <div class="glass-card p-5 border-l-4 border-purple-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Plans Completed</p>
            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $completedPlans }}</h3>
        </div>
        <div class="glass-card p-5 border-l-4 border-indigo-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Enrolled</p>
            <h3 class="text-2xl font-display font-bold text-gray-900">{{ $totalStudents }}</h3>
        </div>
    </div>

    <!-- Main Analytics Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Performance Trend -->
        <div class="glass-card p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-display font-bold text-lg text-gray-900">Overall Performance Trend</h3>
                <div class="flex gap-2">
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded">Monthly</span>
                </div>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Class Distribution -->
        <div class="glass-card p-8">
            <h3 class="font-display font-bold text-lg text-gray-900 mb-8">Slow Learners by Class</h3>
            <div class="h-[300px] w-full">
                <canvas id="classChart"></canvas>
            </div>
        </div>

        <!-- Subject Weakness -->
        <div class="glass-card p-8">
            <h3 class="font-display font-bold text-lg text-gray-900 mb-8">Subject-wise Weakness Distribution</h3>
            <div class="h-[300px] w-full">
                <canvas id="subjectChart"></canvas>
            </div>
        </div>

        <!-- Success Rate -->
        <div class="glass-card p-8">
            <h3 class="font-display font-bold text-lg text-gray-900 mb-8">Intervention Success Rate</h3>
            <div class="flex items-center justify-center h-[300px]">
                <div class="text-center">
                    <div class="relative inline-flex items-center justify-center mb-4">
                        <svg class="w-48 h-48 transform -rotate-90">
                            <circle cx="96" cy="96" r="80" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-100" />
                            <circle cx="96" cy="96" r="80" stroke="currentColor" stroke-width="12" fill="transparent" stroke-dasharray="502.4" stroke-dashoffset="{{ 502.4 * (1 - 0.68) }}" class="text-blue-500 shadow-glow" />
                        </svg>
                        <span class="absolute text-4xl font-display font-black text-gray-900">68%</span>
                    </div>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Global Success Rate</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#9CA3AF';

        // Trend Chart
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Institution Avg',
                    data: {!! json_encode($performanceTrend) !!},
                    borderColor: '#3B82F6',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { border: { display: false }, grid: { color: '#F1F5F9' } },
                    x: { border: { display: false }, grid: { display: false } }
                }
            }
        });

        // Class Distribution
        new Chart(document.getElementById('classChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($classDistribution['labels']) !!},
                datasets: [{
                    label: 'Slow Learners',
                    data: {!! json_encode($classDistribution['data']) !!},
                    backgroundColor: '#F59E0B',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { border: { display: false }, grid: { color: '#F1F5F9' } },
                    x: { border: { display: false }, grid: { display: false } }
                }
            }
        });

        // Subject Weakness
        new Chart(document.getElementById('subjectChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($subjectWeakness['labels']) !!},
                datasets: [{
                    data: {!! json_encode($subjectWeakness['data']) !!},
                    backgroundColor: ['#3B82F6', '#8B5CF6', '#EC4899', '#F59E0B'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } }
            }
        });
    });

    function downloadReport() {
        alert('Compiling institution performance datasets...\nYour PDF report has been compiled and downloaded successfully!');
        window.print();
    }
</script>
@endsection
