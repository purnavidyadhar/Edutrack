@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8 animate-fadeInUp">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                Send Feedback to {{ $student->user->name }}
            </h1>
            <p class="text-gray-600">Help them grow with constructive feedback and encouragement</p>
        </div>

        <!-- Feedback Form Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <p class="text-white text-sm font-medium">Student Profile</p>
            </div>
            
            <div class="p-6">
                <!-- Student Info -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">
                                {{ strtoupper(substr($student->user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $student->user->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $student->user->email }}</p>
                            <p class="text-sm text-gray-500">Roll No: {{ $student->roll_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feedback Form -->
                <form action="{{ route('feedback.submit', $student) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Title Field -->
                    <div class="animate-slideInLeft" style="animation-delay: 0.1s">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <i class="lucide-icon text-blue-600">📝</i>
                                Feedback Title
                            </span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            placeholder="e.g., Great improvement in Math" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feedback Type -->
                    <div class="animate-slideInLeft" style="animation-delay: 0.2s">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <i class="lucide-icon text-green-600">🎯</i>
                                Feedback Type
                            </span>
                        </label>
                        <select 
                            id="type" 
                            name="type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            required
                        >
                            <option value="">Select feedback type...</option>
                            <option value="progress">📈 Progress - General feedback on improvement</option>
                            <option value="encouragement">💪 Encouragement - Motivational feedback</option>
                            <option value="improvement">⚡ Improvement - Areas to work on</option>
                            <option value="achievement">🌟 Achievement - Recognition of success</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div class="animate-slideInLeft" style="animation-delay: 0.3s">
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <i class="lucide-icon text-yellow-600">⭐</i>
                                Rating (Optional)
                            </span>
                        </label>
                        <div class="flex gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <input 
                                    type="radio" 
                                    id="rating-{{ $i }}" 
                                    name="rating" 
                                    value="{{ $i }}"
                                    class="hidden"
                                >
                                <label 
                                    for="rating-{{ $i }}" 
                                    class="cursor-pointer text-3xl transition transform hover:scale-125"
                                    title="{{ ['Poor', 'Needs Help', 'Average', 'Good', 'Excellent'][$i-1] }}"
                                >
                                    <span class="inline-block star opacity-30">⭐</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feedback Message -->
                    <div class="animate-slideInLeft" style="animation-delay: 0.4s">
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="inline-flex items-center gap-2">
                                <i class="lucide-icon text-purple-600">💬</i>
                                Detailed Feedback
                            </span>
                        </label>
                        <textarea 
                            id="feedback" 
                            name="feedback" 
                            rows="6" 
                            placeholder="Share specific feedback, suggestions, and encouragement..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                            required
                        ></textarea>
                        <p class="text-gray-500 text-xs mt-1">Max 1000 characters</p>
                        @error('feedback')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4 animate-slideInUp" style="animation-delay: 0.5s">
                        <button 
                            type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105 active:scale-95"
                        >
                            <span class="inline-flex items-center gap-2">
                                <i class="lucide-icon">✉️</i>
                                Send Feedback
                            </span>
                        </button>
                        <a 
                            href="{{ route('students.show', $student) }}" 
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-3 rounded-lg transition text-center"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded animate-fadeInUp" style="animation-delay: 0.6s">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">💡 Tips for Effective Feedback</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li>✓ Be specific - mention particular examples or improvements</li>
                <li>✓ Be constructive - focus on what can be improved and how</li>
                <li>✓ Be encouraging - acknowledge efforts and progress</li>
                <li>✓ Be timely - provide feedback soon after the performance</li>
            </ul>
        </div>
    </div>
</div>

<style>
    input[type="radio"]:checked + label .star {
        opacity: 1;
    }
    
    label .star {
        transition: opacity 0.2s;
    }
</style>
@endsection
