<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EduTrack Pro – Secure Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F8FAFC; }
        .hero-glow {
            position: absolute; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%; filter: blur(80px); z-index: 0;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-6 relative overflow-hidden">
    <div class="hero-glow -top-20 -left-20"></div>
    <div class="hero-glow -bottom-20 -right-20"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="flex flex-col items-center mb-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-xl shadow-indigo-500/20 mb-4">
                <i data-lucide="sparkles" class="w-7 h-7 text-white"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-[#020617] tracking-tight">Institutional Portal</h1>
            <p class="text-gray-500 font-medium mt-2">Manage your education ecosystem securely</p>
        </div>

        <div class="bg-white/70 backdrop-blur-xl border border-white p-10 rounded-[32px] shadow-2xl shadow-indigo-900/5">
            {{ $slot }}
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
