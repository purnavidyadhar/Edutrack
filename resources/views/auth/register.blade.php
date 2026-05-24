<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="name" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Full Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Smith" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Email Address</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="john@university.edu" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-2">
                <label for="password" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Role & Institution -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
            <div class="space-y-2">
                <label for="role" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Role</label>
                <select id="role" name="role" required onchange="toggleStudentFields(this.value)" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="md:col-span-2 space-y-2">
                <label for="institution_name" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Institution</label>
                <input id="institution_name" type="text" name="institution_name" required placeholder="Academic University" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
            </div>
        </div>

        <!-- Phone & Class/Department -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div class="space-y-2">
                <label for="phone_number" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Phone Number</label>
                <input id="phone_number" type="text" name="phone_number" placeholder="+1 (555) 019-2834" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" />
            </div>
            
            <div id="class_selection_wrapper" class="space-y-2 hidden">
                <label for="class_id" class="text-xs font-bold text-gray-700 uppercase tracking-widest px-1">Class / Department</label>
                <select id="class_id" name="class_id" class="w-full px-5 py-4 bg-white border border-gray-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                    <option value="">Select a Class</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <script>
            function toggleStudentFields(role) {
                const wrapper = document.getElementById('class_selection_wrapper');
                if (role === 'student') {
                    wrapper.classList.remove('hidden');
                } else {
                    wrapper.classList.add('hidden');
                }
            }
            // Trigger on load
            document.addEventListener('DOMContentLoaded', () => {
                toggleStudentFields(document.getElementById('role').value);
            });
        </script>

        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-lg rounded-2xl shadow-xl shadow-indigo-500/25 transition-all flex items-center justify-center gap-2">
                Complete Registration <i data-lucide="check" class="w-6 h-6"></i>
            </button>
            <a class="text-center text-sm font-bold text-gray-500 hover:text-indigo-600" href="{{ route('login') }}">
                Already registered? Sign in
            </a>
        </div>
    </form>
</x-guest-layout>
