<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $objService = new Service();
            $objService->user_id = $request->user_id;
            $objService->address = $request->address;
            $objService->reference = $request->reference;
            $objService->express = $request->express;
            $objService->dt_request = now();
            $objService->subtotal = 0;
            $objService->tax = 0;
            $objService->total = 0;
            $objService->save();

            return response()->json(['success_message' => trans('messages.service_store')]);
        } catch (Exception $ex) {
            dd($ex);
            return response()->json(['error_message' => trans('errors.service_store')], 403);
        }
    }

    public function getService($id)
    {
        try {
            $objService = Service::find($id);
            return response()->json($objService);
        } catch (Exception $ex) {
            return response()->json(['error_message' => trans('errors. ')], 403);
        }
    }

    public function getServices($userID)
    {
        try {
            $services = Service::where('user_id', $userID)->orderBy('created_at', 'DESC')->get();
            return response()->json($services);
        } catch (Exception $ex) {
            return response()->json(['error_message' => trans('errors.service_list')], 403);
        }
    }
}
