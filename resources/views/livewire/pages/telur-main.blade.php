<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Telur') }}
        </h2>
    </x-slot>       
    @php
        $kandang = auth()->user()->kandang;
        $ayam = auth()->user()->ayam;
    @endphp
    @if ($kandang && $kandang?->nama_kandang || $ayam && $ayam?->jumlah_ayam )
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- alert --}}
                @include('livewire.layout.alert')
                {{-- card --}}
                <div class="flex space-x-3 mb-6 fade-up">
                    {{-- card good eggs --}}
                    <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                        <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                              </svg>
                            <span class="font-bold">Telur Bagus</span>
                        </div>
                        <div class="flex justify-between items-center gap-x-5 mb-4">
                            <span class="text-4xl font-extrabold">{{ number_format($this->jumlahTelur['telurBagus'], 0, ',', '.') }} <span class="text-sm text-gray-500">Butir</span></span>
                        </div>
                        <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Bulan ini</span>
                    </section>
                    {{-- card cracked eggs --}}
                    <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                        <div class="flex-col flex gap-y-2 text-gray-500 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                            <span class="font-bold">Telur Retak</span>
                        </div>
                        <div class="flex justify-between items-center gap-x-5 mb-4">
                            <span class="text-4xl font-extrabold">{{ number_format($this->jumlahTelur['telurRetak'], 0, ',', '.') }} <span class="text-sm text-gray-500">Butir</span></span>
                        </div>
                        <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Bulan ini</span>
                    </section>
                    {{-- total eggs --}}
                    <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                        <div class="flex-col flex gap-y-2 text-gray-500 mb-2">
                            <svg class="size-10 bg-gray-200 p-2 rounded-md" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.0001 13c0-.8883.4022-2.3826 1-3.27163M18.05 14c0 3.3137-2.6862 6-6 6-3.31366 0-5.99995-2.6863-5.99995-6S8.73634 4 12.05 4c3.3138 0 6 6.6863 6 10Z"/>
                              </svg>
                            <span class="font-bold">Total Telur</span>
                        </div>
                        <div class="flex justify-between items-center gap-x-5 mb-4">
                            <span class="text-4xl font-extrabold">{{ $totalEggs }} <span class="text-sm text-gray-500">Butir</span></span>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 w-max text-xs font-medium me-2 px-2.5 py-0.5 rounded-full border border-yellow-300">Semua</span>
                    </section>
                    {{-- card chart --}}
                    <section>
                        <div class="translate-x-10">
                            <div id="chart"></div>
                        </div>
                        @push('scripts')
                            <script>
                                var options = {
                                    title: {
                                        text: 'Produksi Telur'
                                    },
                                    chart: {
                                        type: 'donut',
                                        height: 180,
                                    },
                                    labels: ['Telur Bagus', 'Telur Retak'],
                                    series: [{{ $this->jumlahTelur['telurBagus'] ?? 100}}, {{ $this->jumlahTelur['telurRetak'] ?? 100 }}],
                                    colors: ['#03a9f4', '#EA3546'],
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
                {{-- section create --}}
                <section class="flex items-center space-x-4 w-full fade-up">
                    {{-- btn create data egg --}}
                    <a  href="{{ route('telur.create') }}" aria-label="buat data telur" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        Create Data Telur
                    </a>
                    {{-- fitur filter --}}
                    <div>
                        <form class="max-w-sm mx-auto flex gap-x-3 ">
                            <div>
                                <select id="bulan" aria-label="pilih bulan" wire:model.live="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2 ">
                                    @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <select id="tahun" aria-label="pilih tahun" wire:model.live="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2 ">
                                    @for ($y = now()->year; $y >= 2020; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </form>
                    </div>
                    {{-- btn export to pdf --}}
                    <button type="button" aria-label="export pdf"  wire:click="exportPdf" class="flex items-center gap-3 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2">
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                          </svg>
                        Export PDF
                    </button>
                </section>
                {{-- tabel --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 mb-4 fade-up">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jumlah Telur Bagus
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jumlah Telur Retak
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
                            @forelse ($this->findTelur as $item)
                                <tr class="odd:bg-white  border-b  border-gray-200">
                                    <td wire:key="{{$item->id}}" class="px-6 py-4">
                                        {{ $loop->iteration}}
                                    </td>
                                    <td scope="row" class="px-6 py-4">
                                        {{ number_format($item->jumlah_telur_bagus , 0, ',', '.') }} Butir
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ number_format($item->jumlah_telur_retak , 0, ',', '.') }} Butir
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 inline-flex items-center gap-x-6 py-4">
                                        <a href="{{route('telur.edit', $item->id)}}" aria-label="edit telur" class="font-medium text-gray-500 flex items-center"> <svg arial-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        </a>
                                        <button wire:click="destroy({{ $item->id }})" aria-label="hapus data" wire:confirm="Apakah kamu yakin ingin menghapus data ini?">
                                            <svg xmlns="http://www.w3.org/2000/svg" arial-hidden="true" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="p-4 text-sm font-normal">Data tidak ditemukan!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- pagination --}}
                <div>{{ $this->findTelur->links() }}</div>
            </div>
        </div>
    @else
    <div class="p-6 space-y-6 fade-up">
        <p>Silakan buat terlebih dahulu nama kandang dan data ayam!</p>
        <div class="flex items-center gap-x-2">
            <a  href="{{ route('kandang.create') }}" aria-label="buat kandang" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                </svg>
                Buat Kandang
            </a>
            <span>Atau</span>
            <a  href="{{ route('ayam.create') }}" aria-label="buat data ayam" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                <svg class="w-6 h-6 text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                Buat Data Ayam
            </a>
        </div>
    </div>   
    @endif

</div>
