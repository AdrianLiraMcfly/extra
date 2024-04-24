<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CanalesController;
use App\Http\Controllers\TemasController;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/canales', [CanalesController::class, 'index'])->name('canales.index');
    Route::post('/canales', [CanalesController::class, 'store'])->name('canales.store');
    Route::get('/canales/{canales}/edit', [CanalesController::class, 'edit'])->name('canales.edit');
    Route::put('/canales/{canales}', [CanalesController::class, 'update'])->name('canales.update');
    Route::delete('/canales/{canales}', [CanalesController::class, 'destroy'])->name('canales.destroy');

    Route::get('/canales/show/{canal}', [TemasController::class, 'show'])->name('canales.show');
    Route::post('/canales/{canal}/tema', [TemasController::class, 'store'])->name('tema.store');
    Route::put('/canales/{canal}/tema/{tema}', [TemasController::class, 'update'])->name('tema.update');
    Route::delete('/canales/{canal}/tema/{tema}', [TemasController::class, 'destroy'])->name('tema.destroy');
});

require __DIR__.'/auth.php';
