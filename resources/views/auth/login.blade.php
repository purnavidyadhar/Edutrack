<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Email Address</label>
            <div class="relative">
                <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@institution.com" class="w-full pl-12 pr-4 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2 mt-4">
            <label for="password" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Password</label>
            <div class="relative">
                <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-12 pr-4 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="space-y-2 mt-4">
            <label for="role" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Portal Access</label>
            <select id="role" name="role" required class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                <option value="teacher">Teacher Portal</option>
                <option value="student">Student Portal</option>
                <option value="admin">Administrator Portal</option>
            </select>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4 px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm font-semibold text-gray-500 hover:text-gray-700 transition-colors">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-500/25 transition-all flex items-center justify-center gap-2">
                Sign In <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </button>
            <p class="text-center text-sm font-bold text-gray-500">
                New user? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Create account</a>
            </p>
        </div>
    </form>
</x-guest-layout>
