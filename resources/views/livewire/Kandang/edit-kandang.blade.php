<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kandang') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="max-w-xl grid grid-cols-2 gap-5" wire:submit.prevent="editKandang">
                <div class="mb-5">
                    <label for="nama_kandang" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Kandang</label>
                    <input type="text" wire:model="nama_kandang" name="nama_kandang" id="nama_kandang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500  mb-2 block w-full p-2.5" required />
                    @error('nama_kandang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-5">
                    <label for="nama_karyawan" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Karyawan</label>
                    <input type="text" wire:model="nama_karyawan" name="nama_karyawan" id="nama_karyawan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" disabled  required />
                </div>
                <div class="mb-5">
                    <label for="jumlah_ayam" class="block mb-2 text-sm font-medium text-gray-900 ">Jumlah Ayam</label>
                    <input type="text" wire:model="jumlah_ayam" name="jumlah_ayam" id="jumlah_ayam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 mb-2  block w-full p-2.5" required />
                    @error('jumlah_ayam') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-5">
                    <label for="umur_ayam" class="block mb-2 text-sm font-medium text-gray-900 ">Umur Ayam (Minggu)</label>
                    <input type="text" wire:model="umur_ayam" name="umur_ayam" id="umur_ayam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-50 mb-2 0 block w-full p-2.5" required />
                    @error('umur_ayam') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Simpan</button>
            </form>
        </div>
    </div>
</div>
