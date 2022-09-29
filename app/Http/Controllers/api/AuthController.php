<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginAsGuest(Request $request)
    {
        if (isset($request->is_guest) && $request->is_guest) {
            $objUser = User::where('device_id', $request->device_id)->first();
            if (is_null($objUser)) {
                $uuid = Str::uuid();
                $objUser = new User();
                $objUser->name = "Guest#" . $uuid;
                $objUser->last_name = " ";
                $objUser->email = $uuid . "@guest.com";
                $objUser->password = bcrypt($uuid);
                $objUser->locale = "es";
                $objUser->is_admin = false;
                $objUser->is_guest = true;
                $objUser->device_id = $request->device_id;
                $objUser->save();

                // Update name with the ID of the record.
                $objUser->name = "Guest#" . $objUser->id;
                $objUser->save();
            }

            $response = (object)[
                "id" => $objUser->id,
                "name" => $objUser->name,
                "last_name" => $objUser->last_name,
                "phone_number" => "",
                "email" => $objUser->email,
                "locale" => $objUser->locale,
                "is_admin" => (bool)$objUser->is_admin,
                "is_guest" => (bool)$objUser->is_guest,
                "device_id" => $objUser->device_id,
                "token" => $objUser->createToken($request->device_id)->plainTextToken
            ];

            return response()->json($response);
        } else {
            return response()->json(["message" => "Guest login not available"], 403);
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $objUser = User::find(Auth::user()->id);
            $token = $objUser->createToken($objUser->device_id)->plainTextToken;

            return response()->json([
                'access_token'  => $token,
                'user'          => $objUser
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $objUser = User::where('device_id', $request->device_id)->first();

        if (!$objUser) {
            $objUser = new User();
            $objUser->device_id = $request->device_id;
            $objUser->locale = "es";
        }

        $objUser->name = $request->name;
        $objUser->last_name = $request->last_name;
        $objUser->phone_number = $request->phone_number;
        $objUser->email = $request->email;
        $objUser->password = bcrypt($request->password);
        $objUser->device_id = $request->device_id;
        $objUser->is_admin = false;
        $objUser->is_guest = false;
        $objUser->save();

        $token = $objUser->createToken($request->device_id)->plainTextToken;

        return response()->json(["user" => $objUser, "token" => $token]);
    }
}
