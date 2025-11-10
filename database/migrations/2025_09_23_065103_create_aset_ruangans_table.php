<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aset_ruangans', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah');
            $table->enum('kondisi',['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->string('kode_aset');
            $table->foreignId('ruangan_id')->references('id')->on('ruangans');
            $table->foreignId('aset_id')->references('id')->on('asets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_ruangans');
    }
};
