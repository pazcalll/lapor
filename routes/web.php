<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfficerController;
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
    Route::prefix('customer')->middleware('customer')->group(function () {
        Route::get('/home-page', [CustomerController::class, 'homePage'])->name('customerHomePage');
        Route::get('/report-page', [CustomerController::class, 'reportPage'])->name('customerReportPage');
        Route::get('/report-history-page', [CustomerController::class, 'reportHistoryPage'])->name('customerReportHistoryPage');
    });
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/home-page', [AdminController::class, 'homePage'])->name('adminHomePage');
        Route::get('/process-page', [AdminController::class, 'processPage'])->name('adminProcessPage');
        Route::get('/finished-page', [AdminController::class, 'finishedPage'])->name('adminFinishedPage');
        Route::get('/config-page', [AdminController::class, 'configPage'])->name('adminConfigPage');
        Route::get('/facilities-page', [AdminController::class, 'facilitiesPage'])->name('adminFacilitiesPage');
    });
    Route::prefix('officer')->middleware('officer')->group(function () {
        Route::get('/home-page', [OfficerController::class, 'homePage'])->name('officerHomePage');
        Route::get('/history-page', [OfficerController::class, 'historyPage'])->name('officerHistoryPage');
    });
});