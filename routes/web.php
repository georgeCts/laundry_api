<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\ServicesCatalogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login-panel', [LoginController::class, 'index']);
Route::post('/login-panel', [LoginController::class, 'access'])->name('login-panel');
Route::get('/logout-panel', [LoginController::class, 'logout']);

Route::prefix('panel')->middleware('panel.auth')->group(function() {
    
    //DASHBOARD
    Route::get('/', [PanelController::class, 'index']);

    //CATALOGOS SERVICIOS
    Route::get('servicios-catalogo', [ServicesCatalogController::class, 'index']);
    Route::get('servicios-catalogo/crear', [ServicesCatalogController::class, 'create']);
    Route::post('servicios-catalogo/crear', [ServicesCatalogController::class, 'store'])->name('new-service-catalog');

    Route::get('servicios-catalogo/editar/{id}', [ServicesCatalogController::class, 'edit'])->name('panel.servicios-catalogo.editar');
    Route::put('servicios-catalogo/editar', [ServicesCatalogController::class, 'update'])->name('update-service-catalog');

    Route::get('servicios-catalogo/eliminar/{id}', [ServicesCatalogController::class, 'delete']);
});