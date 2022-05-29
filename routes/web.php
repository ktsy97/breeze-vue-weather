<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [App\Http\Controllers\WeatherController::class, 'index'])->middleware(['auth'])->name('city.list');
Route::post('/', [App\Http\Controllers\WeatherController::class, 'select'])->middleware(['auth'])->name('city.select');
Route::get('/city/{city_id}', [App\Http\Controllers\WeatherController::class, 'show'])->middleware(['auth'])->name('city.show');
Route::post('/city/fav', [App\Http\Controllers\FavoriteController::class, 'fav'])->middleware(['auth'])->name('city.fav');

Route::get('/user', [App\Http\Controllers\UserController::class, 'show'])->middleware(['auth'])->name('user.show');
Route::post('/user/{user}', [App\Http\Controllers\UserController::class, 'update'])->middleware(['auth'])->name('user.update');
Route::delete('/user/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware(['auth'])->name('user.destroy');

require __DIR__ . '/auth.php';
