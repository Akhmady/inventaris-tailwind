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
            <form action="{{ route('ruangan.update', Crypt::encrypt($ruangan['id'] ?? 1)) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Ruangan --}}
                <div>
                    <label for="namaRuangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Ruangan
                    </label>
                    <input type="text" name="namaRuangan" id="namaRuangan"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                        value="{{ old('namaRuangan', $ruangan['namaRuangan'] ?? 'Ruang Rapat Utama') }}" required>
                    @error('namaRuangan')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label for="penanggungJawab" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Penanggung Jawab
                    </label>
                    <input type="text" name="penanggungJawab" id="penanggungJawab"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                        value="{{ old('penanggungJawab', $ruangan['penanggungJawab'] ?? 'Bapak Andi') }}" required>
                    @error('penanggungJawab')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">{{ old('deskripsi', $ruangan['deskripsi'] ?? 'Ruang untuk rapat staf dan tamu penting') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
