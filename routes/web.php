<?php

use App\Http\Controllers\Admin\LicenseManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DownloadHistoryController;
use App\Http\Controllers\DownloadLimitController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\UserController;
use App\Models\DownloadLimit;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
})->name('home');
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', [UserController::class, 'about'])->name('about');

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'userprofile'])->name('profile');
});

//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');
    Route::get('/admin/users', [UserController::class, 'userList'])->name('admin/users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin/users/create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin/users/store');
    Route::get('/admin/users/show/{id}', [UserController::class, 'show'])->name('admin/users/show');
    Route::get('/admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin/users/edit');
    Route::put('/admin/users/edit/{id}', [UserController::class, 'update'])->name('admin/users/update');
    Route::delete('/admin/users/destroy/{id}', [UserController::class, 'destroy'])->name('admin/users/destroy');
    /// download list routes
    Route::get('/admin/downloadlimits', [DownloadLimitController::class, 'listAccountsAndDownloads'])->name('admin/downloadlimits');
    Route::get('/admin/downloadlimits/create', [DownloadLimitController::class, 'create'])->name('admin/downloadlimits/create');
    Route::post('/admin/downloadlimits/store', [DownloadLimitController::class, 'storeDownload'])->name('admin/downloadlimits/store');
    Route::get('/admin/downloadlimits/show/{id}', [DownloadLimitController::class, 'show'])->name('admin/downloadlimits/show');
    Route::get('/admin/downloadlimits/edit/{id}', [DownloadLimitController::class, 'edit'])->name('admin/downloadlimits/edit');
    Route::put('/admin/downloadlimits/edit/{id}', [DownloadLimitController::class, 'update'])->name('admin/downloadlimits/update');
    Route::delete('/admin/downloadlimits/destroy/{id}', [DownloadLimitController::class, 'destroy'])->name('admin/downloadlimits/destroy');

    // lịch sử  downloads
    Route::get('/admin/downloads/show/{id}', [DownloadHistoryController::class, 'show'])->name('admin/downloads/show');
    // quản lý bản quyền
    // Quản lý License Máy
    Route::prefix('admin/licenses')->name('admin.licenses.')->group(function () {
        // Machine Licenses
        Route::controller(LicenseManagementController::class)->group(function () {
            Route::get('/machines', 'indexMachineLicenses')->name('machines.index');
            Route::get('/machines/create', 'createMachineLicense')->name('machines.create');
            Route::post('/machines', 'storeMachineLicense')->name('machines.store');
            Route::get('/machines/{id}', 'showMachineLicense')->name('machines.show');
            Route::get('/machines/{id}/edit', 'editMachineLicense')->name('machines.edit');
            Route::patch('/machines/{id}', 'updateMachineLicense')->name('machines.update');
        });

        //Tax Licenses
        Route::controller(LicenseManagementController::class)->group(function () {
            Route::get('/tax', 'indexTaxLicenses')->name('tax.index');
            Route::get('/tax/create/{machineId?}', 'createTaxLicense')->name('tax.create');
            Route::post('/tax', 'storeTaxLicense')->name('tax.store');
            Route::get('/tax/{id}', 'showTaxLicense')->name('tax.show');
            Route::get('/tax/{id}/edit', 'editTaxLicense')->name('tax.edit');
            Route::patch('/tax/{id}', 'updateTaxLicense')->name('tax.update');
            Route::delete('/tax/{id}', 'destroyTaxLicense')->name('tax.destroy');
        });

        // Cập nhật trạng thái
        Route::patch('/status/{type}/{id}', [LicenseManagementController::class, 'updateLicenseStatus'])
            ->name('status');

        Route::patch('/active/{type}/{id}', [LicenseManagementController::class, 'updateLicenseActiveTaxCode'])
            ->name('active');
    });
});
