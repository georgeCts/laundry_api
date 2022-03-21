<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCatalog extends Model
{
    use HasFactory;

    protected $table = 'services_catalog';
    protected $fillable = [
        'name_es',
        'name_en',
        'basic_price',
        'express_price',
        'unit_type_id',
        'active'
    ];

    public function unitType() {
        return $this->belongsTo(UnitType::class);
    }
}
