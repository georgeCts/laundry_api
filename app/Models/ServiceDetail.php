<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $table = 'services_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'service_catalog_id',
        'quantity'
    ];
    public $timestamps = false;

    public function serviceCatalog()
    {
        return $this->belongsTo(ServiceCatalog::class);
    }
}
