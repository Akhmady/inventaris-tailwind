<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Detail Aset - {{ $aset->namaAset }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 sm:p-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Detail Aset</h2>

            <!-- Foto Aset -->
            <div class="mb-6 flex justify-center">
                <img src="{{ asset('storage/' . $aset->foto_aset) }}" alt="{{ $aset->nama_aset }}"
                    class="w-48 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
            </div>


            <!-- Informasi Aset -->
            <div class="grid grid-cols-3 gap-x-6 gap-y-10">
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Nama Aset:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $aset->nama_aset }}</p>
                </div>

                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tipe Aset:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $aset->tipe_aset }}</p>
                </div>

                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Kode Aset:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $aset->kode_aset }}</p>
                </div>

                <div class="col-start-1 col-end-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Dibuat:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $aset->created_at->format('d M Y H:i') }}</p>
                </div>

                <div class="col-start-2 col-end-4">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Diperbarui:</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $aset->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>



            <!-- Tombol Kembali -->
            <div class="mt-8">
                <a href="{{ route('aset.index') }}"
                    class="block w-full text-center px-4 py-3 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Kembali
                </a>
            </div>
        </div>
    </div>

</body>

</html>
