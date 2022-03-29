<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            (Object)[
                "key"   => "IVA",
                "description"   => "Impuesto",
                "value"     => 16,
            ], 
            (Object)[
                "key"   => "SERVICIO_DOMICILIO",
                "description"   => "Servicio a domicilio",
                "value"     => 20,
            ]
        ]);

        foreach($collection as $item) {
            $obj = new Configuration();
            $obj->key           = $item->key;
            $obj->description   = $item->description;
            $obj->value         = $item->value;
            $obj->save();
        }
    }
}
