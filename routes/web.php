<?php

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

Route::middleware('jwtnoauth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/login', [UserController::class, 'authPage'])->name('authPage');
    Route::get('/login-page', [UserController::class, 'loginPage'])->name('loginPage');
    Route::get('/register-page', [UserController::class, 'registerPage'])->name('registerPage');
});
Route::middleware('jwtauth')->group(function () {
    Route::get('/indexPage', [UserController::class, 'loggedInPage'])->name('indexPage');
});