<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuUnitsController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VoucherItemController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        $response = [
            'message' => 'Welcome from WebPos API',
            'developed_by' => 'MMS IT',
            'for' => 'MMS Connections Students',
            'documentation_url' => env('APP_DOC_URL', 'https://mms-it.com'),
        ];

        return response()->json($response);
    });

   
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth:sanctum')->prefix("dashboard")->group(function () {
        Route::controller(ProfileController::class)->prefix('user-profile')->group(function () {
            Route::get('/show', 'show');
            Route::patch('/logout', 'logout');
            Route::patch('/change-password', 'changePassword');
            Route::patch('/change-name', 'changeName');
            Route::patch('/change-photo', 'changePhoto');
        });
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('menus', MenuController::class);
        Route::get('menu-units', [MenuUnitsController::class, 'menuUnits']);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource("photos", PhotoController::class)->only(["store", "destroy"]);
        Route::get('vouchers/export', [VoucherController::class, 'excelExport']);
        Route::get('/voucher-items/export', [VoucherController::class, 'voucherItemExport']);
        Route::apiResource("vouchers", VoucherController::class)->only(["index", "store", "show",]);
        Route::apiResource("banners", BannerController::class);
    });
});
