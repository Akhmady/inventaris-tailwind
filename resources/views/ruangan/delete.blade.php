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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Hapus Ruangan</h2>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 sm:p-10 relative">


            <div class="absolute top-4 right-4">
                <a href="{{ route('ruangan.index') }}"
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-400 bg-white text-gray-700 shadow hover:bg-gray-50 focus:outline-hidden focus:bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:hover:bg-gray-600 dark:focus:bg-gray-600">
                    Batal
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- Alert Warning --}}
            <div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 mb-6 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
                role="alert" tabindex="-1" aria-labelledby="hs-with-description-label">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                    </div>
                    <div class="ms-4">
                        <h3 id="hs-with-description-label" class="text-sm font-semibold">
                            Konfirmasi Penghapusan Data Ruangan
                        </h3>
                        <div class="mt-1 text-sm text-red-700 dark:text-red-400">
                            Menghapus Ruangan akan sekaligus menghapus semua Aset yang terdaftar di dalamnya.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol kembali --}}


            {{-- Form Delete --}}
            <form action="{{ route('ruangan.destroy', Crypt::encrypt($ruangan['id'] ?? 1)) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('DELETE')

                {{-- Nama Ruangan --}}
                <div>
                    <label for="namaRuangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Ruangan
                    </label>
                    <input type="text" id="namaRuangan"
                        class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 sm:text-sm"
                        value="{{ $ruangan['namaRuangan'] ?? 'Ruang Rapat Utama' }}" disabled>
                </div>

                {{-- Penanggung Jawab --}}
                <div>
                    <label for="penanggungJawab" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Penanggung Jawab
                    </label>
                    <input type="text" id="penanggungJawab"
                        class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 sm:text-sm"
                        value="{{ $ruangan['penanggungJawab'] ?? 'Bapak Andi' }}" disabled>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi" rows="4"
                        class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 sm:text-sm"
                        disabled>{{ $ruangan['deskripsi'] ?? 'Ruang untuk rapat staf dan tamu penting' }}</textarea>
                </div>

                {{-- Tombol Delete --}}
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Hapus Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
