<div id="controls-carousel" class="relative w-full mt-5 overflow-hidden">
    <!-- Carousel wrapper -->
    <div class="relative flex transition-transform duration-700 ease-in-out gap-x-2"
         id="carousel-inner"
         style="transform: translateX(-{{ $currentIndex * 100 }}%);">
        @foreach($items as $item)
            <div class="flex items-center justify-center h-16 font-semibold text-center text-white rounded-lg w-60 bg-slate-400 shrink-0">
                {{ $item['name'] }}
            </div>
        @endforeach
    </div>

    <!-- Slider controls -->
    <button type="button" wire:click="prev" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer start-0 group focus:outline-none">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-50 group-hover:bg-green/50">
            <svg class="w-4 h-4 text-green" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
        </span>
    </button>
    <button type="button" wire:click="next" class="absolute top-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer end-0 group focus:outline-none">
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-50 group-hover:bg-green/50">
            <svg class="w-4 h-4 text-green" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
        </span>
    </button>
</div>
