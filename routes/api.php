<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OfficerController;
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
    Route::get('get-disposable-token', [UserController::class, 'getDisposableToken'])->name('getDisposableToken');
    Route::get('use-disposable-token/{token}', [UserController::class, 'useDisposableToken'])->name('useDisposableToken');
    Route::prefix('user')->middleware('jwtauth')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('get-facilities', [UserController::class, 'getFacilities'])->name('getFacilities');
        Route::get('get-profile', [UserController::class, 'getProfile'])->name('getProfile');
        Route::prefix('customer')->middleware('customer')->group(function () {
            Route::post('report', [CustomerController::class, 'createReport'])->name('createReport');
            Route::get('reports', [CustomerController::class, 'getReports'])->name('getReports');
            Route::get('unaccepted-reports', [CustomerController::class, 'getUnacceptedReports'])->name('getUnacceptedReports');
        });
        Route::prefix('admin')->middleware('admin')->group(function () {
            Route::post('register-customer', [AdminController::class, 'registerCustomer'])->name('registerCustomer');
            Route::post('process-report', [AdminController::class, 'processReport'])->name('processReportAdmin');
            Route::post('edit-user', [AdminController::class, 'editUser'])->name('adminEditUser');

            Route::get('unaccepted-reports', [AdminController::class, 'getUnacceptedReports'])->name('getUnacceptedReport');
            Route::get('accepted-reports', [AdminController::class, 'getAcceptedReports'])->name('getAcceptedReport');
            Route::get('finished-reports', [AdminController::class, 'getFinishedReports'])->name('getFinishedReport');
            Route::get('officers', [AdminController::class, 'getofficers'])->name('getOfficers');
            Route::get('non-admin-users', [AdminController::class, 'getNonAdminUsers'])->name('getNonAdminUsers');
            Route::get('enum-user', [AdminController::class, 'getEnumUser'])->name('getEnumUser');
            Route::get('facilities-datatable', [AdminController::class, 'getFacilitiesDatatable'])->name('getFacilitiesDatatable');
            Route::post('opd', [AdminController::class, 'createOpd'])->name('createOpd');
            Route::post('facility', [AdminController::class, 'createFacility'])->name('createFacility');
            Route::patch('facility', [AdminController::class, 'editFacility'])->name('editFacility');
            Route::delete('facility', [AdminController::class, 'deleteFacility'])->name('deleteFacility');
            Route::patch('reject-report', [AdminController::class, 'rejectReport'])->name('rejectReport');
        });
        Route::prefix('officer')->middleware('officer')->group(function () {
            Route::post('finish-assignment', [OfficerController::class, 'finishAssignment'])->name('finishAssignment');
            Route::get('incoming-assignments', [OfficerController::class, 'getIncomingAssignments'])->name('getIncomingAssignments');
            Route::get('finished-assignments', [OfficerController::class, 'getFinishedAssignments'])->name('getFinishedAssignments');
        });
    });
});