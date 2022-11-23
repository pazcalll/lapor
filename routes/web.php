<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'index'])->name('index');
Route::middleware('jwtnoauth')->group(function () {
    Route::get('/login', [UserController::class, 'authPage'])->name('authPage');
    Route::get('/login-page', [UserController::class, 'loginPage'])->name('loginPage');
    Route::get('/register-page', [UserController::class, 'registerPage'])->name('registerPage');
});
Route::middleware('jwtauth')->group(function () {
    Route::get('/authenticator', [UserController::class, 'authenticator'])->name('authenticator');
    Route::middleware('customer')->group(function () {
        Route::get('/index-customer', [CustomerController::class, 'indexCustomer'])->name('indexPage'); // unused
        Route::get('report-page', [CustomerController::class, 'reportPage'])->name('reportPage');
    });
});