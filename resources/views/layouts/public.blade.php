<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack – @yield('title', 'Slow Learner Identification & Remedial Support')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .hero-glow {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-[#0F172A] overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-accent flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-110 transition-transform">
                    <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                </div>
                <span class="font-display font-extrabold text-2xl tracking-tight text-brand-950">EduTrack</span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-bold text-[#64748B]">
                <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">Home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">About</a>
                <a href="{{ route('how-it-works') }}" class="{{ request()->routeIs('how-it-works') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">How It Works</a>
                <a href="{{ route('features') }}" class="{{ request()->routeIs('features') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">Features</a>
                <a href="{{ route('resources') }}" class="{{ request()->routeIs('resources') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">Resources</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-brand-500' : 'hover:text-brand-950 transition-colors' }}">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-brand-950 text-white text-sm font-bold rounded-full hover:bg-brand-900 transition-all shadow-xl shadow-brand-950/20">Go to Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-gray-500 hover:text-brand-950 transition-colors">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-brand-950 hover:text-brand-500 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-brand-500 text-white text-sm font-bold rounded-full hover:bg-brand-600 transition-all shadow-xl shadow-brand-500/20">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-brand-950 pt-20 pb-10 text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-2 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                            <i data-lucide="sparkles" class="w-5 h-5 text-brand-950"></i>
                        </div>
                        <span class="font-display font-extrabold text-2xl tracking-tight">EduTrack</span>
                    </div>
                    <p class="text-gray-400 max-w-sm leading-relaxed">
                        A professional educational support system dedicated to identifying slow learners and providing innovative remedial strategies for enhanced learning outcomes.
                    </p>
                </div>
                <div class="space-y-6">
                    <h4 class="font-bold text-lg">Quick Links</h4>
                    <div class="flex flex-col gap-3 text-gray-400 font-medium">
                        <a href="{{ route('about') }}" class="hover:text-white transition-colors">About Project</a>
                        <a href="{{ route('features') }}" class="hover:text-white transition-colors">Key Features</a>
                        <a href="{{ route('how-it-works') }}" class="hover:text-white transition-colors">Our Workflow</a>
                        <a href="{{ route('resources') }}" class="hover:text-white transition-colors">Resources</a>
                    </div>
                </div>
                <div class="space-y-6">
                    <h4 class="font-bold text-lg">Support</h4>
                    <div class="flex flex-col gap-3 text-gray-400 font-medium">
                        <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a>
                        <a href="#" class="hover:text-white transition-colors">Help Center</a>
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 pt-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-gray-500 text-sm">© 2026 EduTrack System. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors"><i data-lucide="github" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
