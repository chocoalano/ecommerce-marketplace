<div>
    <div class="max-w-6xl px-4 py-10 mx-auto mt-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            <!-- Sidebar -->
            <aside class="p-4 bg-white rounded-lg shadow-md md:sticky md:top-20">
                <div class="flex items-center space-x-3">
                    <img src="https://res.cloudinary.com/dqta7pszj/image/upload/v1740027122/wu3i0jn44r1gfoz1bs6a.jpg"
                        class="w-16 h-16 rounded-full" alt="Avatar">
                    <div>
                        <p class="text-lg font-semibold">IT</p>
                        <button
                            class="px-3 py-1 text-sm text-white transition bg-green-500 rounded-lg hover:bg-green-600">Edit
                            No. HP</button>
                    </div>
                </div>
                <ul class="mt-6 space-y-3 text-gray-700">
                    <li class="flex justify-between">{{ config('app.name') }} Pay <span
                            class="text-green-500 cursor-pointer hover:underline">Aktifkan</span></li>
                    <li class="flex justify-between font-semibold">Saldo <span>Rp{{ number_format(Auth::user()->ewallet_balance, 2,',') }}</span></li>
                </ul>
            </aside>

            <!-- Main Content -->
            <section class="p-6 bg-white rounded-lg shadow-md md:col-span-3">
                <h2 class="pb-2 text-xl font-semibold border-b">Biodata Diri</h2>
                <div class="flex flex-col gap-6 mt-4 md:flex-row">
                    <!-- Foto Profil -->
                    <div class="flex flex-col items-center">
                        <img src="https://res.cloudinary.com/dqta7pszj/image/upload/v1740027122/wu3i0jn44r1gfoz1bs6a.jpg"
                            class="w-32 h-32 rounded-lg" alt="Profile">
                        <button class="px-4 py-2 mt-3 text-sm transition bg-gray-200 rounded-lg hover:bg-gray-300">Pilih
                            Foto</button>
                    </div>

                    <!-- Informasi Profil -->
                    <div class="flex-1 space-y-3">
                        <p class="text-gray-700">Nama: <span class="font-semibold">{{ Auth::user()->name }}</span> <a
                                href="#" class="text-green-500 hover:underline">Ubah</a></p>
                        <p class="text-gray-700">Email: <span class="font-semibold">{{ Auth::user()->email }}</span>
                            <span class="text-green-500">Terverifikasi</span> <a href="#"
                                class="text-green-500 hover:underline">Ubah</a>
                        </p>
                        <p class="text-gray-700">Nomor HP: {{ Auth::user()->phone_number }}</p>
                        <p class="text-gray-700">Alamat lengkap: {{ Auth::user()->full_address }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3 mt-6 sm:grid-cols-2">
                    <button class="w-full px-4 py-2 transition bg-gray-200 rounded-lg hover:bg-gray-300">Buat Kata
                        Sandi</button>
                    <button class="w-full px-4 py-2 transition bg-gray-200 rounded-lg hover:bg-gray-300">Verifikasi
                        Instan</button>
                </div>
            </section>
        </div>
    </div>

    <!-- Order History Section -->
    <div class="min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl">
            <h1 class="mb-8 text-3xl font-bold text-gray-900">Order History</h1>

            <!-- Search and Filter -->
            <div class="flex flex-col gap-4 mb-6 sm:flex-row">
                <input type="text" placeholder="Search orders..."
                    class="flex-1 py-2 pl-4 pr-4 transition-all border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-green-500"
                    wire:model="searchQuery" />

                <select
                    class="px-4 py-2 transition-all border border-gray-300 rounded-lg cursor-pointer focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-green-500"
                    wire:model="selectedStatus">
                    <option value="all">Semua</option>
                    <option value="pending">Pending</option>
                    <option value="processed">Processed</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>


            <!-- Order List -->
            <div class="space-y-4">
                {{-- {{ dd($orders) }} --}}
                @foreach ($orders as $order)
                    <div class="p-6 transition bg-white rounded-lg shadow-md hover:shadow-lg">
                        <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $order->product_primary_image) }}"
                                    alt="{{ $order->product_name }}" class="object-cover w-20 h-20 rounded-lg"
                                    loading="lazy" />
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $order->order_id }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->product_name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                                <span class="text-lg font-semibold text-gray-900">Rp.
                                    {{ number_format($order->total_order_price, 2) }}</span>
                                <span
                                    class="px-3 py-1 text-sm font-medium rounded-full {{ $order->order_status === 'pending' ? 'bg-yellow-200 text-yellow-800' : ($order->order_status === 'processed' ? 'bg-green-200 text-green-800' : ($order->order_status === 'shipped' ? 'bg-green-200 text-green-800' : 'bg-green-800 text-white')) }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2 mt-4">
                            @if ($order->order_status === 'pending')
                                <button
                                    class="px-4 py-2 text-sm font-medium text-red-500 transition border border-red-500 rounded-lg hover:bg-red-500 hover:text-white">
                                    Batalkan
                                </button>
                            @endif
                            <button
                                class="px-4 py-2 text-sm font-medium text-green-500 transition border border-green-500 rounded-lg hover:bg-green-500 hover:text-white">
                                Reorder
                            </button>
                            <a href="{{ route('auth.treking', ['id' => $order->order_item_id]) }}"
                                class="px-4 py-2 text-sm font-medium text-green-500 transition border border-green-500 rounded-lg hover:bg-green-500 hover:text-white">
                                 Treking
                             </a>                             
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>