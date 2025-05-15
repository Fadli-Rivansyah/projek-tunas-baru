<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ayam') }}
        </h2>
    </x-slot>
    @php
        $kandang = auth()->user()->kandang;
    @endphp
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if ($kandang && $kandang->nama_kandang)
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
                                <span class="text-4xl font-extrabold">{{ number_format($totalAyam, 0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
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
                                <span class="text-4xl font-extrabold">{{ number_format($totalMati, 0, ',', '.') }} <span class="text-sm text-gray-500">Ekor</span></span>
                            </div>
                            <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Saat Ini</span>
                        </section>
                        {{-- card feed --}}
                        <section class="bg-white w-64 overflow-hidden shadow-md p-4 sm:rounded-lg">
                            <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                                </svg>
                                <span class="font-bold">Stok Pakan</span>
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <article>
                                    <span class="text-sm text-gray-500 font-bold">Jagung</span>
                                    <div class="flex w-full bg-gray-100 rounded-full h-5">
                                        <div class="bg-yellow-300 h-5 rounded-full w-full inline-flex items-center" style="width: {{$pakan['jagung'] ?? 0}}%"><span class="text-sm text-gray-900 p-2">{{$pakan['jagung'] ?? 0}}%</span></div>
                                    </div>
                                </article>
                                <article>
                                    <span class="text-sm text-gray-500 font-bold">Multivitamin</span>
                                    <div class="flex w-full bg-gray-100 rounded-full h-5">
                                        <div class="bg-violet-300 h-5 rounded-full w-full inline-flex items-center" style="width: {{$pakan['multivitamin'] ?? 0 }}%"><span class="text-sm text-gray-900 p-2">{{$pakan['multivitamin'] ?? 0 }}%</span></div>
                                    </div>
                                </article>
                            </div>
                        </section>
                        {{-- card chart --}}
                        <section>
                            <div class="translate-x-10">
                                <div id="chart"></div>
                            </div>
                            @push('scripts')
                                <script defer>
                                            var options = {
                                                chart: {
                                                    type: 'donut',
                                                    height: 180,
                                                },
                                                labels: ['Ayam Hidup', 'Ayam Mati', 'Usia Ayam'],
                                                series: [{{$totalAyamChart}}, {{$totalMatiChart}}, {{ $chickenAge }}],
                                                colors: ['#03a9f4', '#EA3546', '#FEB019'],
                                                legend: {
                                                    position: 'right',
                                                    horizontalAlign: 'right'
                                                },
                                            };
                                        
                                            var chart = new ApexCharts(document.querySelector("#chart"), options);
                                            chart.render();
                                </script>
                            @endpush
                        </section>
                    </div>
                    {{-- btn create data chicken --}}
                    <section class="inline-flex items-center gap-x-3 fade-up">
                        <a  href="{{ route('ayam.create') }}" aria-label="buat data ayam" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                            <svg aria-hidden="true" class="w-6 h-6 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            Buat Data Ayam
                        </a>
                        {{-- fitur filter --}}
                        <div>
                            <form class="max-w-sm mx-auto flex gap-x-3 ">
                                <div>
                                    <select id="bulan" wire:model.live="bulan"  aria-label="Pilih bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2 ">
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <select id="tahun" wire:model.live="tahun"  aria-label="Pilih tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2 ">
                                        @for ($y = now()->year; $y >= 2020; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </form>
                        </div>
                        {{-- btn export to pdf --}}
                        <button type="button" aria-label="export pdf" wire:click="exportPdf" class="flex items-center gap-3 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                            </svg>
                            Export PDF
                        </button>
                        <div wire:loading wire:target="exportPdf" class="translate-x-5">
                            <span class="italic animate-pulse">Mencoba mengunduh ...</span>
                        </div>
                    </section>
                    {{-- table --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 mb-4 fade-up">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
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
                                @forelse ($this->monthlyChickens as $item)
                                    <tr class="odd:bg-white border-b border-gray-200">
                                        <td wire:key="{{$item->id}}" class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td scope="row" class="px-6 py-4 ">
                                            {{ number_format($item->total_ayam , 0, ',', '.') }} Ekor
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
                                        <td class="px-6 inline-flex items-center gap-x-6 py-4">
                                            {{-- btn edit --}}
                                            <a href="{{route('ayam.edit', $item->id)}}" aria-label="Edit ayam" class="font-medium text-gray-500 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            </a>
                                            {{-- btn delete --}}
                                            <button aria-label="Hapus Data" wire:click="destroy({{ $item->id }})" wire:confirm="Apakah kamu yakin menghapus data ini?" >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
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
                    <div >{{ $this->monthlyChickens->links() }}</div>
                @else
                    <div class="p-6 space-y-6 fade-up">
                        <p>Silakan buat terlebih dahulu nama kandang!</p>
                        <a  href="{{ route('kandang.create') }}" aria-label="buat kandang" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                            </svg>
                            Buat Kandang
                        </a>
                    </div>    
                @endif
            </div>
        </div>
    
</div>
