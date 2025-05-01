<div>
    {{-- {{ dd($orderItem) }} --}}
    <section class="py-8 antialiased bg-white md:py-16">
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Track the delivery of order
                #957684673</h2>

            <div class="mt-6 sm:mt-8 lg:flex lg:gap-8">
                <div
                    class="w-full overflow-hidden border border-gray-200 divide-y divide-gray-200 rounded-lg lg:max-w-xl xl:max-w-2xl">
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-6">
                            <a href="#" class="h-14 w-14 shrink-0">
                                <img class="w-full h-full"
                                    src="{{ asset('storage/' . $orderItem->products->primary_image) }}"
                                    alt="{{ $orderItem->products->name }}" />
                            </a>
                            <a href="#" class="flex-1 min-w-0 font-medium text-gray-900 hover:underline">
                                {{ Str::upper(Str::limit($orderItem->products->name, 20, '...')) }}</a>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm font-normal text-gray-500"><span class="font-medium text-gray-900">Produk
                                    ID:</span> SKU{{$orderItem->products->id}}</p>
                            <div class="flex items-center justify-end gap-4">
                                <p class="text-base font-normal text-gray-900">x{{ $orderItem->qty }}</p>
                                <p class="text-xl font-bold leading-tight text-gray-900">Rp.
                                    {{ number_format($orderItem->products->price, 2, ',') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 bg-gray-50">
                        <div class="space-y-2">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="font-normal text-gray-500">Total harga produk</dt>
                                <dd class="font-medium text-gray-900">Rp.
                                    {{ number_format(($orderItem->item_price * $orderItem->qty), 2, ',') }}
                                </dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="font-normal text-gray-500">Biaya Ongkir</dt>
                                <dd class="font-medium text-gray-900">Rp.
                                    {{ number_format($orderItem->cost_ro_shipping, 2, ',') }}
                                </dd>
                            </dl>
                        </div>

                        <dl class="flex items-center justify-between gap-4 pt-2 border-t border-gray-200">
                            <dt class="text-lg font-bold text-gray-900">Total</dt>
                            <dd class="text-lg font-bold text-gray-900">Rp.
                                {{ number_format(($orderItem->cost_ro_shipping + $orderItem->total_price), 2, ',') }}
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                    <div class="p-6 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-gray-900">Order history</h3>

                        <ol class="relative border-gray-200 ms-3 border-s">
                            {{-- {{ dd($orderItem->shipping->id) }} --}}
                            @php
                                $shippingRoad = \App\Models\ShippingRoad::where('shipping_id', $orderItem->shipping->id)->get();
                            @endphp
                            @foreach ($shippingRoad as $k)
                                <li class="mb-10 ms-6 text-primary-700">
                                    <span
                                        class="absolute flex items-center justify-center w-6 h-6 rounded-full -start-3 bg-primary-100 ring-8 ring-white">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                        </svg>
                                    </span>
                                    <h4 class="mb-0.5 font-semibold">
                                        {{ \Carbon\Carbon::parse($k->created_at)->format('d F Y H:m') }}
                                    </h4>
                                    <p class="text-sm">{{ $k->information }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>