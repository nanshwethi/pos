<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'voucher_number',
        'date',
        'total',
        'tax',
        'net_total',
        'cash',
        'change',
        'voucher_items_count',
        'user_id',
        'type',
    ];

    protected $with = ['customer', 'user', 'voucherItems'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function voucherItems()
    {
        return $this->hasMany(VoucherItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
