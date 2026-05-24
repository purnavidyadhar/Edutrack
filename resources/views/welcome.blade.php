@extends('layouts.public')

@section('title', 'Slow Learner Identification & Remedial Support')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-20 pb-24 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            @if(session('error'))
                <div class="mb-8 p-5 bg-white/80 backdrop-blur-md border border-red-100 rounded-3xl flex items-center gap-4 text-red-700 font-bold shadow-xl shadow-red-500/5 animate-bounce-subtle">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                        <i data-lucide="alert-circle" class="w-6 h-6 text-red-500"></i>
                    </div>
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="hero-glow"></div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Side -->
            <div class="relative z-10 space-y-8 animate-fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-50 text-brand-500 rounded-full text-xs font-bold uppercase tracking-widest border border-brand-100">
                    <i data-lucide="award" class="w-4 h-4"></i> Smart Education Management
                </div>
                <h1 class="text-6xl md:text-7xl font-display font-extrabold text-brand-950 leading-[1.1] tracking-tight">
                    Identify Slow Learners. <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-accent">Empower Bright Futures.</span>
                </h1>
                <p class="text-xl text-[#64748B] font-medium leading-relaxed max-w-xl">
                    A smart educational support system that helps teachers identify slow learners, provide remedial teaching, track progress, and improve learning outcomes through innovative methods.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-brand-950 text-white font-bold rounded-2xl hover:bg-brand-900 transition-all shadow-2xl shadow-brand-950/20 flex items-center gap-2 group">
                        Explore Dashboard <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="#" class="px-8 py-4 bg-white border border-gray-200 text-brand-950 font-bold rounded-2xl hover:border-brand-500 transition-all flex items-center gap-2">
                        <i data-lucide="play-circle" class="w-5 h-5 text-brand-500"></i> Watch Demo
                    </a>
                </div>
            </div>

            <!-- Right Side (Animated UI) -->
            <div class="relative z-10 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-[500px]">
                    <!-- Main Student Image Representation -->
                    <div class="w-full aspect-square rounded-[40px] bg-gradient-to-tr from-brand-100 to-purple-100 flex items-center justify-center p-12 animate-float">
                        <div class="w-full h-full rounded-[30px] overflow-hidden shadow-2xl border-4 border-white">
                             <img src="{{ asset('images/students.png') }}" alt="Students" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="absolute -top-10 -left-10 glass-card p-5 rounded-2xl animate-float" style="animation-delay: -1s">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Students</p>
                        <h4 class="text-2xl font-display font-black text-brand-950">1,284</h4>
                        <div class="mt-2 text-xs font-bold text-green-500 flex items-center gap-1">
                            <i data-lucide="trending-up" class="w-3 h-3"></i> +12% this term
                        </div>
                    </div>

                    <div class="absolute top-1/2 -right-12 glass-card p-5 rounded-2xl w-48 shadow-2xl animate-float" style="animation-delay: -2.5s">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Learner Progress</p>
                        <div class="h-2 w-full bg-gray-100 rounded-full mb-2 overflow-hidden">
                            <div class="h-full bg-brand-500 w-[78%] rounded-full shadow-[0_0_8px_rgba(79,70,229,0.5)]"></div>
                        </div>
                        <p class="text-[11px] font-bold text-brand-950">78% Improved</p>
                    </div>

                    <div class="absolute -bottom-8 left-1/4 glass-card px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-float" style="animation-delay: -4s">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-orange-500"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-black text-brand-950">42</h5>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Slow Learners</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Approach Section -->
    <section class="py-24 bg-white border-y border-gray-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <h2 class="text-4xl font-display font-extrabold text-brand-950">Our Approach</h2>
                <p class="text-lg text-[#64748B] font-medium leading-relaxed">
                    Smart solutions for better learning through identification, intervention, and continuous improvement.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Approach Card 1 -->
                <a href="{{ route('features') }}" class="group p-8 bg-[#F8FAFC] border border-gray-100 rounded-3xl hover:bg-brand-950 transition-all hover:scale-[1.02] duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="search" class="w-7 h-7 text-brand-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-950 mb-3 group-hover:text-white">Smart Identification</h3>
                    <p class="text-sm text-[#64748B] group-hover:text-brand-100/80 leading-relaxed">
                        Algorithmic detection of slow learners using multi-dimensional performance metrics.
                    </p>
                </a>

                <!-- Approach Card 2 -->
                <a href="{{ route('features') }}" class="group p-8 bg-[#F8FAFC] border border-gray-100 rounded-3xl hover:bg-brand-950 transition-all hover:scale-[1.02] duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="user-check" class="w-7 h-7 text-accent"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-950 mb-3 group-hover:text-white">Personalized Support</h3>
                    <p class="text-sm text-[#64748B] group-hover:text-brand-100/80 leading-relaxed">
                        Tailored remedial teaching plans generated specifically for each learner's weak areas.
                    </p>
                </a>

                <!-- Approach Card 3 -->
                <a href="{{ route('features') }}" class="group p-8 bg-[#F8FAFC] border border-gray-100 rounded-3xl hover:bg-brand-950 transition-all hover:scale-[1.02] duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="lightbulb" class="w-7 h-7 text-yellow-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-950 mb-3 group-hover:text-white">Innovative Teaching</h3>
                    <p class="text-sm text-[#64748B] group-hover:text-brand-100/80 leading-relaxed">
                        Suggesting visual, peer-to-peer, and activity-based learning methods for capacity building.
                    </p>
                </a>

                <!-- Approach Card 4 -->
                <a href="{{ route('features') }}" class="group p-8 bg-[#F8FAFC] border border-gray-100 rounded-3xl hover:bg-brand-950 transition-all hover:scale-[1.02] duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i data-lucide="line-chart" class="w-7 h-7 text-green-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-950 mb-3 group-hover:text-white">Track & Improve</h3>
                    <p class="text-sm text-[#64748B] group-hover:text-brand-100/80 leading-relaxed">
                        Continuous monitoring of student progress with detailed analytics and reports.
                    </p>
                </a>
            </div>
        </div>
    </section>
@endsection
