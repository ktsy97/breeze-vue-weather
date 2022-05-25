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

Route::get('/', [App\Http\Controllers\WeatherController::class, 'index'])->middleware(['auth', 'verified'])->name('city.list');
Route::post('/', [App\Http\Controllers\WeatherController::class, 'index'])->name('city.select');
Route::get('/city/{city_id}', [App\Http\Controllers\WeatherController::class, 'show'])->middleware(['auth', 'verified'])->name('city.show');
Route::post('/city/fav', [App\Http\Controllers\FavoriteController::class, 'fav'])->name('city.fav');

require __DIR__.'/auth.php';
