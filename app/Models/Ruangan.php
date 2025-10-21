<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';

    protected $fillable = [
        'nama_ruangan',
        'deskripsi_ruangan',
        'penanggung_jawab',
    ];

    /**
     * Relasi ke tabel aset_ruangans
     */
    public function asetRuangans()
    {
        return $this->hasMany(AsetRuangan::class, 'ruangan_id');
    }

    /**
     * Event lifecycle untuk menangani cascade dan logging
     */
    protected static function booted()
{
    static::deleting(function ($asetRuangan) {
        // $namaAset = optional($asetRuangan->aset)->nama_aset ?? '(tidak diketahui)';

        // \App\Models\ActivityLog::record(
        //     'delete',
        //     'AsetRuangan',
        //     "Menghapus aset {$namaAset} dari ruangan ID {$asetRuangan->ruangan_id}."
        // );
    });
}


}
