<!-- Quick Rating Widget -->
<div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-200">
    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <i class="lucide-icon text-yellow-600">⭐</i>
        Quick Rating
    </h4>
    
    <form action="{{ route('feedback.rate', $student) }}" method="POST" class="space-y-4">
        @csrf
        
        <!-- Star Rating -->
        <div>
            <p class="text-sm text-gray-600 mb-3">Select a rating:</p>
            <div class="flex gap-3 justify-center">
                @for ($i = 1; $i <= 5; $i++)
                    <input 
                        type="radio" 
                        id="quick-rating-{{ $i }}" 
                        name="rating" 
                        value="{{ $i }}"
                        class="hidden"
                        required
                    >
                    <label 
                        for="quick-rating-{{ $i }}" 
                        class="cursor-pointer text-4xl transition transform hover:scale-110 star-btn"
                        title="{{ ['⚠️ Poor', '⚠️ Needs Help', '✓ Average', '✓ Good', '🌟 Excellent'][$i-1] }}"
                        data-rating="{{ $i }}"
                    >
                        <span class="star-icon opacity-40">⭐</span>
                    </label>
                @endfor
            </div>
        </div>

        <!-- Auto Message Display -->
        <div id="auto-message" class="text-center text-sm text-gray-600 h-6"></div>

        <!-- Optional Custom Message -->
        <div>
            <label for="quick-message" class="block text-sm text-gray-700 mb-2">Optional message:</label>
            <textarea 
                id="quick-message" 
                name="message" 
                placeholder="Add a quick message..." 
                rows="2"
                maxlength="200"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"
            ></textarea>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-2 rounded-lg transition transform hover:scale-105 active:scale-95"
        >
            <span class="inline-flex items-center gap-2">
                <i class="lucide-icon">✈️</i>
                Send Rating
            </span>
        </button>
    </form>
</div>

<style>
    .star-btn .star-icon {
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    
    input[type="radio"]:checked + label .star-icon {
        opacity: 1;
        transform: scale(1.15);
    }
</style>

<script>
    const messages = {
        1: '💪 Don\'t give up! You can do better!',
        2: '⚡ Let\'s improve together!',
        3: '📚 Doing well. Practice more!',
        4: '👍 Good progress! Well done!',
        5: '🌟 Excellent work! Keep it up!'
    };

    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const messageEl = document.getElementById('auto-message');
            messageEl.textContent = messages[this.value];
            messageEl.style.animation = 'none';
            setTimeout(() => {
                messageEl.style.animation = 'fadeIn 0.3s ease';
            }, 10);
        });
    });
</script>
