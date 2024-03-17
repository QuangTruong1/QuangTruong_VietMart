<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherVietMart extends Model
{
    use HasFactory;
    protected $table = 'voucher_viet_mart';
    protected $fillable = [
        'program_name',
        'voucher_code',
        'start_date',
        'end_date',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_order_value',
        'usage_limit',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'custom_voucher_pivot', 'user_id', 'voucher_id');
    }
}
