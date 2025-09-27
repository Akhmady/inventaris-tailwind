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
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Tambah Aset</h2>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 sm:p-10 relative">


            <div class="absolute top-4 right-4">
                <a href="{{ route('aset.index') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 shadow hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-300 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700">
                    Kembali
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>





            <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nama Aset -->
                <div>
                    <label for="namaAset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                        Aset</label>
                    <input type="text" name="namaAset" id="namaAset" value="{{ old('namaAset') }}" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100" />
                    @error('namaAset')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Aset -->
                <div>
                    <label for="tipeAset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe
                        Aset</label>
                    <select name="tipeAset" id="tipeAset" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Furnitur" {{ old('tipeAset') === 'Furnitur' ? 'selected' : '' }}>Furnitur
                        </option>
                        <option value="Elektronik" {{ old('tipeAset') === 'Elektronik' ? 'selected' : '' }}>
                            Elektronik</option>
                        <option value="Dekorasi" {{ old('tipeAset') === 'Dekorasi' ? 'selected' : '' }}>Dekorasi
                        </option>
                        <option value="Lainnya" {{ old('tipeAset') === 'Lainnya' ? 'selected' : '' }}>Lainnya
                        </option>
                    </select>
                    @error('tipeAset')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Upload Foto -->
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload
                        Foto</label>

                    <div class="mt-2 flex items-center gap-4">
                        <!-- Tombol Upload -->
                        <label for="foto"
                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-300"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v16h16V4H4zm8 12a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>
                            Pilih Foto
                        </label>

                        <!-- Nama File -->
                        <span id="fileName" class="text-sm text-gray-500 dark:text-gray-400">Belum ada file</span>

                        <!-- Tombol Cancel -->
                        <button type="button" id="cancelUpload"
                            class="hidden px-2 py-1 text-xs font-medium text-red-600 border border-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-800 dark:text-red-300 dark:border-red-600">
                            Batal
                        </button>
                    </div>

                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden" />

                    @error('foto')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="mt-4">
                        <img id="previewImage" src="#" alt="Preview Gambar"
                            class="hidden w-48 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-700" />
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Upload file + preview + cancel ---
            const fileInput = document.getElementById('foto');
            const fileNameEl = document.getElementById('fileName');
            const previewImage = document.getElementById('previewImage');
            const cancelBtn = document.getElementById('cancelUpload');

            // Reset fungsi upload
            function resetUpload() {
                fileInput.value = "";
                fileNameEl.textContent = "Belum ada file";
                previewImage.src = "#";
                previewImage.classList.add('hidden');
                cancelBtn.classList.add('hidden');
            }

            // Event saat pilih file
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files && event.target.files[0];
                if (file) {
                    fileNameEl.textContent = file.name;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        cancelBtn.classList.remove('hidden'); // tampilkan tombol batal
                    };
                    reader.readAsDataURL(file);
                } else {
                    resetUpload();
                }
            });

            // Event tombol batal
            cancelBtn.addEventListener('click', resetUpload);
        });
    </script>



</body>

</html>
