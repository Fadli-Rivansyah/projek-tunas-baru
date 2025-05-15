<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pakan') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- alert --}}
            @include('livewire.layout.alert')
            <div class="flex gap-x-3 mb-6 fade-up">
                 {{-- card total feed --}}
                 <section class="bg-white w-72 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg ">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-bowl-spoon size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 11h16a1 1 0 0 1 1 1v.5c0 1.5 -2.517 5.573 -4 6.5v1a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-1c-1.687 -1.054 -4 -5 -4 -6.5v-.5a1 1 0 0 1 1 -1z" /><path d="M8 7c1.657 0 3 -.895 3 -2s-1.343 -2 -3 -2s-3 .895 -3 2s1.343 2 3 2" /><path d="M11 5h9" /></svg>
                        <span class="font-bold">Total Pakan</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 gap-x-5">
                        <span class="text-4xl font-extrabold">
                            {{ $totalFeed }}
                            <span class="text-gray-500 text-sm">Kg</span>
                        </span>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 w-max text-xs font-medium me-2 px-2.5 py-0.5 rounded-full border border-yellow-300">Bulan Ini</span>
                </section>
                {{-- card total corn --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-seedling size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 10a6 6 0 0 0 -6 -6h-3v2a6 6 0 0 0 6 6h3" /><path d="M12 14a6 6 0 0 1 6 -6h3v1a6 6 0 0 1 -6 6h-3" /><path d="M12 20l0 -10" /></svg>
                        <span class="font-bold">Jumlah Jagung</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 gap-x-5">
                        <span class="text-4xl font-extrabold">
                            {{ $jagung }}
                            <span class="text-gray-500 text-sm">Kg</span>
                        </span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Saat ini</span>
                </section>
                {{-- card multivitamin --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                        <span class="font-bold">Jumlah Multivitamin</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 gap-x-5">
                        <span class="text-4xl font-extrabold">
                            {{ $multivitamin }}
                            <span class="text-gray-500 text-sm">Kg</span>
                        </span>
                    </div>
                    <span class="w-max bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-green-400">Saat ini</span>
                </section>
                {{-- card nameChickencoop --}}
                <section class="bg-white w-64 flex justify-between flex-col overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-recycle size-10 bg-gray-200 p-2 rounded-md"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17l-2 2l2 2" /><path d="M10 19h9a2 2 0 0 0 1.75 -2.75l-.55 -1" /><path d="M8.536 11l-.732 -2.732l-2.732 .732" /><path d="M7.804 8.268l-4.5 7.794a2 2 0 0 0 1.506 2.89l1.141 .024" /><path d="M15.464 11l2.732 .732l.732 -2.732" /><path d="M18.196 11.732l-4.5 -7.794a2 2 0 0 0 -3.256 -.14l-.591 .976" /></svg>
                        </svg>
                        <span class="font-bold">Sisa Pakan</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 gap-x-5">
                        <span class="text-4xl font-extrabold">
                            {{ $leftOverFeed }}
                            <span class="text-gray-500 text-sm">Kg</span>
                        </span>
                    </div>
                    <span class="w-max bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full  border border-red-400">Sisa</span>
                </section>
            </div>
            {{-- section create --}}
            <section class="inline-flex items-center gap-x-4 w-full fade-up">
                <a  href="{{ route('pakan.create') }}" class="flex items-center gap-2 text-white bg-yellow-500 w-max hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500 font-medium rounded-md text-sm px-5 py-2.5 text-center mb-2">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    Buat Data Pakan
                </a>
                  {{-- fitur filter --}}
                <div>
                    <form class="max-w-sm mx-auto flex gap-x-3 ">
                        <div>
                            <select id="month" wire:model.live="bulan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2">
                                @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <select id="years" wire:model.live="tahun" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 me-2">
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                      </form>
                </div>
                {{-- btn export to pdf --}}
                <button type="button"  wire:click="exportPdf" class="flex items-center gap-3 text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                      </svg>
                    Export PDF
                </button>
                <div wire:loading wire:target="exportPdf" class="translate-x-5">
                    <span class="italic animate-pulse">Mencoba mengunduh ...</span>
                </div>
            </section>
            {{-- tabel --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 fade-up">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Pakan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Jagung
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah Multivitamin
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sisa Pakan
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
                        @forelse ($this->monthlyFeeds as $item)
                            <tr class="odd:bg-white  border-b  border-gray-200">
                                <td wire:key="{{$item->id}}" class="px-6 py-4">
                                    {{ $item->id}}
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{$item->total_pakan }} Kg
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{$item->jumlah_jagung }} Kg
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->jumlah_multivitamin }} Kg
                                </td>
                                <td class="px-6 py-4">
                                    {{$item->sisa_pakan }} Kg
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                </td>
                                <td class="px-6 inline-flex items-center gap-x-6 py-4">
                                    {{-- btn edit --}}
                                    <a href="{{route('pakan.edit', $item->id)}}" class="font-medium text-gray-500 flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                      </svg>
                                    </a>
                                    {{-- btn delete --}}
                                    <button wire:click="destroy({{ $item->id }})" wire:confirm="Apakah kamu yakin menghapus data ini?" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
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
            <div>{{ $this->monthlyFeeds->links() }}</div>
        </div>
    </div>
</div>
