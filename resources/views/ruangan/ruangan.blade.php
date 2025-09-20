@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Ruangan</h1>

            <div class="flex flex-row justify-between">
                <!-- Search Box -->
                <div class="relative w-72">
                    <input type="text" id="searchRuangan"
                        class="py-2.5 ps-10 pe-4 block w-full border-gray-200 rounded-lg sm:text-sm 
                    focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-neutral-800 
                    dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Cari Ruangan..." autocomplete="off">

                    <!-- Icon search -->
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 h-11 ps-4">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-white/60" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 25 25" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>

                    <!-- Dropdown hasil pencarian -->
                    <div id="searchResults"
                        class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700 hidden">
                    </div>
                    @if (request()->has('q') && request('q') !== '')
                        <button id="clearSearch"
                            class="absolute h-11 inset-y-0 end-0 flex items-center px-3 text-gray-400 hover:text-red-500 dark:text-gray-300 dark:hover:text-red-400"
                            type="button">
                            ✕
                        </button>
                    @endif
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-row justify-end">
                    <a href="{{ route('ruangan.create') }}"
                        class="py-3 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 focus:outline-hidden focus:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tambah Ruangan
                    </a>

                    <button type="button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-hidden focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none mb-4 mx-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                        </svg>
                        Ekspor Data
                    </button>
                </div>
            </div>
            <!-- Table Ruangan -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg shadow overflow-hidden mt-4">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-900">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-semibold text-gray-700 dark:text-gray-200">No</th>
                            <th scope="col"
                                class="px-12 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Nama
                                Ruangan</th>
                            <th scope="col"
                                class="px-8 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Penanggung Jawab</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">Aksi
                                Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="ruanganTableBody">
                        @foreach ($ruangan as $index => $r)
                            <tr
                                class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ ($ruangan->currentPage() - 1) * $ruangan->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">
                                    {{ $r['namaRuangan'] }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900 dark:text-gray-100">
                                    {{ $r['penanggungJawab'] }}</td>
                                <td class="px-6 py-4 text-sm text-center flex justify-center gap-2">
                                    <!-- Detail -->
                                    <a href="{{ route('ruangan.show', Crypt::encrypt($r['id'])) }}"
                                        class="px-2 py-1 rounded-lg text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                        </svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('ruangan.edit', Crypt::encrypt($r['id'])) }}"
                                        class="px-3 py-1 rounded-lg text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>

                                    <!-- Delete -->
                                    <a href="{{ route('ruangan.deleteConfirm', Crypt::encrypt($r['id'])) }}"
                                        class="px-3 py-1 rounded-lg text-gray-600 hover:text-red-600 dark:text-gray-300 dark:hover:text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                {{ $ruangan->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>

    <script>
        // Enter untuk cari
        document.getElementById('searchRuangan').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                let query = this.value.trim();
                if (query.length > 0) {
                    window.location.href = "{{ route('ruangan.index') }}?q=" + encodeURIComponent(query);
                } else {
                    window.location.href = "{{ route('ruangan.index') }}";
                }
            }
        });

        // Clear tombol
        let clearBtn = document.getElementById('clearSearch');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                window.location.href = "{{ route('ruangan.index') }}";
            });
        }
    </script>
@endsection
