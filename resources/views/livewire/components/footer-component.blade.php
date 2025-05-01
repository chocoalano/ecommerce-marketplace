<footer class="py-8 bg-gray-100 border-t">
    <div class="container grid grid-cols-1 gap-8 px-6 mx-auto lg:px-20 md:grid-cols-2 lg:grid-cols-4">
        <!-- Kolom 1: Informasi {{ env('APP_NAME') }} -->
        <div>
            <h2 class="mb-3 font-semibold text-gray-800">{{ env('APP_NAME') }}</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('page',['pagename'=>'tentang-aplikasi']) }}" class="hover:text-green-600">Tentang {{ env('APP_NAME') }}</a></li>
                <li><a href="{{ route('page',['pagename'=>'hak-kekayaan-intelektual']) }}" class="hover:text-green-600">Hak Kekayaan Intelektual</a></li>
            </ul>
        </div>

        <!-- Kolom 2: Beli & Jual -->
        <div>
            <h2 class="mb-3 font-semibold text-gray-800">Beli</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('page',['pagename'=>'topup']) }}" class="hover:text-green-600">Top Up</a></li>
                <li><a href="{{ route('page',['pagename'=>'bebas-ongkir']) }}" class="hover:text-green-600">Bebas Ongkir</a></li>
            </ul>
            <h2 class="mt-4 mb-3 font-semibold text-gray-800">Jual</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><a href="{{ route('page',['pagename'=>'edukasi-seller']) }}" class="hover:text-green-600">Pusat Edukasi Seller</a></li>
            </ul>
        </div>

        <!-- Kolom 3: Keamanan & Sosial Media -->
        <div>
            <h2 class="mb-3 font-semibold text-gray-800">Keamanan & Privasi</h2>
            <img src="{{ asset('img_apps/iso-data.png') }}" alt="Keamanan" class="mb-3 rounded-lg">
            <h2 class="mb-3 font-semibold text-gray-800">Ikuti Kami</h2>
            <div class="flex space-x-3">
                <a href="#" class="text-gray-600 hover:text-green-600">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-green-600">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-green-600">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.037 21.998a10.313 10.313 0 0 1-7.168-3.049 9.888 9.888 0 0 1-2.868-7.118 9.947 9.947 0 0 1 3.064-6.949A10.37 10.37 0 0 1 12.212 2h.176a9.935 9.935 0 0 1 6.614 2.564L16.457 6.88a6.187 6.187 0 0 0-4.131-1.566 6.9 6.9 0 0 0-4.794 1.913 6.618 6.618 0 0 0-2.045 4.657 6.608 6.608 0 0 0 1.882 4.723 6.891 6.891 0 0 0 4.725 2.07h.143c1.41.072 2.8-.354 3.917-1.2a5.77 5.77 0 0 0 2.172-3.41l.043-.117H12.22v-3.41h9.678c.075.617.109 1.238.1 1.859-.099 5.741-4.017 9.6-9.746 9.6l-.215-.002Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Kolom 4: Download Aplikasi -->
        <div>
            <h2 class="mb-3 font-semibold text-gray-800">Nikmati Keuntungan di Aplikasi</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li>✅ Diskon 70% hanya di aplikasi</li>
                <li>✅ Promo khusus aplikasi</li>
                <li>✅ Gratis ongkir tiap hari</li>
            </ul>
            <div class="flex mt-4 space-x-2">
                <a href="#"
                    class="flex items-center px-4 py-2 space-x-2 text-gray-800 transition border border-gray-500 rounded-lg hover:bg-gray-100">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                        alt="Google Play" class="h-10">
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2 space-x-2 text-gray-800 transition border border-gray-500 rounded-lg hover:bg-gray-100">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/67/App_Store_%28iOS%29.svg"
                        alt="App Store" class="h-10">
                </a>
            </div>

        </div>
    </div>
    <div class="pt-4 mt-8 text-sm text-center text-gray-500 border-t">
        © {{ date('Y') }}, {{ env('APP_NAME') }}. All Rights Reserved.
    </div>
</footer>