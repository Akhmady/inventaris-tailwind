<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aset</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-3xl">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Aset</h2>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 relative">

            <!-- Tombol kembali -->
            <div class="absolute top-4 right-4">
                <a href="{{ route('aset.index') }}"
                    class="py-2 px-3 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 hover:bg-red-50 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700">
                    Kembali
                </a>
            </div>

            <form action="{{ route('aset.update', $encryptedId) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aset</label>
                    <input type="text" name="namaAset" value="{{ old('namaAset', $aset->nama_aset) }}" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-teal-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">
                    @error('namaAset')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Aset</label>
                    <select name="tipeAset" id="tipeAset" required
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-teal-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Furnitur"
                            {{ old('tipeAset', $aset->tipe_aset) == 'Furnitur' ? 'selected' : '' }}>
                            Furnitur</option>
                        <option value="Elektronik"
                            {{ old('tipeAset', $aset->tipe_aset) == 'Elektronik' ? 'selected' : '' }}>
                            Elektronik</option>
                        <option value="Dekorasi"
                            {{ old('tipeAset', $aset->tipe_aset) == 'Dekorasi' ? 'selected' : '' }}>
                            Dekorasi</option>
                        <option value="Lainnya"
                            {{ !in_array($aset->tipe_aset, ['Furnitur', 'Elektronik', 'Dekorasi']) ? 'selected' : '' }}>
                            Lainnya</option>
                    </select>
                    @error('tipeAset')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Lainnya -->


                <!-- Kode Aset -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Aset</label>
                    <input type="text" value="{{ $aset->kode_aset }}" disabled
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Aset</label>
                    <div class="flex items-center gap-4 mt-2">
                        <label for="foto"
                            class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50">
                            Pilih Foto
                        </label>
                        <span id="fileName" class="text-sm text-gray-500">Belum ada file baru</span>
                    </div>
                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden">

                    <div class="mt-4 flex gap-6">
                        <!-- Foto lama -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Foto Lama</p>
                            <img src="{{ asset('storage/' . $aset->foto_aset) }}"
                                class="w-40 h-40 object-cover rounded-lg border">
                        </div>
                        <!-- Foto baru preview -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Preview Baru</p>
                            <img id="previewImage" src="#"
                                class="hidden w-40 h-40 object-cover rounded-lg border">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const fileInput = document.getElementById('foto');
            const fileNameEl = document.getElementById('fileName');
            const previewImage = document.getElementById('previewImage');

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    fileNameEl.textContent = file.name;
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        previewImage.src = ev.target.result;
                        previewImage.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileNameEl.textContent = "Belum ada file baru";
                    previewImage.src = "#";
                    previewImage.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>
