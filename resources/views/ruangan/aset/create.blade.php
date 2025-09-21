<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-200">

    <div class="container  mx-auto px-4 py-6">

        <div class="mb-6">
            <a href="{{ route('ruangan.show', Crypt::encrypt($ruangan['id'])) }}"
                class="px-4 py-2 bg-gray-600  text-white text-sm rounded-lg hover:bg-gray-700">
                ← Kembali ke Detail Ruangan
            </a>
        </div>


        <h1 class="text-3xl text-center font-bold mb-8">Tambah Aset ke Ruangan</h1>

        {{-- Form Tambah Aset --}}
        <form action="{{ route('ruangan.aset.store', Crypt::encrypt($ruangan['id'])) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($asets as $aset)
                    <div
                        class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden border dark:border-gray-700">
                        {{-- Foto --}}
                        <div class="h-40 w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            {{-- <img src="{{ asset('images/placeholder.png') }}" alt="Foto Aset" class="h-24 opacity-70"> --}}
                            <img src="{{ $aset['foto'] ?? asset('images/placeholder.png') }}" alt="{{ $aset['nama'] }}"
                                class="h-32 w-32  opacity-80">
                        </div>

                        {{-- Informasi aset --}}
                        <div class="p-4">
                            <h2 class="text-lg font-semibold">{{ $aset['nama'] }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tipe: {{ $aset['tipe'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                Kode: {{ $aset['kode'] ?? '—' }}
                            </p>

                            {{-- Input jumlah --}}
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Jumlah</label>
                                <input type="number" min="0" name="jumlah[{{ $aset['kode'] }}]"
                                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                            </div>

                            {{-- Input kondisi --}}
                            <div>
                                <label class="block text-sm font-medium">Kondisi</label>
                                <select name="kondisi[{{ $aset['kode'] }}]"
                                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                                    <option value="Baik" selected>Baik (default)</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $asets->links('vendor.pagination.custom') }}
            </div>

            {{-- Tombol simpan --}}
            <div class="mt-8 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    Simpan Aset Ruangan
                </button>
            </div>
        </form>
    </div>

</body>

</html>
