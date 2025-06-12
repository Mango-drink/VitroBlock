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
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

// ----------------------------------------
// Rutas para clientes (solo visualizar)
// ----------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'indexCliente'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
});

// ----------------------------------------
// Rutas para administradores (CRUD completo)
// ----------------------------------------
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Listado admin
    Route::get('dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('dashboard');

    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('origenes', OrigenController::class)->parameters([
        'origenes' => 'origen'
    ]);
    Route::resource('roles', RolController::class)->parameters([
        'roles' => 'rol'
    ]);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('operacion', OperacionController::class);
});

// ----------------------------------------
// Página de bienvenida (pública)
// ----------------------------------------
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->rol_id === 1) {
            // Es admin
            return redirect()->route('admin.dashboard');
        } else {
            // Es cliente o cualquier otro rol
            return redirect()->route('productos.index');
        }
    }
    // Landing page para visitantes no autenticados
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ----------------------------------------
// Perfil de usuario
// ----------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
