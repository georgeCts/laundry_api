<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $table = 'unit_types';
    protected $fillable = [
        'name',
        'key_es',
        'key_en'
    ];
    public $timestamps = false;
}
