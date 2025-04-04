<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kandang') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- alert --}}
            @include('livewire.layout.alert')
            {{-- button --}}
            <a  href="{{ route('kandang.create') }}" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                </svg>
                Buat Kandang
            </a>
            {{-- tabel --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nama Kandang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Karyawan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Ayam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Umur Ayam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($kandang)
                            <tr class="odd:bg-white  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{ $kandang->nama_kandang}}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $kandang->nama_karyawan }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $kandang->jumlah_ayam }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $kandang->umur_ayam }} Minggu
                                </td>
                                <td class="px-6 inline-flex gap-3 py-4">
                                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                                </td>
                            </tr>
                        @else
                            <p class="text-red-500">Kandang belum tersedia. Silakan tambahkan kandang.</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
