<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table = 'asets';

    protected $fillable = [
        'nama_aset',
        'tipe_aset',
        'kode_aset',
        'foto_aset',
    ];
}
