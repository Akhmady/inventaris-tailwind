<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-3xl">
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit Ruangan</h2>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 sm:p-10 relative">

            {{-- Tombol kembali --}}
            <div class="absolute top-4 right-4">
                <a href="{{ route('ruangan.index') }}"
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 shadow hover:bg-red-50 focus:outline-hidden focus:bg-red-100 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                    Kembali
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('ruangan.update', $encryptedId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Deskripsi Ruangan</label>
                    <textarea name="deskripsi_ruangan"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        rows="4" required>{{ old('deskripsi_ruangan', $ruangan->deskripsi_ruangan) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab"
                        value="{{ old('penanggung_jawab', $ruangan->penanggung_jawab) }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        required>
                </div>

                <div class="text-right">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>
