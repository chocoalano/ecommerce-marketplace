<div class="flex flex-col items-center"> <!-- Menggunakan flex-col untuk mengatur elemen secara vertikal -->
    <div class="grid grid-cols-2 gap-4 mt-5 mb-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        @foreach ($products as $product)
            <a href="{{ route('produk.detail', ['slug' => $product['slug']]) }}"
                class="block overflow-hidden transition-all duration-300 transform bg-white rounded-lg shadow hover:shadow-lg hover:scale-105">

                <!-- Gambar Produk -->
                <img src="{{ asset('storage/' . $product['primary_image']) }}" alt="{{ $product['name'] }}"
                    class="object-cover w-full h-50">

                <div class="p-4">
                    <!-- Nama Toko (Jika Ada) -->
                    @if (!empty($product['seller']['store_name']))
                        <span class="px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">
                            {{ Str::limit($product['seller']['store_name'], 15) }}
                        </span>
                    @endif

                    <!-- Nama Produk -->
                    <h3 class="mt-2 text-sm font-semibold">{{ $product['name'] }}</h3>

                    <!-- Harga Produk -->
                    <div class="text-lg font-bold text-gray-900">
                        Rp{{ number_format($product['price'], 2, ',', '.') }}
                    </div>

                    <!-- Harga Coret & Diskon (Jika Ada) -->
                    @if (!empty($product['discount']) || $product['discount'] !== null && $product['discount'] > 0)
                        <div class="text-xs text-gray-500 line-through">
                            Rp{{ number_format($product['original_price'], 0, ',', '.') }}
                        </div>
                        <span class="text-xs font-semibold text-red-500">
                            -{{ $product['discount'] }}%
                        </span>
                    @endif

                    <!-- Rating Produk -->
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <span>⭐ {{ number_format($product['rating'] ?? 0, 1) }}</span>
                    </div>

                    <!-- Lokasi -->
                    <div class="mt-1 text-xs text-gray-500">{{ $product->seller->province ?? 'Tidak Diketahui' }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Tombol Load More dengan Livewire -->
    @if ($hasMorePages)
        <div class="mt-10 mb-10">
            <button wire:click="loadMore"
                class="px-4 py-2 mt-5 text-green-600 border border-green-600 rounded hover:bg-green-600 hover:text-white focus:outline-none focus:ring focus:ring-green-300">
                Produk selanjutnya
            </button>
        </div>
    @endif
</div>