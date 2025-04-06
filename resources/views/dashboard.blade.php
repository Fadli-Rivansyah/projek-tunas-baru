<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="mb-6">
                <h3 class="text-xl font-medium text-gray-500">Selamat datang <strong class="underline">{{auth()->user()->name}}</strong>!! 👋</h3>
            </section>
            <div class="flex w-full gap-4">
                <section class="bg-white w-64  overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                        <span class="font-bold">Nama Kandang</span>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold">{{auth()->user()->kandang->nama_kandang}}</h3>
                    </div>
                </section>
                <section class="bg-white w-64  overflow-hidden shadow-md p-4 sm:rounded-lg">
                    <div class="flex-col flex gap-y-2 text-gray-500 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-10 bg-gray-200 p-2 rounded-md">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="font-bold">Total Ayam</span>
                    </div>
                    <div class="flex justify-between items-center gap-x-5">
                        <span class="text-4xl font-extrabold">5000,</span>
                        <div class="text-red-500 bg-red-200 border-red-400  rounded-lg inline-flex items-center font-bold px-1 py-0.2 gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25 12 21m0 0-3.75-3.75M12 21V3" />
                            </svg>                      
                            <span class="text-sm">10, ekor</span>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>
