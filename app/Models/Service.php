<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'user_id',
        'status',
        'address',
        'reference',
        'express',
        'dt_request',
        'dt_start',
        'dt_finish',
        'canceled',
        'subtotal',
        'tax',
        'total'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
