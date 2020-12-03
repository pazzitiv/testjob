<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Route::group([
    'middleware' => 'web',
    'prefix' => 'auth'
], function ($router) {
    Route::get('/login', [App\Http\Controllers\Web\AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [App\Http\Controllers\Web\AuthController::class, 'register'])->name('auth.register');
    Route::get('/remember', [App\Http\Controllers\Web\AuthController::class, 'remember'])->name('auth.remember');
    Route::get('/logout', [App\Http\Controllers\Web\AuthController::class, 'logout'])->name('auth.logout');

});
