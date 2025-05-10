<div>
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
            @php
                $userKandang = auth()->user()->kandang; // relasi kandang pada user
            @endphp

            @if(!$userKandang)
                <a  href="{{ route('kandang.create') }}" aria-label="buat kandang" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-4">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                    </svg>
                    Buat Kandang
                </a>
            @endif
            <div class="flex gap-x-3 fade-up">
                {{-- card total chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg aria-hidden="true"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="font-bold">Total Ayam</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($totalChicken, 0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Hidup</span>
                </section>
                {{-- card total dead chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg class="size-10 bg-gray-200 p-2 rounded-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.0001 13c0-.8883.4022-2.3826 1-3.27163M18.05 14c0 3.3137-2.6862 6-6 6-3.31366 0-5.99995-2.6863-5.99995-6S8.73634 4 12.05 4c3.3138 0 6 6.6863 6 10Z"/>
                        </svg>
                        <span class="font-bold">Produksi Telur</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($eggs, 0, ',', '.') }} <span class="text-sm text-gray-500">Butir</span></span>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 w-max text-xs font-medium me-2 px-2.5 py-0.5 rounded-full border border-yellow-300">Bulan Ini</span>
                </section>
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-skull size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4c4.418 0 8 3.358 8 7.5c0 1.901 -.755 3.637 -2 4.96l0 2.54a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-2.54c-1.245 -1.322 -2 -3.058 -2 -4.96c0 -4.142 3.582 -7.5 8 -7.5z" /><path d="M10 17v3" /><path d="M14 17v3" /><path d="M9 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        <span class="font-bold">Usia Ayam</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($chickenAge, 0, ',', '.') }} <span class="text-sm text-gray-500">Minggu</span></span>
                    </div>
                    <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full border border-red-400">Saat Ini</span>
                </section>
                
            </div>
            {{-- tabel --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 fade-up">
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
                                    {{ number_format($kandang->jumlah_ayam, 0, ',', '.') }} Ekor
                                </td>
                                <td class="px-6 py-4">
                                    {{ $kandang->umur_ayam }} Minggu
                                </td>
                                <td class="px-6 inline-flex gap-3 py-4">
                                    <a href="{{route('kandang.edit', $kandang->id)}}" class="font-medium text-gray-500 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                      </svg>
                                    </a>
                                    {{-- btn delete --}}
                                    <button aria-label="Hapus Data" wire:click="destroy({{ $kandang->id }})" wire:confirm="Apakah kamu yakin menghapus data ini?" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="p-4 font-normal">Kandang belum tersedia. Silakan tambahkan kandang!!</tr>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
