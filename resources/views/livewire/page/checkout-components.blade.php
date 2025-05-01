<div class="max-w-5xl px-4 py-6 mx-auto mt-32 lg:py-10">
    <h2 class="mb-6 text-2xl font-semibold">Checkout</h2>

    {{-- Container Utama --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Kolom Kiri: Alamat & Detail Produk --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Alamat Pengiriman --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm">
                <h3 class="mb-3 text-lg font-semibold text-gray-800">ALAMAT PENGIRIMAN</h3>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="flex items-center font-medium text-gray-900">
                            <svg class="w-6 h-6 mr-1 text-lg text-green-600" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                            </svg>
                            Kirim ke lokasi - {{ Auth::user()->name }}
                        </p>
                        <p class="mt-3 text-sm text-gray-600">{{ Auth::user()->full_address }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->phone_number }}</p>
                        <form wire:submit.prevent="saveAddress" method="post">
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <!-- Pilih Provinsi -->
                                <div>
                                    <label for="province" class="block mb-2 text-sm font-medium text-gray-900">
                                        Pilih Provinsi
                                    </label>
                                    <select wire:model="authForm.province"
                                        wire:change="changeProvince($event.target.value, 0)" id="province"
                                        class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-primary-500 focus:border-primary-500">
                                        <option selected="" disabled>PIlih provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Pilih Kota -->
                                <div>
                                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900">
                                        Pilih Kota
                                    </label>
                                    <select wire:model="authForm.city" id="city"
                                        class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-primary-500 focus:border-primary-500">
                                        <option selected="" disabled>PIlih kota</option>
                                        @foreach($cities ?? [] as $city)
                                            <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Deskripsi (Mengambil Lebar 2 Kolom di Layar Lebar) -->
                                <div class="col-span-1 sm:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                                        Deskripsi
                                    </label>
                                    <textarea id="description" rows="4"
                                        class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Alamat lengkap"
                                        wire:model="authForm.address">{{ Auth::user()->full_address }}</textarea>
                                </div>
                            </div>
                            @if (session()->has('message'))
                                <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-400 rounded-lg">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <button type="submit"
                                class="w-full py-2 mt-4 text-white transition bg-green-600 rounded-md hover:bg-green-700">
                                Perbaharui alamat pengiriman
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            @foreach ($product as $k => $v)
                <div class="p-6 bg-white border rounded-lg shadow-sm">
                    <h3 class="mb-3 text-lg font-semibold text-gray-800">Nutrifiarm Official</h3>
                    <div class="flex gap-4">
                        <img src="{{ asset('storage/' . $v['product']['primary_image']) }}" alt="Produk"
                            class="w-20 h-20 rounded-md">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ strtoupper($v['product']['name']) }}</p>
                            <span class="px-2 py-1 text-xs font-semibold text-white bg-pink-500 rounded">
                                {{ $v['product']['seller']['store_name'] }}
                            </span>
                            <p class="text-sm text-gray-600">{{ $v['qty'] }} x Rp.
                                {{ number_format($v['product']['price'], 2) }}
                            </p>
                        </div>
                    </div>

                    {{-- Opsi Pengiriman --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        <div class="p-1">
                            <label class="block mb-2 font-semibold text-gray-800">Pilih expedisi</label>
                            <select class="w-full p-2 text-gray-700 border border-gray-300 rounded-md"
                                wire:change="ongkirCheck('{{ $v['product']['seller']['city'] }}', '{{ Auth::user()->raja_ongkir_city_id }}', '{{ $v['product']['weight'] }}', $event.target.value, {{ $k }})">
                                <option disabled selected>Pilih expedisi</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">Tiki</option>
                                <option value="pos">Pos</option>
                            </select>
                        </div>
                        <div class="p-1">
                            <label class="block mb-2 font-semibold text-gray-800">Pilih paket pengiriman</label>
                            <select class="w-full p-2 text-gray-700 border border-gray-300 rounded-md"
                                wire:change="setOngkir($event.target.value, {{ $k }})">
                                <option disabled selected>Pilih paket pengiriman</option>
                                @if (!empty($ongkir_paket[$k]))
                                    @foreach ($ongkir_paket[$k] as $ongkir)
                                        <option value="{{ $ongkir['service'] }}|{{ $ongkir['cost'][0]['value'] }}">
                                            {{ $ongkir['description'] }} | Rp.
                                            {{ number_format($ongkir['cost'][0]['value']) }} | ETD: {{$ongkir['cost'][0]['etd']}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="p-1">
                            <label class="block mb-2 font-semibold text-gray-800">Biaya</label>
                            <input type="text" name="cost" id="cost"
                                value="{{ number_format($cartForm[$k]['cost_ro_shipping'] ?? 0, 0, '.', ',') }}"
                                class="w-full p-2 text-gray-700 border border-gray-300 rounded-md" readonly />
                        </div>
                    </div>

                    {{-- Tambah Catatan --}}
                    <div class="mt-4">
                        <label for="list_ro_shipping_option_{{ $k }}"
                            class="block mb-1 text-sm font-semibold text-gray-800">
                            Kasih Catatan
                        </label>
                        <textarea id="list_ro_shipping_option_{{ $k }}"
                            class="w-full p-2 text-sm text-gray-700 border border-gray-300 rounded-md focus:ring focus:ring-green-200"
                            placeholder="Tambahkan catatan (opsional)" rows="2"
                            wire:model.defer="cartForm.{{ $k }}.list_ro_shipping_option">
                                                                                </textarea>
                    </div>

                </div>
            @endforeach

        </div>

        {{-- Kolom Kanan: Pembayaran & Total --}}
        <div class="space-y-6">

            {{-- Metode Pembayaran --}}
            <div class="p-6 bg-white border rounded-lg shadow-sm">
                <h3 class="mb-3 text-lg font-semibold text-gray-800">Metode Pembayaran</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payment" disabled
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" value="midtrans">
                        <span>Midtrans</span>
                    </label>
                </div>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="payment" checked
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" value="transfer_bank">
                        <span>Tansfer Bank</span>
                    </label>
                </div>
            </div>

            {{-- Ringkasan Pembayaran --}}
            <div class="p-6 bg-gray-100 border rounded-lg shadow-sm">
                <h3 class="mb-3 text-lg font-semibold text-gray-800">Cek ringkasan transaksimu, yuk</h3>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between"><span>Total Harga ({{ count($product) }} Barang)</span> <span>Rp.
                            {{ number_format(array_sum(array_column($product, 'total_price')), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between"><span>Total Ongkos Kirim</span> <span>Rp.
                            {{ number_format(array_sum(array_column($cartForm, 'cost_ro_shipping')), 0, '.', ',') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold"><span>Total Tagihan</span> <span>Rp.
                            {{ number_format((array_sum(array_column($product, 'total_price')) + array_sum(array_column($cartForm, 'cost_ro_shipping')))) }}</span>
                    </div>
                </div>
                <button class="w-full py-2 mt-4 text-white transition bg-green-600 rounded-md hover:bg-green-700"
                    wire:click="submitCheckout">
                    Bayar Sekarang
                </button>
                <p class="mt-2 text-xs text-center text-gray-600">
                    Dengan melanjutkan pembayaran, kamu menyetujui <a href="#"
                        class="text-green-600 hover:underline">S&K
                        Asuransi Pengiriman & Proteksi</a>.
                </p>
            </div>

        </div>
    </div>
    {{-- dialog upload bukti pembayaran::started --}}
    @if ($isOpen)
        <div id="static-modal"
            class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
            <form wire:submit.prevent="submitKonfirmasiPembayaran" class="w-full max-w-md bg-white rounded-lg shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold">Konfirmasi pembayaran</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-red-600">
                        &times;
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <div class="max-w-lg mx-auto">
                        <div class="flex items-center justify-center w-full">
                            <label for="buktiPembayaran"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                @if ($paymentConfirmationForm['image'])
                                    <img src="{{$paymentConfirmationForm['image']->temporaryUrl() }}"
                                        class="object-cover w-full h-64 rounded-lg">
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk
                                                mengunggah</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG atau JPG (Max: 2MB)</p>
                                    </div>
                                @endif
                                <input id="buktiPembayaran" type="file" wire:model="paymentConfirmationForm.image"
                                    class="hidden" />
                            </label>
                        </div>
                    </div>

                    @error('paymentConfirmationForm.image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if (session()->has('message-checkout-konfirmation'))
                        <div class="p-4 mt-5 mb-4 text-green-800 bg-green-100 border border-green-400 rounded-lg">
                            {{ session('message-checkout-konfirmation') }}
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="flex justify-end p-4 border-t">
                    <button type="submit"
                        class="px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700 disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Konfirmasi sekarang</span>
                        <span wire:loading class="animate-pulse">Mengunggah...</span>
                    </button>
                    <button wire:click="hide" class="px-4 py-2 ml-2 transition bg-gray-300 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif
    {{-- dialog upload bukti pembayaran::ended --}}
</div>