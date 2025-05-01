<div class="w-full p-6 mx-auto bg-white shadow rounded-xl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Kategori Pilihan</h2>
        <h2 class="text-lg font-semibold text-green-600 cursor-pointer">
            Top Up Ewallet
        </h2>
    </div>

    <form wire:submit.prevent="submit">
        <div class="p-4 rounded-lg shadow bg-gray-50">
            <div class="mt-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <!-- Input Nominal -->
                    <div>
                        <label class="text-sm text-gray-700">Masukan nominal topup</label>
                        <input type="number" wire:model.lazy="paymentConfirmationForm.amount_paid"
                            class="w-full p-2 text-sm border border-gray-300 rounded-lg" placeholder="1.000.000">
                        @error('paymentConfirmationForm.amount_paid')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select Metode Pembayaran -->
                    <div>
                        <label class="text-sm text-gray-700">Mitra pembayaran</label>
                        <select class="w-full p-2 text-sm border border-gray-300 rounded-lg"
                            wire:model.lazy="paymentConfirmationForm.payment_method">
                            <option selected>Pilih</option>
                            <option value="midtrans" disabled>Midtrans</option>
                            <option value="transfer_bank">Transfer Bank</option>
                        </select>
                        @error('paymentConfirmationForm.payment_method')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full py-2 mt-3 font-semibold text-gray-500 bg-gray-200 rounded-lg hover:bg-green-500 hover:text-white disabled:opacity-50" wire:loading.attr="disabled"
                    wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Topup Sekarang</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </div>
    </form>

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

    <!-- Kategori Tags -->
    <div class="flex flex-wrap gap-2 mt-4">
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">📂</span> Kategori
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">📱</span> Handphone & Tablet
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">💳</span> Top-Up Ewallet
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">🎧</span> Elektronik
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">🐶</span> Perawatan Hewan
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">👚</span> Busana Pria, Wanita & Anak-anak
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">🏠</span> Perlengkapan Rumah
        </button>
        <button class="flex items-center px-3 py-2 text-sm font-medium bg-gray-100 rounded-lg">
            <span class="mr-2">🎸</span> Perlengkapan Musik
        </button>
    </div>
</div>