@props(['name'])

<div class="flex items-center gap-8 mb-32">
    <div x-data="{ rating: @entangle($attributes->wire('model')) }" class="flex items-center space-x-2">
        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
            <button type="button"
                :class="{
                    'text-yellow-400': star <= rating,
                    'text-gray-300': star > rating
                }"
                class="text-15 font-[500]" x-on:click="rating = star"
                aria-label="star">
                <i class="ph-fill ph-star"></i>
            </button>
        </template>

        <!-- Hidden Input for Livewire Synchronization -->
        <input type="hidden" name="{{ $name }}" x-model="rating">

        @error($name)
            <span class="error text-red-800 mt-5">{{ $message }}</span>
        @enderror
    </div>
</div>
