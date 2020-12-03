<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'guest:jwt',
    'prefix' => 'auth'
], function ($router) {

    Route::get('login', [AuthController::class, 'login'])->name('api.login');
    Route::get('refresh', [AuthController::class, 'refresh'])->name('api.refresh');
});

Route::group([
    'middleware' => 'jwt:api',
    'prefix' => 'auth'
], function ($router) {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.logout');
});
