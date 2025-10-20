<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'entity',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper universal untuk merekam aktivitas
    public static function record($action, $entity, $description)
    {
        self::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'action'  => $action,
            'entity'  => $entity,
            'description' => $description,
        ]);
    }
    
    
}
