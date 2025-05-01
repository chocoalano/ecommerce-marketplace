<div class="container px-3 pt-20 pb-5 md:pt-36">
    <section class="py-8 antialiased bg-white md:py-16">
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Shopping Cart</h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="w-full lg:max-w-2xl xl:max-w-4xl">
                    <div class="space-y-6">
                        @foreach($items as $item)
                            <div
                                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm md:p-6">
                                <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                    <div class="flex items-center py-1">
                                        <input id="{{ $item->id }}-ispay" type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-green-500 focus:ring-2"
                                            wire:change="toggleCheckbox($event.target.checked, {{ $item->id }})" {{ $item->ispay ? 'checked' : '' }}>
                                    </div>
                                    <a href="{{ route('catalog.detail', ['slug' => $item->product->slug]) }}"
                                        class="border border-gray-200 rounded-lg shrink-0 md:order-1">
                                        <img class="w-20 h-20" src="{{ asset('storage/' . $item->product->primary_image) }}"
                                            alt="{{ $item->name }}" />
                                    </a>

                                    <div class="flex items-center justify-between space-x-4 md:order-3 md:justify-end">
                                        <!-- Quantity Selector -->
                                        <div
                                            class="flex items-center px-3 py-1 space-x-2 bg-gray-100 border border-gray-300 rounded-lg">
                                            <button wire:click="decrement({{ $item->id }})"
                                                class="flex items-center justify-center w-8 h-8 text-gray-700 transition bg-gray-200 rounded-md shadow-sm hover:bg-gray-300">
                                                -
                                            </button>
                                            <input type="text"
                                                class="w-12 text-base font-medium text-center bg-transparent border-0 outline-none"
                                                value="{{ $item->qty }}" readonly min="1" max="{{ $item->stock }}" />
                                            <button wire:click="increment({{ $item->id }})"
                                                class="flex items-center justify-center w-8 h-8 text-gray-700 transition bg-gray-200 rounded-md shadow-sm hover:bg-gray-300">
                                                +
                                            </button>
                                        </div>

                                        <!-- Total Price -->
                                        <div class="text-end md:order-4 md:w-36">
                                            <p class="text-lg font-semibold text-gray-900">Rp.
                                                {{ number_format($item->total_price, 2) }}
                                            </p>
                                        </div>
                                    </div>


                                    <div class="flex-1 space-y-2 md:order-2 md:max-w-md">
                                        <p class="text-base font-medium text-gray-900">
                                            {{ $item->product->name }} | Stok tersedia : {{ $item->product->stock }}
                                        </p>
                                        <p class="text-base font-medium text-gray-900">Rp.
                                            {{ number_format($item->product->price, 2) }}
                                        </p>
                                        <button wire:click="removeItem({{ $item->id }})"
                                            class="text-sm font-medium text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1 max-w-4xl mx-auto mt-6 space-y-6 lg:mt-0 lg:w-full">
                    <div
                        class="p-4 space-y-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6">
                        <p class="text-xl font-semibold text-gray-900">Order summary</p>

                        <div class="space-y-4">
                            <dl class="flex justify-between">
                                <dt class="text-base text-gray-500">Total harga produk</dt>
                                <dd class="text-base font-medium">Rp. {{ number_format($subtotal, 2) }}</dd>
                            </dl>

                            <dl class="flex justify-between">
                                <dt class="text-base text-gray-500">Diskon</dt>
                                <dd class="text-base font-medium text-green-600">- Rp. {{ number_format($discount, 2) }}
                                </dd>
                            </dl>

                            <dl class="flex justify-between pt-2 border-t">
                                <dt class="text-base font-bold">Total</dt>
                                <dd class="text-base font-bold">Rp. {{ number_format($total, 2) }}</dd>
                            </dl>
                        </div>

                        <button wire:click="checkout"
                            class="w-full px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                            Proses Pembayaran
                        </button>

                        <a href="/" class="text-sm font-medium text-primary-700 hover:underline">Lanjutkan belanja</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>