<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ayam') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('livewire.layout.alert')
            <div class="flex gap-x-3 mb-6 fade-up">
                {{-- card total chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg aria-hidden="true"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="font-bold">Total Ayam</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($this->countChickens['liveChickens'] ,0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Hidup</span>
                </section>
                {{-- card total dead chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-skull size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4c4.418 0 8 3.358 8 7.5c0 1.901 -.755 3.637 -2 4.96l0 2.54a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-2.54c-1.245 -1.322 -2 -3.058 -2 -4.96c0 -4.142 3.582 -7.5 8 -7.5z" /><path d="M10 17v3" /><path d="M14 17v3" /><path d="M9 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        <span class="font-bold">Total Mati</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($this->countChickens['totalAllDead'], 0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
                    </div>
                    <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Saat Ini</span>
                </section>
                {{-- card total dead chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-skull size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4c4.418 0 8 3.358 8 7.5c0 1.901 -.755 3.637 -2 4.96l0 2.54a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-2.54c-1.245 -1.322 -2 -3.058 -2 -4.96c0 -4.142 3.582 -7.5 8 -7.5z" /><path d="M10 17v3" /><path d="M14 17v3" /><path d="M9 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        <span class="font-bold">Total Mati</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ number_format($this->countChickens['deadChickensMontly'], 0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
                    </div>
                    <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Bulan Ini</span>
                </section>
            </div>
            {{-- fitur filter --}}
            <section class="inline-flex items-center justify-between gap-x-3 fade-up">
                <form class="max-w-sm mx-auto flex gap-x-3 ">
                    <div>
                        <select id="bulan" aria-label="pilih bulan" wire:model.live="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2\3 me-2 py-2.5  ">
                            @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <select id="tahun" aria-label="pilih tahun" wire:model.live="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  me-2 py-2.5 ">
                            @for ($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </form>
            </section>
            {{-- table --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 mb-4 fade-up">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Karyawan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Kandang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Ayam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ayam Mati
                            </th>
                                <th scope="col" class="px-6 py-3">
                                Jumlah Pakan
                            </th>
                                <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->chickensFarmers as $item)
                            <tr class="odd:bg-white  border-b  border-gray-200">
                                <td wire:key="{{$item->id}}" class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>
                                <td scope="row" class="px-6 py-4 ">
                                    {{ $item->nama_karyawan }} 
                                </td>
                                <td scope="row" class="px-6 py-4 ">
                                    {{ $item->nama_kandang }} 
                                </td>
                                <td scope="row" class="px-6 py-4 ">
                                    {{ number_format($item->total_ayam_terbaru , 0, ',', '.') }} Ekor
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($item->jumlah_ayam_mati , 0, ',', '.') }} Ekor
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($item->jumlah_pakan , 0, ',', '.') }} Kg
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>
                                <td class="px-6 inline-flex gap-3 py-4">
                                    {{-- btn view --}}
                                    <a href="{{route('chicken.admin.view', $item->nama_karyawan)}}" aria-label="btn view karyawan" title="Lihat karyawan" class="font-medium text-gray-500 flex items-center">
                                        <svg class="size-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-4 text-sm font-normal">Data tidak ada!</tt>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- pagination --}}
            <div >{{ $this->chickensFarmers->links() }}</div>
        </div>
    </div>
</div>
