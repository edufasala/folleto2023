<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
//Route::post('upload/{id}/{option}', [\App\Http\Controllers\UploadController::class, 'upload']);
Route::group(['middleware'=>'auth:sanctum'],function () {
    Route::post('/me', [\App\Http\Controllers\UserController::class, 'me']);
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('empresas', \App\Http\Controllers\EmpresaController::class);
    Route::get('updateActive/{user}',[ \App\Http\Controllers\UserController::class,'updateActive']);
    Route::put('updatePassword/{user}',[ \App\Http\Controllers\UserController::class,'updatePassword']);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::resource('phones', \App\Http\Controllers\PhoneController::class);
    Route::resource('emails', \App\Http\Controllers\EmailController::class);
    Route::resource('persons', \App\Http\Controllers\PersonController::class);
    Route::resource('sucursal', \App\Http\Controllers\SucursalController::class);
    Route::resource('direccion', \App\Http\Controllers\DireccionController::class);
    Route::resource('phoneDireccions', \App\Http\Controllers\PhoneDireccionsController::class);
    Route::resource('facturacion', \App\Http\Controllers\FacturacionController::class);
    Route::resource('notes', \App\Http\Controllers\NoteController::class);
    Route::resource('pedidos', \App\Http\Controllers\PedidoController::class);
    Route::post('getNumeroPedido', [\App\Http\Controllers\PedidoController::class, 'getNumeroPedido']);
    Route::post('reportBetween', [\App\Http\Controllers\ReporteController::class, 'reportBetween']);
});
