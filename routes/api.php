<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlayerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AdminController::class)->group(function () {
    Route::post('admin/login', 'login')->name('user.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('admin/logout', 'logout');
        Route::post('admin/addPlayer', 'addPlayer');
        Route::post('admin/addTeam', 'addTeam');
    });
});


Route::controller(TeamController::class)->group(function () {
    Route::post('team/login', 'login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('team/logout', 'logout');
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('player/info/{id}', [PlayerController::class, 'getPlayerInfo']);
    Route::post('player/bid', [PlayerController::class, 'placeBid']);
    Route::post('player/skip', [PlayerController::class, 'skipPlayer']);
});
