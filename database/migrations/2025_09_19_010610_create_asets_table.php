<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel asets
     */
    public function up(): void
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            
            // Nama Aset - teks max 64 karakter
            $table->string('nama_aset', 64); 
            
            // Jenis Aset - dibatasi pilihan (enum)
            $table->enum('jenis_aset', ['Furnitur', 'Elektronik', 'Dekorasi', 'Lainnya']);
            
            // Kode Aset - string unik (contoh: F-KU, E-KA)
            $table->string('kode_aset')->unique();
            
            // Foto Aset - nama file saja, bisa null kalau pakai placeholder
            $table->string('foto_aset')->nullable();
            
            // created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration (hapus tabel)
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
