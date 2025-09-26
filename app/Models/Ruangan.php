<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangans';

    protected $fillable = [
        'nama_ruangan',
        'deskripsi_ruangan',
        'penanggung_jawab',
    ];

    public function asetRuangan(){
        return $this->hasMany(AsetRuangan::class);
    }
}
