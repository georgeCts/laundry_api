<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';
    protected $fillable = [
        'user_id',
        'code',
        'discount',
        'special',
        'quantity',
        'active'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
