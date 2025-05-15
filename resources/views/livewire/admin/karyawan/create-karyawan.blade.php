<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Karyawan') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form class="max-w-sm" wire:submit.prevent="store">
                <div class="mb-5">
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Nama Lengkap <span class="text-bold text-red-500">*</span></label>
                    <input type="text" wire:model="nama" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5     " required />
                </div>
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email <span class="text-bold text-red-500">*</span></label>
                    <input type="email" wire:model="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" placeholder="@name" required />
                </div>
                <button type="submit" aria-label="btn submit" class="text-white bg-yellow-500 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">Simpan</button>
                <div wire:loading class="translate-x-5">
                    <span class="italic animate-pulse">Mencoba menyimpan ...</span>
                </div>
            </form>
        </div>
    </div>
</div>