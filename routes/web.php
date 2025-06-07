<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\OrigenController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OperacionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ----------------------------------------
// Rutas para clientes (solo visualizar)
// ----------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    // Cambiamos a indexCliente para la consulta de productos
    Route::get('/productos', [ProductoController::class, 'indexCliente'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
});

// ----------------------------------------
// Rutas para administradores (CRUD completo)
// ----------------------------------------
Route::middleware(['auth', 'is_admin'])->group(function () {
    // El admin tiene su propio listado con funciones completas
    Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos.index');
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('origenes', OrigenController::class);
    Route::resource('roles', RolController::class)->parameters([
        'roles' => 'rol'
    ]);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('operacion', OperacionController::class);

    // Dashboard para administradores
    Route::get('/admin/dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('admin.dashboard');
});

// ----------------------------------------
// Página de bienvenida (pública)
// ----------------------------------------
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ----------------------------------------
// Dashboard (comentado si no lo usas)
// ----------------------------------------


// ----------------------------------------
// Perfil de usuario
// ----------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
