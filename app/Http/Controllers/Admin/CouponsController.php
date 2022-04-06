<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index() {
        $coupons = Coupon::where('active', true)->get();
        return view('contents.coupons.Index', ['lstCoupons' => $coupons]);
    }
}
