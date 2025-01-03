<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\GetCompanyController;
use App\Http\Controllers\Api\MachineLicenseController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TaxLicenseController;
use App\Http\Controllers\Api\LicenseActivationLogController;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/users', [AuthController::class, 'users']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {

//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });

Route::middleware('api')->group(function () {
    //Authentication routes
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('test', [AuthController::class, 'test']);
        Route::post('profile', [AuthController::class, 'profile']);
    });

    //! Download files
    Route::controller(DownloadController::class)->group(function () {
        Route::get('download', 'index');
        Route::get('download/me', 'me');
        Route::post('download', 'store');
        Route::get('download/{id}', 'show');
        Route::put('download/{id}', 'update');
        Route::delete('download/{id}', 'destroy');
    });

    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
    Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']);
    Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']);
    Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy']);

    // Subscriptions with admin middleware
    Route::middleware('admin')->group(function () {
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);
        Route::put('/subscriptions/{id}', [SubscriptionController::class, 'update']);
        Route::delete('/subscriptions/{id}', [SubscriptionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'license'], function () {
        // Machine License Routes
        Route::get('/machine/user', [MachineLicenseController::class, 'getUserMachineLicenses']);
        Route::post('/machine/create', [MachineLicenseController::class, 'create']);
        Route::post('/machine/verify', [MachineLicenseController::class, 'verify']);
        Route::post('/machine/status', [MachineLicenseController::class, 'checkActivationStatus']);

        // Tax License Routes
        Route::post('/tax/add', [TaxLicenseController::class, 'addTaxLicense']);
        Route::post('/tax/activate', [TaxLicenseController::class, 'activateTaxLicense']);
        Route::post('/tax/deactivate', [TaxLicenseController::class, 'deactivateTaxLicense']);
        Route::post('/tax/info', [TaxLicenseController::class, 'checkTaxCodeStatus']);

        // Activation Logs Routes
        Route::get('/logs', [LicenseActivationLogController::class, 'getActivationLogs']);
    });
});
//! Get Company Tax Code
Route::get('/get-company-tax-code', [GetCompanyController::class, 'getCompanyTaxCode']); //? TaxCode={mstCompany}
