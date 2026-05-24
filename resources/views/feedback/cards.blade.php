<!-- Feedback from Teachers Section -->
<div class="animate-fadeInUp">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <i class="lucide-icon text-blue-600">💌</i>
            Feedback from Teachers
        </h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
            {{ count($feedbacks) }} message{{ count($feedbacks) !== 1 ? 's' : '' }}
        </span>
    </div>

    @if ($feedbacks->isEmpty())
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-8 text-center border-2 border-dashed border-blue-200">
            <div class="text-4xl mb-3">📭</div>
            <p class="text-gray-600 text-lg font-medium mb-2">No feedback yet</p>
            <p class="text-gray-500 text-sm">Keep working hard! Your teachers will share feedback soon.</p>
        </div>
    @else
        <!-- Feedback Cards Grid -->
        <div class="space-y-4">
            @foreach ($feedbacks as $feedback)
                <div class="feedback-card bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 
                    {{ $feedback->type === 'achievement' ? 'border-green-500 bg-gradient-to-r from-green-50' : 
                       ($feedback->type === 'encouragement' ? 'border-blue-500 bg-gradient-to-r from-blue-50' :
                       ($feedback->type === 'improvement' ? 'border-orange-500 bg-gradient-to-r from-orange-50' : 'border-indigo-500 bg-gradient-to-r from-indigo-50')) }}
                    to-transparent overflow-hidden"
                    style="animation: slideInLeft 0.5s ease-out; animation-fill-mode: forwards; opacity: 0;">
                    
                    <div class="p-5">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <!-- Type Badge -->
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $feedback->type === 'achievement' ? 'bg-green-200 text-green-800' : 
                                           ($feedback->type === 'encouragement' ? 'bg-blue-200 text-blue-800' :
                                           ($feedback->type === 'improvement' ? 'bg-orange-200 text-orange-800' : 'bg-indigo-200 text-indigo-800')) }}">
                                        @switch($feedback->type)
                                            @case('achievement')
                                                🌟 Achievement
                                                @break
                                            @case('encouragement')
                                                💪 Encouragement
                                                @break
                                            @case('improvement')
                                                ⚡ Improvement
                                                @break
                                            @default
                                                📈 Progress
                                        @endswitch
                                    </span>
                                    
                                    <!-- Rating Stars -->
                                    @if ($feedback->rating)
                                        <span class="text-lg" title="{{ $feedback->rating }}/5 rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $feedback->rating)
                                                    <span class="text-yellow-400">⭐</span>
                                                @else
                                                    <span class="text-gray-300">⭐</span>
                                                @endif
                                            @endfor
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-lg font-semibold text-gray-900">{{ $feedback->title }}</h3>
                                <p class="text-sm text-gray-600">From: <strong>{{ $feedback->teacher->user->name }}</strong></p>
                            </div>
                            
                            <!-- Read Status -->
                            @if (!$feedback->is_read)
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full animate-pulse"></span>
                            @endif
                        </div>

                        <!-- Feedback Content -->
                        <div class="bg-white bg-opacity-60 rounded p-4 mb-3">
                            <p class="text-gray-800 text-sm leading-relaxed">{{ $feedback->feedback }}</p>
                        </div>

                        <!-- Footer -->
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <time datetime="{{ $feedback->created_at->toIso8601String() }}">
                                📅 {{ $feedback->created_at->format('M d, Y') }} at {{ $feedback->created_at->format('h:i A') }}
                            </time>
                            @if (!$feedback->is_read)
                                <form action="{{ route('feedback.markRead', $feedback) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Mark as read
                                    </button>
                                </form>
                            @else
                                <span class="text-green-600">✓ Read</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        @if ($feedbacks instanceof \Illuminate\Pagination\AbstractPaginator && $feedbacks->hasPages())
            <div class="mt-6">
                {{ $feedbacks->links() }}
            </div>
        @endif
    @endif
</div>

<style>
    .feedback-card {
        animation-delay: var(--delay, 0s);
    }
</style>

@push('scripts')
<script>
    // Set staggered animation delays
    document.querySelectorAll('.feedback-card').forEach((card, index) => {
        card.style.setProperty('--delay', (index * 0.1) + 's');
        // Trigger animation
        card.style.opacity = '1';
    });
</script>
@endpush
