<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\AdminPurchaseOrderController;
use App\Http\Controllers\POSMRequestController;
use App\Http\Controllers\VendorShipmentController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\UserController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/reset-password', [PasswordResetController::class, 'resetToDefault'])->name('password.reset');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Password Change Routes
    Route::get('/change-password', [PasswordResetController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');

    // User Management Routes (Admin only)
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Vendor Shipping Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/vendor/shipping', [VendorShipmentController::class, 'index'])->name('vendor.shipping');
        Route::get('/vendor/shipping/data', [VendorShipmentController::class, 'getData'])->name('vendor.getData');
        Route::get('/vendor/shipping/{id}', [VendorShipmentController::class, 'show'])->name('vendor.show');
        Route::post('/vendor/shipping', [VendorShipmentController::class, 'store'])->name('vendor.store');
        Route::get('/vendor/shipping/{id}/print', [VendorShipmentController::class, 'print'])->name('vendor.print');
    });
    
    // Purchase Order Routes - Admin
    Route::get('/matpro-receipts/list', [AdminPurchaseOrderController::class, 'getMatproReceipts'])->name('matpro-receipts.list');
    Route::get('/vendor-shipments/list', [AdminPurchaseOrderController::class, 'getVendorShipments'])->name('vendor-shipments.list');
    Route::resource('purchase-orders', AdminPurchaseOrderController::class);
    
    // POSM Request Routes - Markom Branch
    Route::get('/posm-requests/upload-form', [POSMRequestController::class, 'showUploadForm'])->name('posm-requests.upload');
    Route::post('/posm-receipts/store', [POSMRequestController::class, 'storeReceipt'])->name('posm-receipts.store');
    Route::delete('/posm-receipts/{id}', [POSMRequestController::class, 'deleteReceipt'])->name('posm-receipts.delete');
    Route::resource('posm-requests', POSMRequestController::class);
    
    // Designer Routes
    Route::prefix('designer')->name('designer.')->group(function () {
        Route::get('/', [DesignerController::class, 'index'])->name('index');
        Route::get('/requests/{id}', [DesignerController::class, 'show'])->name('requests.show');
        Route::post('/requests/{id}/approval', [DesignerController::class, 'updateApproval'])->name('requests.approval');
        Route::post('/requests/{id}/production', [DesignerController::class, 'updateProductionStatus'])->name('requests.production');
        Route::get('/vendor-shipments', [DesignerController::class, 'vendorShipments'])->name('vendor-shipments');
        Route::get('/vendor-shipments/{id}', [DesignerController::class, 'getVendorShipmentDetail'])->name('vendor-shipments.detail');
    });
});
