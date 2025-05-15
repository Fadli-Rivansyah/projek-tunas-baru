<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pakan') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="max-w-xl" wire:submit.prevent="editPakan">
                <div class=" grid grid-cols-2 gap-x-5">
                    <div class="mb-5">
                        <label for="jagung" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Jagung (Kg) <span class="text-bold text-red-500">*</span></label>
                        <input type="text" wire:model="jagung" name="jagung" id="jagung" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required />
                        @error('jagung') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-5">
                        <label for="multivitamin" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Multivitamin (Kg) <span class="text-bold text-red-500">*</span></label>
                        <input type="text" wire:model="multivitamin" name="multivitamin" id="multivitamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-50 mb-2 0 block w-full p-2.5" required />
                        @error('multivitamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-5">
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 ">Tanggal <span class="text-bold text-red-500">*</span></label>
                        <input type="date" wire:model="tanggal" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-50 mb-2 0 block w-full p-2.5" required />
                        @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Simpan</button>
                <div wire:loading  class="translate-x-5">
                    <span class="italic animate-pulse">Mencoba menyimpan ...</span>
                </div>
            </form>
        </div>
    </div>
</div>
