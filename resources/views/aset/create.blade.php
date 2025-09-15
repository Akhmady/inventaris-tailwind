@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 relative">

        <div class="absolute top-4 right-4">
            <a href="{{ route('aset') }}"
               class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-400 bg-white text-red-800 shadow hover:bg-red-50 focus:outline-hidden focus:bg-red-100 dark:bg-red-800 dark:border-red-700 dark:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                Kembali
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="m12 5 7 7-7 7" />
                </svg>
            </a>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">
            Tambah Aset
        </h2>

      
        <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf


            <div>
                <label for="namaAset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nama Aset
                </label>
                <input type="text" name="namaAset" id="namaAset"
                       class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                       value="{{ old('namaAset') }}" required>
                @error('namaAset')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

          
            <div>
                <label for="tipeRuangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tipe Ruangan
                </label>
                <select name="tipeRuangan" id="tipeRuangan"
                        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                        required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="furnitur">Furnitur</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="dekorasi">Dekorasi</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                @error('tipeRuangan')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div id="tipeLainnyaWrapper" class="hidden">
                <label for="tipeLainnya" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tipe Lainnya
                </label>
                <input type="text" name="tipeLainnya" id="tipeLainnya"
                       class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                       value="{{ old('tipeLainnya') }}">
            </div>

<div>
    <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Upload Foto
    </label>
  
    <div class="mt-2 flex items-center gap-4">
      
        <label for="foto"
               class="cursor-pointer inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
            <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v16h16V4H4zm8 12a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            Pilih Foto
        </label>
  
        <span id="fileName" class="text-sm text-gray-500 dark:text-gray-400">Belum ada file</span>
    </div>
  
    
    <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
    
    @error('foto')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
  
   
    <div class="mt-4">
        <img id="previewImage" src="#" alt="Preview Gambar"
             class="hidden w-48 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
    </div>
  </div>
  

            
            <div>
                <button type="submit"
                        class="w-full py-3 px-4 bg-teal-600 text-white text-sm font-medium rounded-lg shadow hover:bg-teal-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    // Munculkan input "Lainnya"
    document.getElementById('tipeRuangan').addEventListener('change', function () {
        const wrapper = document.getElementById('tipeLainnyaWrapper');
        if (this.value === 'lainnya') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    });

    // Preview gambar upload
    document.getElementById('foto').addEventListener('change', function (event) {
        const preview = document.getElementById('previewImage');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            preview.classList.add('hidden');
        }
    });

    const fileInput = document.getElementById('foto');
  const fileName = document.getElementById('fileName');
  const previewImage = document.getElementById('previewImage');

  fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (file) {
          fileName.textContent = file.name;

          const reader = new FileReader();
          reader.onload = (e) => {
              previewImage.src = e.target.result;
              previewImage.classList.remove('hidden');
          };
          reader.readAsDataURL(file);
      } else {
          fileName.textContent = "Belum ada file";
          previewImage.src = "#";
          previewImage.classList.add('hidden');
      }
  });
</script>
@endsection
