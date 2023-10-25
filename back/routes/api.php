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
//numeracionDePedidos
Route::get('/numeracionDePedidos',[\App\Http\Controllers\QueryController::class,'numeracionDePedidos']);
//Route::post('upload/{id}/{option}', [\App\Http\Controllers\UploadController::class, 'upload']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/me', [\App\Http\Controllers\UserController::class, 'me']);
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('empresas', \App\Http\Controllers\EmpresaController::class);
    Route::post('empresaCredibilidad', [\App\Http\Controllers\EmpresaController::class, 'empresaCredibilidad']);
    Route::post('createEmpresaTotal', [\App\Http\Controllers\EmpresaController::class, 'createEmpresaTotal']);

    Route::delete('eliminarEmpresasSinPedidos', [\App\Http\Controllers\EmpresaController::class, 'eliminarEmpresasSinPedidos']);
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
    Route::resource('pagos', \App\Http\Controllers\PagoController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('textCantidad', \App\Http\Controllers\TextCantidadController::class);
    Route::get('cantidad/{nombreProducto}/{gr}/{tamano}', [\App\Http\Controllers\ProductoSinPliegoController::class, 'cantidad']);
    //precio
    Route::get('precio/{nombreProducto}/{gr}/{tamano}/{cantidad}', [\App\Http\Controllers\ProductoSinPliegoController::class, 'precio']);
    Route::resource('textDiseno', \App\Http\Controllers\TextDisenoController::class);
//    disenoNombre
    Route::get('disenoNombre', [\App\Http\Controllers\TextDisenoController::class, 'disenoNombre']);
//    precioDiseno
    Route::get('precioDiseno/{disenoNombre}/{lado}', [\App\Http\Controllers\TextDisenoController::class, 'precioDiseno']);
    Route::resource('textGr', \App\Http\Controllers\TextGrController::class);
    Route::get('gr/{nombreProducto}', [\App\Http\Controllers\ProductoSinPliegoController::class, 'gr']);
    Route::resource('textLado', \App\Http\Controllers\TextLadoController::class);
    Route::resource('textMedida', \App\Http\Controllers\TextMedidaController::class);
    Route::get('tamano/{nombreProducto}/{gr}', [\App\Http\Controllers\ProductoSinPliegoController::class, 'tamano']);
    Route::resource('textProducto', \App\Http\Controllers\TextProductoController::class);
    Route::get('productos', [\App\Http\Controllers\ProductoSinPliegoController::class, 'productos']);
    Route::resource('textTerminacion', \App\Http\Controllers\TextTerminacionController::class);
    Route::resource('conPliegos', \App\Http\Controllers\ProductoConPliegoController::class);
    Route::resource('sinPliegos', \App\Http\Controllers\ProductoSinPliegoController::class);
    Route::resource('productoDiseno', \App\Http\Controllers\ProductoDisenoController::class);
    Route::resource('productoTerminaciones', \App\Http\Controllers\ProductoTerminacionController::class);
    Route::post('aceptarEstadoPago', [\App\Http\Controllers\PagoController::class, 'aceptarEstadoPago']);
    Route::post('rechazarEstadoPago', [\App\Http\Controllers\PagoController::class, 'rechazarEstadoPago']);
    Route::get('revisionPedidos', [\App\Http\Controllers\PedidoController::class, 'revisionPedidos']);
    Route::post('rechazarPedido', [\App\Http\Controllers\PedidoController::class, 'rechazarPedido']);
    Route::post('aceptarPedido', [\App\Http\Controllers\PedidoController::class, 'aceptarPedido']);
    Route::get('busquedaPagos', [\App\Http\Controllers\PagoController::class, 'busquedaPagos']);
    Route::post('getNumeroPedido', [\App\Http\Controllers\PedidoController::class, 'getNumeroPedido']);
    Route::post('reportBetween', [\App\Http\Controllers\ReporteController::class, 'reportBetween']);
//    terminacionNombre
    Route::get('terminacionNombre', [\App\Http\Controllers\ProductoTerminacionController::class, 'terminacionNombre']);
});
//Route::get('migracion/{tabla}',[\App\Http\Controllers\MigracionController::class,'migracion']);
