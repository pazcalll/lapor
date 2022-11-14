<?php

use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'v1'
// ], function () {
//     Route::post('login', [AuthController::class, 'login'])->name('login');
// });

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('get-profile', [AuthController::class, 'getProfile'])->name('getProfile');
    Route::get('get-disposable-token', [AuthController::class, 'getDisposableToken'])->name('getDisposableToken');
    Route::get('use-disposable-token/{token}', [AuthController::class, 'useDisposableToken'])->name('useDisposableToken');
    Route::prefix('user')->group(function () {
        Route::get('get-reports', [AuthController::class, 'getReports'])->name('getReports');
    });
});