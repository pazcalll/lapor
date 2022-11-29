<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
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
//     Route::post('login', [UserController::class, 'login'])->name('login');
// });

Route::prefix('v1')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');
    Route::get('get-profile', [UserController::class, 'getProfile'])->name('getProfile');
    Route::get('get-disposable-token', [UserController::class, 'getDisposableToken'])->name('getDisposableToken');
    Route::get('use-disposable-token/{token}', [UserController::class, 'useDisposableToken'])->name('useDisposableToken');
    Route::prefix('user')->middleware('jwtauth')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('get-facilities', [UserController::class, 'getFacilities'])->name('getFacilities');
        Route::prefix('customer')->middleware('customer')->group(function () {
            Route::post('report', [CustomerController::class, 'createReport'])->name('createReport');
            Route::get('reports', [CustomerController::class, 'getReports'])->name('getReports');
        });
        Route::prefix('admin')->middleware('admin')->group(function () {
            Route::get('unaccepted-reports', [AdminController::class, 'getUnacceptedReports'])->name('getUnacceptedReport');
        });
    });
});