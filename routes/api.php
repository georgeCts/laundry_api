<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/order/{id}', [OrdersController::class, 'getOrder']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login/guest', [AuthController::class, 'loginAsGuest']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
