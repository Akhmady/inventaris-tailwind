@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Ruangan</h1>
        <div class="flex flex-row justify-between">
        <div class="max-w-sm mb-4">
            <!-- SearchBox -->
            <div class="relative" data-hs-combo-box='{
              "groupingType": "default",
              "isOpenOnFocus": true,
              "apiUrl": "../assets/data/searchbox.json",
              "apiGroupField": "category",
              "outputItemTemplate": "&lt;div data-hs-combo-box-output-item&gt;&lt;span class=\"flex items-center cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200\"&gt;&lt;div class=\"flex items-center w-full\"&gt;&lt;div class=\"flex items-center justify-center rounded-full bg-gray-200 size-6 overflow-hidden me-2.5\"&gt;&lt;img class=\"shrink-0\" data-hs-combo-box-output-item-attr=&apos;[{\"valueFrom\": \"image\", \"attr\": \"src\"}, {\"valueFrom\": \"name\", \"attr\": \"alt\"}]&apos; /&gt;&lt;/div&gt;&lt;div data-hs-combo-box-output-item-field=\"name\" data-hs-combo-box-value&gt;&lt;/div&gt;&lt;div class=\"hidden\" data-hs-combo-box-output-item-field=&apos;[\"name\", \"category\"]&apos; data-hs-combo-box-search-text&gt;&lt;/div&gt;&lt;/div&gt;&lt;span class=\"hidden hs-combo-box-selected:block\"&gt;&lt;svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"&gt;&lt;polyline points=\"20 6 9 17 4 12\"&gt;&lt;/polyline&gt;&lt;/svg&gt;&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;",
              "groupingTitleTemplate": "&lt;div class=\"text-xs uppercase text-gray-500 m-3 mb-1 dark:text-neutral-500\"&gt;&lt;/div&gt;"
            }'>
              <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                  <svg class="shrink-0 size-4 text-gray-400 dark:text-white/60" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                  </svg>
                </div>
                <input class="py-2.5  ps-10 pe-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-neutral-800 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" type="text" role="combobox" aria-expanded="false" placeholder="Cari Ruangan" value="" data-hs-combo-box-input="">
              </div>
              <!-- SearchBox Dropdown -->
              <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700" style="display: none;" data-hs-combo-box-output="">
                <div class="max-h-72 rounded-b-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" data-hs-combo-box-output-items-wrapper=""></div>
              </div>
              <!-- End SearchBox Dropdown -->
            </div>
            <!-- End SearchBox -->
        </div>
        <div class="flex flex-row justify-end">
            
            <a href="{{ route('ruangan.create') }}"
 
            class="py-3 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 focus:outline-hidden focus:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                Tambah Ruangan
                            </a>
            <button type="button" class="py-3 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-hidden focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none mb-4 mx-3" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                  </svg>
                  Ekspor Data
            </button> 
        </div>
    </div>
        <div class="border border-gray-200 dark:border-gray-700 rounded-lg shadow overflow-hidden">
            
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-300 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-700 dark:text-gray-200">No</th>
                        <th scope="col" class="px-12 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Nama Ruangan</th>
                        <th scope="col" class="px-8 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Penanggung Jawab</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-700 dark:text-gray-200">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">1</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">Ruangan I</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">Placeholder</td>
                        <td class="px-6 py-4 text-sm text-end flex justify-end gap-2">
                            <!-- Detail -->
                            <button class="p-1 rounded-lg text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <!-- Edit -->
                            <button class="p-1 rounded-lg text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17h2m-1-9v6m-7 8h14a2 2 0 002-2V7l-7-5H6a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <!-- Delete -->
                            <button class="p-1 rounded-lg text-gray-600 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    <tr class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">2</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">Ruangan II</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">Placeholder II</td>
                        <td class="px-6 py-4 text-sm text-end flex justify-end gap-2">
                            <!-- sama action -->
                            <button class="p-1 rounded-lg text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">…</button>
                            <button class="p-1 rounded-lg text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400">…</button>
                            <button class="p-1 rounded-lg text-gray-600 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400">…</button>
                        </td>
                    </tr>

                    <!-- Tambah row lain -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
