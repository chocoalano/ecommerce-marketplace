<section class="relative">
    <div class="w-full px-4 mx-auto sm:px-6 lg:px-0">
        <div class="grid grid-cols-1 gap-16 mx-auto lg:grid-cols-2 max-md:px-2">
            <!-- Product Image Section -->
            <div class="img">
                <div class="h-full img-box max-lg:mx-auto">
                    <img src="{{ asset('storage/' . $product['primary_image']) }}" alt="Product Image"
                        class="object-cover rounded-2xl h-fit max-h-96 max-lg:mx-auto lg:ml-auto ring-1 ring-gray-100">
                </div>
            </div>

            <!-- Product Details Section -->
            <div
                class="flex items-center justify-center w-full pr-0 my-0 data lg:pr-8 xl:justify-start max-lg:pb-10 xl:my-2 lg:my-5">
                <div class="w-full max-w-xl">
                    <!-- Category -->
                    @if($product->category->isNotEmpty())
                        <p class="mb-4 text-lg font-medium leading-8 text-green-600">
                            {{ $product->category->first()->name }} /&nbsp; Menswear
                        </p>
                    @else
                        <p class="mb-4 text-lg font-medium leading-8 text-gray-500">No Category Available</p>
                    @endif

                    <!-- Product Title -->
                    <h2 class="mb-2 text-3xl font-bold leading-10 text-gray-900 capitalize font-manrope">
                        {{ $product->name }}
                    </h2>
                    <!-- Product Price and Reviews -->
                    <div class="flex flex-col mb-6 sm:flex-row sm:items-center">
                        <h6
                            class="pr-5 mr-5 text-2xl font-semibold leading-9 text-gray-900 border-gray-200 font-manrope sm:border-r">
                            ${{ $product->price }}
                        </h6>
                        
                        <div class="flex items-center gap-2">
                            <span class="pl-2 text-lg font-normal leading-7 text-gray-500">{{ $product->seller->store_name }}</span>
                        </div>
                    </div>
                    <!-- Product Description -->
                    <p class="mb-5 text-base font-normal text-gray-500">
                        {!! $product->description !!}
                    </p>

                    <!-- Quantity Selection -->
                    <div class="flex w-full mt-10 sm:items-center sm:justify-center">
                        <button wire:click="decrementQuantity"
                            class="px-6 py-4 transition-all duration-300 bg-white border border-gray-400 rounded-l-full group hover:bg-gray-50 hover:shadow-sm hover:shadow-gray-300">-</button>
                        <input type="text"
                            class="font-semibold text-gray-900 cursor-pointer text-lg py-[13px] px-6 w-full sm:max-w-[118px] outline-0 border-y border-gray-400 bg-transparent placeholder:text-gray-900 text-center hover:bg-gray-50"
                            value="{{ $quantity }}" readonly>
                        <button wire:click="incrementQuantity"
                            class="px-6 py-4 transition-all duration-300 bg-white border border-gray-400 rounded-r-full group hover:bg-gray-50 hover:shadow-sm hover:shadow-gray-300">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <div class="py-8">
                        <button wire:click="addToCart({{ $product->id }})"
                            class="flex items-center justify-center w-full gap-2 px-5 py-4 text-lg font-semibold text-green-600 transition-all duration-500 rounded-full group bg-green-50 hover:bg-green-100">
                            <svg class="stroke-green-600" width="22" height="22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908"
                                    stroke="#9CA3AF" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                            <span>Masukan ke keranjang</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>