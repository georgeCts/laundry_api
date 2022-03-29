<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginAsGuest(Request $request) {
        if(isset($request->is_guest) && $request->is_guest) {
            $objUser = User::where('device_id', $request->device_id)->first();
            if(is_null($objUser)) {
                $uuid = Str::uuid();
                $objUser = new User();
                $objUser->name = "Guest#".$uuid;
                $objUser->last_name = " ";
                $objUser->email = $uuid."@guest.com";
                $objUser->password = bcrypt($uuid);
                $objUser->locale = "es";
                $objUser->is_admin = false;
                $objUser->is_guest = true;
                $objUser->device_id = $request->device_id;
                $objUser->save();
            }
            
            $token = $objUser->createToken($request->device_id)->plainTextToken;

            return response()->json(["user" => $objUser, "token" => $token]);
        } else {
            return response()->json(["message" => "Guest login not available"], 403);
        }
    }

    public function register(Request $request) {
        $objUser = User::where('device_id', $request->device_id)->first();

        if(!$objUser) {
            $objUser = new User();
            $objUser->device_id = $request->device_id;
            $objUser->locale = "es";
        }
        
        $objUser->name = $request->name;
        $objUser->last_name = $request->last_name;
        $objUser->phone_number = $request->phone_number;
        $objUser->email = $request->email;
        $objUser->password = bcrypt($request->password);
        $objUser->is_admin = false;
        $objUser->is_guest = false;
        $objUser->save();

        $token = $objUser->createToken($request->device_id)->plainTextToken;

        return response()->json(["user" => $objUser, "token" => $token]);
    }
}
