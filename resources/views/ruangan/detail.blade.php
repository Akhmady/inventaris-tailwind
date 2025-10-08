<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-6xl">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 sm:p-10 relative">


            <div class="absolute top-4 right-4">
                <a href="{{ route('ruangan.index') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 shadow hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-300 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700">
                    Kembali
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Detail Ruangan -->
            <h1 class="text-2xl font-bold  text-gray-800 dark:text-gray-100 mb-2">
                {{ $ruangan['nama_ruangan'] }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mb-4 ">
                Penanggung Jawab: <span class="font-semibold">{{ $ruangan['penanggung_jawab'] }}</span>
            </p>
            <h2 class="text-gray-600 dark:text-gray-100 mb-2">Deskripsi Ruangan:</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ $ruangan['deskripsi_ruangan'] }}
            </p>

            <!-- Tabel Aset -->
            <div class="flex flex-row justify-end">
                <a href="{{ route('ruangan.aset.create', Crypt::encrypt($ruangan['id'])) }}"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 focus:outline-hidden focus:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Tambah Aset Ruangan
                </a>
            </div>
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg shadow overflow-hidden mt-4">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-300 dark:bg-gray-900">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-semibold text-gray-700 dark:text-gray-200">No
                            </th>
                            <th scope="col"
                                class="px-12 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Nama Aset</th>
                            <th scope="col"
                                class="px-8 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Tipe</th>
                            <th scope="col"
                                class="px-8 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Kondisi</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Jumlah</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($aset as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->aset->nama_aset }}</td>
                                <td>{{ $item->aset->tipe_aset }}</td>
                                <td>{{ $item->kondisi }}</td>
                                <td>{{ $item->total }}</td>
                                <td> <x-icon-detail :item="$item"></x-icon-detail></td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Tidak ada data aset yang ditemukan untuk ruangan ini.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
