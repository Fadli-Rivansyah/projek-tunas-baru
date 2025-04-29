<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Data Ayam') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="max-w-xl" wire:submit.prevent="save">
                <div class=" grid grid-cols-2 gap-x-5">
                    <div class="mb-5">
                        <label for="total_ayam" class="block mb-2 text-sm font-medium text-gray-900 ">Total Ayam <span class="text-bold text-red-500">*</span></label>
                        <input type="text" wire:model="total_ayam" name="total_ayam" id="total_ayam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required />
                        @error('total_ayam') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-5">
                        <label for="jumlahAyam_mati" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Ayam Mati <span class="text-bold text-red-500">*</span></label>
                        <input type="text" wire:model="jumlahAyam_mati" name="jumlahAyam_mati" id="jumlahAyam_mati" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required />
                        @error('jumlahAyam_mati') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-5">
                        <label for="pakan" class="block mb-2 text-sm font-medium text-gray-900 ">Pakan(kg) <span class="text-bold text-red-500">*</span></label>
                        <input type="text" wire:model="pakan" name="pakan" id="pakan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-50 mb-2 0 block w-full p-2.5" required />
                        @error('pakan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-5">
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 ">tanggal <span class="text-bold text-red-500">*</span></label>
                        <input type="date" wire:model="tanggal" name="tanggal" id="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-50 mb-2 0 block w-full p-2.5" required />
                        @error('tanggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" aria-label="btn submit" class="text-white bg-yellow-500 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Simpan</button>
            </form>
        </div>
    </div>
</div>
