@extends('layouts.public')
@section('title', 'About Us')

@section('content')
<div class="py-24 px-6 max-w-7xl mx-auto space-y-16">
    <div class="text-center space-y-4">
        <h1 class="text-5xl font-display font-extrabold text-brand-950">About EduTrack</h1>
        <p class="text-xl text-[#64748B] max-w-2xl mx-auto font-medium">Empowering education through intelligent student identification and support systems.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="glass-card p-10 space-y-6">
            <h2 class="text-3xl font-display font-bold text-brand-950">Our Mission</h2>
            <p class="text-lg text-[#64748B] leading-relaxed">
                EduTrack was built with a single goal: to ensure no student falls behind. By combining data analytics with pedagogical best practices, we help educators identify slow learners early and provide them with the tailored support they need to succeed.
            </p>
            <div class="flex gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-500">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <div>
                    <h4 class="font-bold text-brand-950">Data-Driven</h4>
                    <p class="text-sm text-gray-500">Decisions backed by real performance metrics.</p>
                </div>
            </div>
        </div>
        <div class="relative">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800" class="rounded-[40px] shadow-2xl" alt="Our Team">
        </div>
    </div>
</div>
@endsection
