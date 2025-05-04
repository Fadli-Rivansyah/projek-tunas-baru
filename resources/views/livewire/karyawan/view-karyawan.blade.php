<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Karyawan') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- card --}}
            <div class="flex gap-x-3 mb-6 fade-up">
                {{-- card  name employee --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg class="size-10 bg-gray-200 p-2 rounded-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z"/>
                          </svg>
                        <span class="font-bold">Nama Karyawan</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5">
                        <span class="text-2xl font-extrabold">{{ $name }}</span>
                    </div>
                </section>
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
                {{-- card total chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-4">
                        <svg  xmlns="http://www.w3.org/2000/svg"  aria-hidden="true"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-meat size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 3.414 -1.415a2 2 0 1 1 -1.413 3.414l-1.82 1.821" /><path d="M5.904 18.596c2.733 2.734 5.9 4 7.07 2.829c1.172 -1.172 -.094 -4.338 -2.828 -7.071c-2.733 -2.734 -5.9 -4 -7.07 -2.829c-1.172 1.172 .094 4.338 2.828 7.071z" /><path d="M7.5 16l1 1" /><path d="M12.975 21.425c3.905 -3.906 4.855 -9.288 2.121 -12.021c-2.733 -2.734 -8.115 -1.784 -12.02 2.121" />
                        </svg>
                        <span class="font-bold">Jumlah Ayam Dikelolah</span>
                    </div>
                    <div class="flex items-center gap-x-5">
                        <span class="text-2xl font-extrabold">{{ $chickenCount }} <span class="text-gray-500 text-sm">Ekor</span></span>
                    </div>
                </section>
                {{-- card age chicken --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg  xmlns="http://www.w3.org/2000/svg"  aria-hidden="true"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-skull size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 4c4.418 0 8 3.358 8 7.5c0 1.901 -.755 3.637 -2 4.96l0 2.54a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1v-2.54c-1.245 -1.322 -2 -3.058 -2 -4.96c0 -4.142 3.582 -7.5 8 -7.5z" /><path d="M10 17v3" /><path d="M14 17v3" /><path d="M9 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        <span class="font-bold">Usia Ayam</span>
                    </div>
                    <div class="flex items-center gap-x-5">
                        <span class="text-2xl font-extrabold">{{ $chickenAge }}  <span class="text-gray-500 text-sm">Minggu</span></span>
                    </div>
                </section>
            </div>
            {{-- section chart --}}
            <div class="w-full flex justify-between gap-x-5 mb-8 fade-up">
                <section class=" bg-white shadow-md w-2/3  p-4  h-max sm:rounded-lg">
                    <div>
                        <div id="chart"></div>
                    </div>
                    @push('scripts')
                        <script>
                        var lineChart = {
                            chart: {
                                type: 'line',
                                height: 250
                            },
                            series: [{
                                name: 'Telur Bagus',
                                data: @json($goodEggs),
                            },{
                                name: 'Telur Retak',
                                data: @json($crackedEggs),
                            }],
                            xaxis: {
                                categories: @json($labels),
                            },
                            stroke: {
                                curve: 'smooth'
                            },
                            colors: ['#03a9f4', '#EA3546'],
                            title: {
                                text: 'Produksi Telur Bulanan - {{ now()->year }}',
                                align: 'left'
                            },
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'right'
                            }
                        }
                    
                        var lineChartTelur = new ApexCharts(document.querySelector("#chart"), lineChart);
                        lineChartTelur.render();
                        </script>
                    @endpush
                </section>
                <section class="bg-white w-1/3  shadow-md p-4 sm:rounded-lg">
                    <div>
                        <div id="chartDonutTelur"></div>
                    </div>
                    @push('scripts')
                        <script>
                            var options = {
                                title: {
                                    text: 'Detail Ayam',
                                    align: 'left'
                                },
                                labels: ['Ayam Hidup', 'Ayam Mati', 'Usia Ayam'],
                                series:[ {{ $liveChicken }}, {{ $deadChicken }}, {{ $ageChickenNow }}],
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
                                Total Ayam 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Ayam Mati
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Produksi Telur
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Telur Retak 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Pakan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->summaryEmployee as $item)
                            <tr class="odd:bg-white  border-b  border-gray-200">
                                <td scope="row" class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{ $item['tanggal'] ??0  }}
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{ number_format($item['liveChickens'], 0, ',', '.') ?? 0  }} Ekor
                                </td>
                                <td class="px-6 py-4">
                                    {{  number_format($item['deadChickens'], 0, ',', '.') ?? 0 }} Ekor
                                </td>
                                <td class="px-6 py-4">
                                    {{  number_format($item['productionEggs'], 0, ',', '.') ?? 0 }} Butir
                                </td>
                                <td class="px-6 py-4">
                                    {{  number_format($item['crackedEggs'], 0, ',', '.') ?? 0 }} Butir
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($item['feedChickens'] , 0, ',', '.') ?? 0 }} Kg
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
                {{ $this->summaryEmployee->links() }}
            </div>
        </div>
    </div>
</div>
