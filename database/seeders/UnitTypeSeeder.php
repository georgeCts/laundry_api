<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
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
                "name"      => "Pieza",
                "key_es"    => "pza.",
                "key_en"    => "pc.",
            ], 
            (Object)[
                "name"      => "Kilogramo",
                "key_es"    => "kg.",
                "key_en"    => "kg.",
            ]
        ]);

        foreach($collection as $item) {
            $obj = new UnitType();
            $obj->name     = $item->name;
            $obj->key_es   = $item->key_es;
            $obj->key_en   = $item->key_en;
            $obj->save();
        }
    }
}
