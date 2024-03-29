<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\RegentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsappController;
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
    // Route::post('register', [UserController::class, 'register'])->name('register');
    // Route::get('get-disposable-token', [UserController::class, 'getDisposableToken'])->name('getDisposableToken');
    // Route::get('use-disposable-token/{token}', [UserController::class, 'useDisposableToken'])->name('useDisposableToken');
    Route::prefix('user')->middleware('jwtauth')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::patch('update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
        Route::get('get-facilities', [UserController::class, 'getFacilities'])->name('getFacilities');
        Route::get('get-profile', [UserController::class, 'getProfile'])->name('getProfile');
        Route::get('get-gender-enum', [UserController::class, 'getGenderEnum'])->name('getGenderEnum');
        Route::get('get-existing-customer-position', [UserController::class, 'getExistingCustomerPosition'])->name('getExistingCustomerPosition');
        Route::prefix('customer')->middleware('customer')->group(function () {
            Route::post('report', [CustomerController::class, 'createReport'])->name('createReport');
            Route::get('reports', [CustomerController::class, 'getReports'])->name('getReports');
            Route::get('unaccepted-reports', [CustomerController::class, 'getUnacceptedReports'])->name('getUnacceptedReports');
            Route::post('feedback', [CustomerController::class, 'createFeedback'])->name('createFeedback');
        });
        Route::prefix('admin')->middleware('admin')->group(function () {
            Route::post('register-customer', [AdminController::class, 'registerCustomer'])->name('registerCustomer');
            Route::post('process-report', [AdminController::class, 'processReport'])->name('processReportAdmin');
            // Route::post('edit-user', [AdminController::class, 'editUser'])->name('adminEditUser');
            Route::post('update-customer', [AdminController::class, 'updateCustomer'])->name('adminUpdateCustomer');
            Route::post('update-opd', [AdminController::class, 'updateOpd'])->name('adminUpdateOpd');
            Route::put('edit-report', [AdminController::class, 'editReport'])->name('adminEditReport');

            Route::get('unaccepted-reports', [AdminController::class, 'getUnacceptedReports'])->name('getUnacceptedReport');
            Route::get('accepted-reports', [AdminController::class, 'getAcceptedReports'])->name('getAcceptedReport');
            Route::get('finished-reports', [AdminController::class, 'getFinishedReports'])->name('getFinishedReport');
            Route::get('finished-reports-excel', [AdminController::class, 'getFinishedReportsExcel'])->name('getFinishedReportExcel');
            Route::get('opds', [AdminController::class, 'getOpds'])->name('getOpds');
            Route::get('non-admin-users', [AdminController::class, 'getNonAdminUsers'])->name('getNonAdminUsers');
            Route::get('enum-user', [AdminController::class, 'getEnumUser'])->name('getEnumUser');
            Route::get('facilities-datatable', [AdminController::class, 'getFacilitiesDatatable'])->name('getFacilitiesDatatable');
            Route::get('summary', [AdminController::class, 'summary'])->name('adminSummary');
            Route::get('yearly-report', [AdminController::class, 'yearlyReport'])->name('yearlyReport');
            Route::put('change-user-status', [AdminController::class, 'changeUserStatus'])->name('changeUserStatus');
            Route::put('change-assignment-opd', [AdminController::class, 'changeAssignmentOpd'])->name('changeAssignmentOpd');
            Route::post('opd', [AdminController::class, 'createOpd'])->name('createOpd');
            Route::post('facility', [AdminController::class, 'createFacility'])->name('createFacility');
            Route::patch('facility', [AdminController::class, 'editFacility'])->name('editFacility');
            Route::delete('facility', [AdminController::class, 'deleteFacility'])->name('deleteFacility');
            Route::patch('reject-report', [AdminController::class, 'rejectReport'])->name('rejectReport');

            // from whatsapp
            Route::post('wa-report', [AdminController::class, 'waStoreReport']);
            Route::get('wa-report/{referral}', [AdminController::class, 'waShowReport']);
        });
        Route::prefix('opd')->middleware('opd')->group(function () {
            Route::post('finish-assignment', [OpdController::class, 'finishAssignment'])->name('finishAssignment');
            Route::get('incoming-assignments', [OpdController::class, 'getIncomingAssignments'])->name('getIncomingAssignments');
            Route::get('finished-assignments', [OpdController::class, 'getFinishedAssignments'])->name('getFinishedAssignments');
        });
        Route::prefix('regent')->middleware('regent')->group(function () {
            Route::get('summary', [RegentController::class, 'summary'])->name('summary');
            Route::get('opds', [RegentController::class, 'getOpds']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Unauthenticated API Routes (Not Safe)
    |--------------------------------------------------------------------------
    |
    | Here lies the unsafe routes where any random person can access with ease.
    | Spam to routes below may affect the data integrity of the database.
    | The only validator is the data existence inside the database.
    |
    */

    Route::prefix('whatsapp')->group(function () {
        Route::post('/', [WhatsappController::class, 'storeReport']);
    });

});
