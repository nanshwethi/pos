<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherItem extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherItemFactory> */
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'menu_id',
        'menu',
        'price',
        'quantity',
        'cost',
        'user_id',
    ];

    protected $casts = [
        'menu' => 'array',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
