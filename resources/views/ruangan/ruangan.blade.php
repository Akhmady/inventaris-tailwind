@extends('layouts.app')
@include('components.alert-success')
@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Ruangan</h1>


            <!-- Search Box -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <!-- Left: Search -->
                <form action="{{ route('ruangan.index') }}" method="GET" class="max-w-sm w-full">
                    <div class="flex rounded-lg shadow-sm">
                        <button type="submit"
                            class="w-12 h-11.5 shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </button>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ruangan..."
                            class="py-2.5 sm:py-3 px-4 block w-64 border-gray-200 rounded-e-lg sm:text-sm focus:z-10 
                                       focus:border-blue-500 focus:ring-blue-500
                                       dark:bg-gray-800 dark:border-neutral-700 
                                       dark:text-neutral-300 dark:placeholder-neutral-500 
                                       dark:focus:ring-neutral-600" />
                    </div>
                </form>

                <!-- Right: Buttons -->
                <div class="flex flex-row justify-end gap-3">
                    <a href="{{ route('ruangan.create') }}"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-teal-600 text-white hover:bg-teal-700 focus:outline-hidden focus:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tambah Ruangan
                    </a>

                    <button type="button"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-hidden focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
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
                                class="px-6 py-3 text-start text-xs font-semibold text-gray-700 dark:text-gray-200">No
                            </th>
                            <th scope="col"
                                class="px-12 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Nama
                                Ruangan</th>
                            <th scope="col"
                                class="px-8 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Penanggung Jawab</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Aksi
                                Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="ruanganTableBody">
                        @foreach ($ruangans as $index => $ruangan)
                            <tr
                                class="odd:bg-gray-50 even:bg-gray-100 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">

                                <!-- Nomor urut -->
                                <td class="px-6 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $loop->iteration + ($ruangans->currentPage() - 1) * $ruangans->perPage() }}
                                </td>

                                <!-- Nama Ruangan -->
                                <td class="px-6=12 py-3 text-center text-gray-900 dark:text-gray-100">
                                    {{ $ruangan->nama_ruangan }}
                                </td>

                                <!-- Penanggung Jawab -->
                                <td class="px-8 py-3 text-center text-gray-900 dark:text-gray-100">
                                    {{ $ruangan->penanggung_jawab }}
                                </td>

                                <!-- Aksi -->
                                <td
                                    class="px-4 text-sm flex justify-center gap-2 py-3 text-center text-gray-900 dark:text-gray-100 space-x-2">
                                    <a href="{{ route('ruangan.show', Crypt::encrypt($ruangan->id)) }}"
                                        class="px-2 rounded-lg text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">
                                        <x-icon-detail />
                                    </a>
                                    <a href="{{ route('ruangan.edit', Crypt::encrypt($ruangan->id)) }}"
                                        class="px-2 rounded-lg text-gray-600 hover:text-yellow-600 dark:text-gray-300 dark:hover:text-yellow-400">
                                        <x-icon-edit />
                                    </a>
                                    <a href="{{ route('ruangan.deleteConfirm', Crypt::encrypt($ruangan->id)) }}"
                                        class="px-2 text-gray-600 hover:text-red-800 dark:text-gray-300 dark:hover:text-red-400">
                                        <x-icon-delete />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                {{ $ruangans->links('vendor.pagination.custom') }}
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
