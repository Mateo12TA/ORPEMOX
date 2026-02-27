<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RecuperarClaveController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PruductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Usuario verificado)
|--------------------------------------------------------------------------
*/

Route::middleware(['verified'])->group(function () {

    // ===============================
    // PERFIL
    // ===============================

    Route::get('mi-perfil', [PerfilController::class, 'index'])
        ->name('usuario.perfil');

    Route::post('actualizar-foto-perfil', [PerfilController::class, 'actualizarIMG'])
        ->name('perfil.actualizarIMG');

    Route::delete('perfil/eliminar-foto', [PerfilController::class, 'eliminarFotoPerfil'])
        ->name('perfil.eliminarFotoPerfil');

    Route::put('actualizar-datos-perfil', [PerfilController::class, 'actualizarDatos'])
        ->name('perfil.actualizarDatos');


    // ===============================
    // EMPRESA
    // ===============================

    Route::get('empresa-index', [EmpresaController::class, 'index'])
        ->name('empresa.index');

    Route::post('empresa-update-{id}', [EmpresaController::class, 'update'])
        ->name('empresa.update');
        Route::post('actualizar-logo', [EmpresaController::class, "actualizarLogo"])
        ->name("empresa.actualizarLogo")->middleware('verified');
        Route::delete('eliminar-logo', [EmpresaController::class, "eliminarLogo"])->name("empresa.eliminarLogo")->middleware('verified');

    // productos
    Route::resource('productos', PruductoController::class)->middleware('verified');
        

});