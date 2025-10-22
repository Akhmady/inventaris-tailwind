<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::table('aset_ruangans', function (Blueprint $table) {
             // Drop foreign key lama
             $table->dropForeign(['ruangan_id']);
             $table->dropForeign(['aset_id']);
 
             // Tambahkan ulang dengan cascade delete
             $table->foreign('ruangan_id')
                 ->references('id')
                 ->on('ruangans')
                 ->onDelete('cascade');
 
             $table->foreign('aset_id')
                 ->references('id')
                 ->on('asets')
                 ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aset_ruangans', function (Blueprint $table) {
            $table->dropForeign(['ruangan_id']);
            $table->dropForeign(['aset_id']);

            $table->foreign('ruangan_id')
                ->references('id')
                ->on('ruangans');

            $table->foreign('aset_id')
                ->references('id')
                ->on('asets');

        });
    }
};
