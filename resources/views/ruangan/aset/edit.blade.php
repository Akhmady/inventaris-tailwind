<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center ">

    <div class="w-full h-full max-w-6xl  relative mx-auto bg-white dark:bg-gray-800 py-8 px-10 rounded-lg">
        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Edit Aset - {{ $ruangan['namaRuangan'] }}
        </h2>

        <div class="space-y-24">
            <div class=" absolute top-4 right-4">
                <a href="{{ route('ruangan.show', Crypt::encrypt($ruangan['id'])) }}"
                    class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 shadow hover:bg-red-50 focus:outline-hidden focus:bg-red-100 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                    Kembali
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>

            <form id="editForm" method="POST"
                action="{{ route('ruangan.aset.update', ['ruangan' => $encRuangan, 'group' => $encGroup]) }}">
                @csrf
                @method('PUT')


                @foreach ($units as $unit)
                    <div
                        class="p-3 mb-2 *:border rounded flex items-center justify-between border  border-gray-200 dark:border-gray-700  shadow overflow-hidden mt-4">
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $unit['nama'] }} <span
                                    class="text-sm text-gray-500">({{ $unit['tipe'] }})</span></div>
                            <div class="text-sm text-gray-500">Kode: {{ $unit['kode'] }}</div>
                        </div>

                        <div class="flex items-center gap-4">
                            <select name="kondisi[{{ $unit['kode'] }}]" class="border rounded px-7 py-1"
                                data-original="{{ $unit['kondisi'] }}">
                                <option value="Baik" {{ $unit['kondisi'] == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan"
                                    {{ $unit['kondisi'] == 'Rusak Ringan' ? 'selected' : '' }}>
                                    Rusak Ringan</option>
                                <option value="Rusak Berat" {{ $unit['kondisi'] == 'Rusak Berat' ? 'selected' : '' }}>
                                    Rusak Berat</option>
                            </select>

                            <button type="button" onclick="confirmDelete('{{ $unit['kode'] }}')"
                                class="px-3 py-1 rounded text-white bg-red-600 hover:bg-red-700">Hapus</button>
                        </div>
                    </div>
                @endforeach
        </div>

        <button id="saveBtn" disabled class="mt-6 w-full py-3 bg-teal-600 hover:bg-teal-800 text-white rounded">Simpan
            Perubahan</button>
        </form>
    </div>

    <script>
        // Aktifkan tombol save jika ada perubahan kondisi
        document.querySelectorAll('select[name^="kondisi"]').forEach(sel => {
            sel.addEventListener('change', () => {
                document.getElementById('saveBtn').disabled = false;
            });
        });

        function confirmDelete(kode) {
            if (confirm('Yakin hapus aset ' + kode + '?')) {
                // lakukan submit ke route destroy via fetch (atau redirect ke form delete)
                // Contoh sederhana: buat form POST dengan method DELETE dan submit
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch("{{ url('/ruangan') }}/{{ Crypt::encrypt($ruangan['id']) }}/aset/" + encodeURIComponent(kode), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(r => {
                    if (r.ok) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus');
                    }
                });
            }
        }
    </script>
</body>

</html>
