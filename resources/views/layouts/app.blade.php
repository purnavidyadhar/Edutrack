<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduTrack Studio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{--ink:#101828;--muted:#667085;--surface:#fff;--line:#e7eaf0;--purple:#7c3aed;--blue:#2563eb;--green:#10b981;--orange:#f97316;}
        body{font-family:Inter,system-ui,sans-serif;background:#f5f7fb;color:var(--ink);}
        .font-display{font-family:'Plus Jakarta Sans',Inter,sans-serif}.dash-bg{background:radial-gradient(circle at top left,rgba(37,99,235,.16),transparent 36rem),radial-gradient(circle at 80% 0,rgba(124,58,237,.14),transparent 34rem),linear-gradient(180deg,#f8fbff 0,#eef3fb 100%)}
        .top-shell{background:rgba(255,255,255,.78);backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,.7);box-shadow:0 18px 55px rgba(15,23,42,.08)}
        .glass-panel{background:rgba(255,255,255,.78);backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,.7);box-shadow:0 18px 55px rgba(15,23,42,.08);transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);}
        .glass-panel:hover{transform:translateY(-4px);box-shadow:0 24px 70px rgba(15,23,42,.12);}
        .nav-pill{display:flex;align-items:center;gap:.55rem;padding:.7rem 1rem;border-radius:999px;font-size:.84rem;font-weight:800;color:#5b6475;transition:.2s}.nav-pill:hover{background:#f1f5ff;color:#1d4ed8}.nav-pill.active{background:#111827;color:#fff;box-shadow:0 12px 28px rgba(17,24,39,.18)}
        .neo-card{background:rgba(255,255,255,.82);border:1px solid rgba(255,255,255,.86);border-radius:28px;box-shadow:0 24px 70px rgba(15,23,42,.08),inset 0 1px 0 rgba(255,255,255,.9)}
        .soft-card{background:#fff;border:1px solid var(--line);border-radius:24px;box-shadow:0 14px 35px rgba(15,23,42,.055)}
        .mini-label{font-size:.68rem;text-transform:uppercase;letter-spacing:.14em;font-weight:900;color:#98a2b3}.gradient-title{background:linear-gradient(90deg,#2563eb,#7c3aed,#db2777);-webkit-background-clip:text;background-clip:text;color:transparent}.btn-primary{display:inline-flex;align-items:center;gap:.55rem;border-radius:16px;background:#111827;color:white;font-weight:900;padding:.85rem 1.15rem;box-shadow:0 15px 35px rgba(17,24,39,.16)}.btn-secondary{display:inline-flex;align-items:center;gap:.55rem;border-radius:16px;background:white;color:#111827;font-weight:900;padding:.85rem 1.15rem;border:1px solid #e5e7eb}.orb{position:absolute;border-radius:999px;filter:blur(45px);opacity:.45;pointer-events:none}.progress-ring{background:conic-gradient(var(--blue) calc(var(--p)*1%),#e5e7eb 0)}
    </style>
</head>
<body class="dash-bg min-h-screen">
@auth
    <div class="sticky top-4 z-50 px-4 md:px-8">
        <div class="top-shell max-w-[1500px] mx-auto rounded-[28px] px-4 py-3 flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-600 to-purple-600 text-white grid place-items-center shadow-lg"><i data-lucide="graduation-cap" class="w-5 h-5"></i></div>
                <div class="hidden sm:block"><div class="font-display font-black text-xl leading-none">EduTrack</div><div class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400">Learning Studio</div></div>
            </a>
            <nav class="hidden lg:flex items-center gap-1">
                @if(auth()->user()->role === 'teacher' || auth()->user()->role === 'admin')
                    <a class="nav-pill {{ request()->routeIs('teacher.dashboard','admin.dashboard') ? 'active' : '' }}" href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'teacher.dashboard') }}"><i data-lucide="layout-grid" class="w-4 h-4"></i> Command Center</a>
                    <a class="nav-pill {{ request()->routeIs('students*') ? 'active' : '' }}" href="{{ route('students.index') }}"><i data-lucide="users-round" class="w-4 h-4"></i> Learners</a>
                    <a class="nav-pill {{ request()->routeIs('plans*') ? 'active' : '' }}" href="{{ route('plans.index') }}"><i data-lucide="sparkles" class="w-4 h-4"></i> Support Plans</a>
                    <a class="nav-pill {{ request()->routeIs('reports') ? 'active' : '' }}" href="{{ route('reports') }}"><i data-lucide="chart-no-axes-combined" class="w-4 h-4"></i> Insights</a>
                @else
                    <a class="nav-pill {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}"><i data-lucide="home" class="w-4 h-4"></i> My Space</a>
                @endif
            </nav>
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-3 py-2"><i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i><span class="text-xs font-black uppercase tracking-wide text-slate-500">{{ auth()->user()->role }}</span></div>
                <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white grid place-items-center font-black">{{ substr(auth()->user()->name,0,1) }}</div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn-secondary !p-3" title="Logout"><i data-lucide="log-out" class="w-4 h-4"></i></button></form>
            </div>
        </div>
    </div>
@endauth
<main class="px-4 md:px-8 py-8">
    <div class="max-w-[1500px] mx-auto">
        @if(session('error'))<div class="mb-5 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700 font-bold">{{ session('error') }}</div>@endif
        @if(session('success'))<div class="mb-5 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-700 font-bold">{{ session('success') }}</div>@endif
        {{ $slot ?? '' }}
        @yield('content')
    </div>
</main>
<script>lucide.createIcons();</script>
@yield('scripts')
</body>
</html>
