<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function getOrder($id) {
        $data = (Object)[
            "id"        => 539,
            "status"    => "PICKING_UP",
            "arrival"   => "2022-02-28",
            "placed"    => null,
            "address"   => "23A #281, Col. La Florida, C.P, 97138",
            "details"   => [
                (Object)["id" => 1, "quantity" => 1, "description" => "Ropa", "total" => 30.0],
                (Object)["id" => 1, "quantity" => 5, "description" => "Toallas", "total" => 40.00],
                (Object)["id" => 1, "quantity" => 3, "description" => "Almohadas", "total" => 18.0],
                (Object)["id" => 1, "quantity" => 1, "description" => "Tenis", "total" => 20.0]
            ]
        ];

        return response()->json($data);
    }
}
