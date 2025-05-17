<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __( $name ) }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- card --}}
            <div class="w-full flex  gap-x-5 mb-8 fade-up">
                {{-- card nameChickencoop --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-4">
                        <svg class="size-10 bg-gray-200 p-2 rounded-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.14294 20v-9l-4 1.125V20h4Zm0 0V6.66667m0 13.33333h2.99996m5-9V6.66667m0 4.33333 4 1.125V13m-4-2v3m2-6-6-4-5.99996 4m4.99996 1h2m-2 3h2m1 6 2 2 4-4"/>
                        </svg>
                        <span class="font-bold">Nama Kandang</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5">
                        <span class="text-2xl font-extrabold">{{ $nameChickenCoop }}</span>
                    </div>
                </section>
                {{-- card good egg --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        <span class="font-bold">Telur Bagus</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ $goodEggs }} <span class="text-sm text-gray-500">Butir</span></span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Total</span>
                </section>
                {{-- card total cracked eggs --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        <span class="font-bold">Telur Retak</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ $crackedEggs }} <span class="text-sm text-gray-500">Butir</span></span>
                    </div>
                    <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Total</span>
                </section>
                {{-- card total production eggs --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg class="size-10 bg-gray-200 p-2 rounded-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.0001 13c0-.8883.4022-2.3826 1-3.27163M18.05 14c0 3.3137-2.6862 6-6 6-3.31366 0-5.99995-2.6863-5.99995-6S8.73634 4 12.05 4c3.3138 0 6 6.6863 6 10Z"/>
                        </svg>
                        <span class="font-bold">Produksi Telur</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5 mb-4">
                        <span class="text-4xl font-extrabold">{{ $totalEggs }} <span class="text-sm text-gray-500">Butir</span></span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Bulan Ini</span>
                </section>
            </div>
            
            {{-- section chart --}}
            <div class="w-full flex gap-x-8 mb-8 fade-up">
                <div>
                    {{-- fitur filter --}}
                    <section class="inline-flex items-center justify-between gap-x-3 fade-up">
                        <div>
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
                        </div>
                        {{--  btn export --}}
                        <button type="button" wire:click="exportPdf" aria-label="btn export" class="flex items-center gap-3 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                                </svg>
                            Export PDF
                        </button>
                    </section>
                    {{-- table --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3 mb-4 fade-up">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Telur Bagus
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Telur Retak
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->tableEggs as $item)
                                    <tr class="odd:bg-white  border-b  border-gray-200">
                                        <td scope="row" class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td scope="row" class="px-6 py-4">
                                            {{ $item->tanggal ?? 0  }}
                                        </td>
                                        <td scope="row" class="px-6 py-4">
                                            {{ number_format($item->jumlah_telur_bagus, 0, ',', '.') ?? 0  }} Butir
                                        </td>
                                        <td class="px-6 py-4">
                                            {{  number_format($item->jumlah_telur_retak, 0, ',', '.') ?? 0 }} Butir
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-sm font-normal p-4">Data tidak ada!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- section pagination --}}
                    <div>
                        {{ $this->tableEggs->links() }}
                    </div>
                </div>
                 <section class="bg-white w-1/3 h-max shadow-md p-4 sm:rounded-lg">
                    <div>
                        <div id="chartDonutTelur"></div>
                    </div>
                    @push('scripts')
                        <script>
                            var options = {
                                title: {
                                    text: 'Detail Telur Keseluruhan',
                                    align: 'left'
                                },
                                labels: ['Telur Hidup', 'Telur Retak'],
                                series:[ {{ $this->thisMonth['goodEggs'] }}, {{ $this->thisMonth['crackedEggs'] }} ],
                                chart: {
                                    type: 'donut',
                                    height: 600,
                                },
                                colors: ['#03a9f4', '#EA3546', '#FEB019'],
                                legend: {
                                    position: 'right',
                                    horizontalAlign: 'right'
                                }
                            };

                            var chartDonutTelur = new ApexCharts(document.querySelector("#chartDonutTelur"), options);
                            chartDonutTelur.render();
                        </script>
                    @endpush
                </section>
            </div>
        </div>
    </div>
</div>
