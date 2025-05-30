<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VitroBlocksController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\OrigenController;
use App\Http\Controllers\ProductoController;

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
/*Route::get('/VitroBlocks/index', function () {
    return view('vitroblocks.index');
});*/

Route::resource('VitroBlocks', VitroBlocksController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('origenes', OrigenController::class);
Route::resource('productos', ProductoController::class);


/*Route::get('/VitroBlocks/index', [VitroBlocksController::class, 'index']); // ver listado
Route::get('/VitroBlocks/create', [VitroBlocksController::class, 'create']); // formulario crear
Route::get('/VitroBlocks/edit', [VitroBlocksController::class, 'edit']); // formulario editar
Route::post('/VitroBlocks', [VitroBlocksController::class, 'store'])->name('VitroBlocks.store'); // guardar
*/



Route::get('/', function () { 
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
