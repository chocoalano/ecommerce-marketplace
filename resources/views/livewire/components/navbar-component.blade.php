<nav class="fixed top-0 left-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <header class="hidden w-full text-sm text-gray-600 bg-gray-100 md:block">
        <div class="flex items-center justify-between max-w-screen-xl px-4 py-2 mx-auto">
            <div>
                <a href="#" class="text-blue-600 hover:underline">Download {{ env('APP_NAME') }} App</a>
            </div>
            <div class="space-x-4 md:flex">
                <a href="{{ route('page',['pagename'=>'tentang-aplikasi']) }}" class="hover:text-green-600">Tentang {{ env('APP_NAME') }}</a>
                <a href="{{ route('page',['pagename'=>'mitra']) }}" class="hover:text-green-600">Mitra {{ env('APP_NAME') }}</a>
                <a href="{{ route('page',['pagename'=>'edukasi-seller']) }}" class="hover:text-green-600">Pusat Edukasi Seller</a>
                <a href="{{ route('page',['pagename'=>'promo']) }}" class="hover:text-green-600">Promo</a>
                <a href="{{ route('page',['pagename'=>'care']) }}" class="hover:text-green-600">{{ env('APP_NAME') }} Care</a>
            </div>
        </div>
    </header>
    <div class="flex items-center justify-between max-w-screen-xl p-4 mx-auto">
        <!-- Logo -->
        <a href="/" class="hidden text-2xl font-bold text-green-600 md:block">{{ env('APP_NAME') }}</a>

        <!-- Search Bar -->
        <div class="relative flex-1 mx-4">
            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search icon</span>
            </div>
            <input type="text" id="search-navbar"
                class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-green-500 focus:border-green-500"
                placeholder="Search...">
        </div>

        <!-- Icons & User -->

        <div class="flex items-center space-x-4">
            <a href="{{ route('cart') }}" class="relative">
                <svg class="w-6 h-6 text-gray-800" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#2ec27e">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>shopping_cart [#1135]</title>
                        <desc>Created with Sketch.</desc>
                        <defs> </defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Dribbble-Light-Preview" transform="translate(-220.000000, -3119.000000)"
                                fill="#2ec27e">
                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                    <path
                                        d="M180.846448,2977 L167.153448,2977 C166.544448,2977 166.077448,2976.461 166.163448,2975.859 L167.306448,2967.859 C167.376448,2967.366 167.798448,2967 168.296448,2967 L168.999448,2967 L168.999448,2969 C168.999448,2969.552 169.447448,2970 169.999448,2970 C170.552448,2970 170.999448,2969.552 170.999448,2969 L170.999448,2967 L176.999448,2967 L176.999448,2969 C176.999448,2969.552 177.447448,2970 177.999448,2970 C178.552448,2970 178.999448,2969.552 178.999448,2969 L178.999448,2967 L179.703448,2967 C180.201448,2967 180.623448,2967.366 180.693448,2967.859 L181.836448,2975.859 C181.922448,2976.461 181.455448,2977 180.846448,2977 L180.846448,2977 Z M170.999448,2964 C170.999448,2962.346 172.345448,2961 173.999448,2961 C175.654448,2961 176.999448,2962 176.999448,2964 L176.999448,2965 L170.999448,2965 L170.999448,2964 Z M183.979448,2976.717 L182.550448,2966.717 C182.410448,2965.732 181.566448,2965 180.570448,2965 L178.999448,2965 L178.999448,2964 C178.999448,2961 176.756448,2959 173.999448,2959 C171.243448,2959 168.999448,2961.243 168.999448,2964 L168.999448,2965 L167.734448,2965 C166.739448,2965 165.589448,2965.732 165.448448,2966.717 L164.020448,2976.717 C163.848448,2977.922 164.783448,2979 166.000448,2979 L181.999448,2979 C183.216448,2979 184.151448,2977.922 183.979448,2976.717 L183.979448,2976.717 Z"
                                        id="shopping_cart-[#1135]"> </path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                @if (Auth::check())
                                @php
                                    $cartcount = \App\Models\Cart::where([
                                        'buyer_id' => Auth::user()->id,
                                        'ispay' => 0,
                                    ])->count();
                                @endphp
                                @if ($cartcount > 0)
                                    <span
                                        class="absolute px-1 text-xs text-white bg-red-600 rounded-full -top-1 -right-2">{{ $cartcount }}</span>
                                @endif
                @endif
            </a>
            @if (Auth::check())
                <div class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="{{ asset('img_apps/avatar.png') }}" alt="user photo">
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="{{ route('auth.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</a>
                            </li>
                        </ul>
                    </div>
                </div>
                @if (Auth::user()->seller)
                <a href="{{ route('filament.seller.auth.profile') }}" class="relative">
                    {{ Str::limit(Auth::user()->seller->name, '10', '...') }}
                </a>
                @endif
            @endif
        </div>
    </div>
</nav>