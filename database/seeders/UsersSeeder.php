<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objUser = new User();
        $objUser->name      = "Jorge";
        $objUser->last_name = "Cortés";
        $objUser->email     = "admin@email.com";
        $objUser->password  = bcrypt("12345678a");
        $objUser->locale    = "es";
        $objUser->is_admin  = true;
        $objUser->save();
    }
}
