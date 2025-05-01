<div class="relative w-full" x-data="{ currentIndex: @entangle('currentIndex') }">
    <!-- Carousel Wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        @foreach ($images as $index => $image)
            <div x-show="currentIndex === {{ $index }}"
                class="absolute inset-0 transition-opacity duration-500 ease-in-out">
                <img src="{{ $image }}" class="block object-cover w-full h-full" alt="Slide {{ $index + 1 }}">
            </div>
        @endforeach
    </div>

    <!-- Slider Controls -->
    <button type="button" wire:click="prev"
        class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer start-0 group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-50 group-hover:bg-green/50 group-focus:ring-4 group-focus:ring-green dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-green-700 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" wire:click="next"
        class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer end-0 group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-50 group-hover:bg-green/50 group-focus:ring-4 group-focus:ring-green dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-green-700 rtl:rotate-180" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>