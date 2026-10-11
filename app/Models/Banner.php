<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory;

    protected $fillable = [
        'image',
        'is_available',
        'user_id',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
