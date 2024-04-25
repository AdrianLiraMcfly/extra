<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CanalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemasController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'is_active'])->group(function () {
    Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verification.show');
    Route::post('/verify', [VerificationController::class, 'verify'])->name('verification');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['isadmin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->where('user', '[0-9]+');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->where('user', '[0-9]+');
    });


        
    Route::get('/canales', [CanalesController::class, 'index'])->name('canales.index');
    Route::post('/canales', [CanalesController::class, 'store'])->name('canales.store');
    Route::get('/canales/{canales}/edit', [CanalesController::class, 'edit'])->name('canales.edit');
    Route::put('/canales/{canales}', [CanalesController::class, 'update'])->name('canales.update')->where('canales', '[0-9]+');
    Route::delete('/canales/{canales}', [CanalesController::class, 'destroy'])->name('canales.destroy')->where('canales', '[0-9]+');


    Route::middleware(['canalIsactive'])->group(function () {
        Route::get('/canales/show/{canal}', [TemasController::class, 'show'])->name('canales.show')->where('canal', '[0-9]+');
    });
    Route::post('/canales/tema/{canal}', [TemasController::class, 'store'])->name('tema.store')->where('canal', '[0-9]+');
    
    Route::put('/canales/{canal}/tema/{tema}', [TemasController::class, 'update'])->name('tema.update')->where('tema', '[0-9]+');
    Route::delete('/canales/{canal}/tema/{tema}', [TemasController::class, 'destroy'])->name('tema.destroy')->where('tema', '[0-9]+');

    
    Route::get('/tema/show/{tema}', [ComentariosController::class, 'show'])->name('tema.show')->where('tema', '[0-9]+')->middleware('temasIsactive');
    Route::post('/tema/{tema}/comentario', [ComentariosController::class, 'store'])->name('comentario.store')->where('tema', '[0-9]+');
    Route::put('/tema/{tema}/comentario/{comentario}', [ComentariosController::class, 'update'])->name('comentario.update')->where('comentario', '[0-9]+');
    Route::delete('/tema/{tema}/comentario/{comentario}', [ComentariosController::class, 'destroy'])->name('comentario.destroy')->where('comentario', '[0-9]+');
    
    
    //Route::get('/tema/{tema}/comentarios', [ComentariosController::class, 'getComentarios'])->name('tema.comentarios')->where('tema', '[0-9]+');
    Route::get('/tema/{tema}/comentarios', [ComentariosController::class, 'getComentariosaxios'])->name('tema.comentarios');

});

require __DIR__.'/auth.php';
