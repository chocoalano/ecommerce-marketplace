<div class="w-full max-w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-2 md:p-2">
    <form class="grid grid-cols-1 gap-6 space-y-6 md:grid-cols-2" wire:submit.prevent="submit">
        <h5 class="text-xl font-medium text-gray-900 dark:text-white md:col-span-2">Masuk untuk memulai belanja</h5>

        <!-- Name Input -->
        <div class="col-span-1">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
            <input type="text" wire:model="name" id="name" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" 
                placeholder="Nama Lengkap" required />
            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Email Input -->
        <div class="col-span-1">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email kamu</label>
            <input type="email" wire:model="email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                placeholder="name@company.com" required />
            @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Password Input -->
        <div class="col-span-1">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password kamu</label>
            <input type="password" wire:model="password" id="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                required />
            @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Phone Number -->
        <div class="col-span-1">
            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon</label>
            <input type="text" wire:model="phone_number" id="phone_number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                placeholder="Nomor telepon kamu" />
            @error('phone_number') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        @livewire('components.forms.block-button', [
            'text' => 'Daftar untuk memulai belanja',
            'type' => 'submit',
            'color' => 'green'
        ])
    </form>
</div>
