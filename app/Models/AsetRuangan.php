<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsetRuangan extends Model
{
    protected $table = 'aset_ruangans';

    protected $fillable = [
        'jumlah',
        'kondisi',
        'kodeAset',
        'ruangan_id',
        'aset_id',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
