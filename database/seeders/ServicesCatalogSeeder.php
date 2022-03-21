<?php

namespace Database\Seeders;

use App\Models\ServiceCatalog;
use Illuminate\Database\Seeder;

class ServicesCatalogSeeder extends Seeder
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
                "name_es"   => "Ropa",
                "name_en"   => "Clothes",
                "basic"     => 20,
                "express"   => 40,
                "unit"      => 2
            ], 
            (Object)[
                "name_es"   => "Almohadas",
                "name_en"   => "Pillows",
                "basic"     => 10,
                "express"   => 20,
                "unit"      => 1
            ],
            (Object)[
                "name_es"   => "Edredones",
                "name_en"   => "Quilts",
                "basic"     => 15,
                "express"   => 30,
                "unit"      => 1
            ],
            (Object)[
                "name_es"   => "Cojines",
                "name_en"   => "Cushions",
                "basic"     => 12,
                "express"   => 24,
                "unit"      => 1
            ]
        ]);

        foreach($collection as $item) {
            $obj = new ServiceCatalog();
            $obj->name_es       = $item->name_es;
            $obj->name_en       = $item->name_en;
            $obj->basic_price   = $item->basic;
            $obj->express_price = $item->express;
            $obj->unit_type_id  = $item->unit;
            $obj->save();
        }
    }
}
