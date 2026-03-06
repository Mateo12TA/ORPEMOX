<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PruductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// RUTAS PROTEGIDAS
Route::middleware(['auth', 'verified'])->group(function () {

    // PERFIL Y CONFIGURACIÓN
    Route::controller(PerfilController::class)->group(function () {
        Route::get('mi-perfil', 'index')->name('usuario.perfil');
        Route::post('actualizar-foto-perfil', 'actualizarIMG')->name('perfil.actualizarIMG');
        Route::delete('perfil/eliminar-foto', 'eliminarFotoPerfil')->name('perfil.eliminarFotoPerfil');
        Route::get('actualizar-datos-perfil', 'actualizarDatos')->name('perfil.actualizarDatos');
        Route::get('cambiar-clave', 'cambiarClave')->name('usuario.cambiarClave');
        Route::post('actualizar-clave', 'actualizarClave')->name('usuario.actualizarClave');
    });

    // EMPRESA
    Route::controller(EmpresaController::class)->group(function () {
        Route::get('empresa-index', 'index')->name('empresa.index');
        Route::post('empresa-update-{id}', 'update')->name('empresa.update');
        Route::post('actualizar-logo', 'actualizarLogo')->name('empresa.actualizarLogo');
        Route::delete('eliminar-logo', 'eliminarLogo')->name('empresa.eliminarLogo');
    });

    // PRODUCTOS
    Route::resource('productos', PruductoController::class);
    Route::controller(PruductoController::class)->group(function () {
        Route::post("buscar-producto", "buscarProducto")->name("producto.buscar");
        Route::post("registrar-foto-producto", "registrarFotoProducto")->name("producto.registrarFotoProducto");
        Route::get("eliminar-foto-producto-{id}", "eliminarFotoProducto")->name("producto.eliminarFoto");
    });

    // CATEGORÍAS
    Route::resource('categoria', CategoriaController::class);

    // USUARIOS
    Route::resource('usuario', UsuarioController::class);
    Route::controller(UsuarioController::class)->group(function () {
    Route::post("registrar-foto-usuario", "registrarFotoUsuario")->name("usuario.registrarFotoUsuario");
    Route::delete("eliminar-foto-usuario", "eliminarFotoUsuario")->name("usuario.eliminarFotoUsuario");
});

});