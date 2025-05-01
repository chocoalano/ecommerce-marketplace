<div
    class="w-full max-w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 md:p-8">
    <form class="space-y-6" wire:submit.prevent="login">
        <h5 class="text-xl font-medium text-gray-900">Masuk untuk memulai belanja</h5>

        <!-- Email Input -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email kamu</label>
            <input type="email" wire:model="email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                placeholder="name@company.com" required />
            @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Password Input -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password
                kamu</label>
            <input type="password" wire:model="password" id="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                required />
            @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-start">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" wire:model="remember"
                        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-300" />
                </div>
                <label for="remember" class="text-sm font-medium text-green-900 ms-2">Ingat
                    saya.</label>
            </div>
            <a href="#" class="text-sm text-green-500 ms-auto hover:underline">Lupa password</a>
        </div>

        <!-- Login Button -->
        @livewire('components.forms.block-button', [
            'text' => 'Masuk untuk memulai belanja',
            'type' => 'submit',
            'color' => 'green'
        ])
    </form>
</div>