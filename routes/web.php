<?php

use App\Http\Controllers\AccessaryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/salesorder/info/{id}', [SalesOrderController::class, 'info'])->name('salesorder.info');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix("customer")->group(function () {
        Route::get('/', [CustomerController::class, 'getList'])->name('customer.list');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/detail/{id}', [CustomerController::class, 'detail'])->name('customer.detail');
        Route::post('/delete', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::post('/getCustomerList', [CustomerController::class, 'getCustomerList'])->name('customer.get_customer_list');
    });

    Route::prefix('product')->group(function() {
        Route::get('/', [ProductController::class, 'list'])->name('product.list');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    });

    Route::prefix('service')->group(function() {
        Route::get('/', [ServiceController::class, 'list'])->name('service.list');
        Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/detail/{id}', [ServiceController::class, 'detail'])->name('service.detail');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    });

    Route::prefix('salesorder')->group(function() {
        Route::get('/', [SalesOrderController::class, 'list'])->name('salesorder.list');
        Route::get('/create', [SalesOrderController::class, 'create'])->name('salesorder.create');
        Route::post('/store', [SalesOrderController::class, 'store'])->name('salesorder.store');
        Route::get('/detail/{id}', [SalesOrderController::class, 'detail'])->name('salesorder.detail');
        Route::post('/getCustomerInfo', [SalesOrderController::class, 'getCustomerInfo'])->name('salesorder.get_customer_info');
        Route::post('/getInventoryList', [SalesOrderController::class, 'getInventoryList'])->name('salesorder.get_inventory_list');
        Route::get('/getPaymentHistory/{id}', [SalesOrderController::class, 'getPaymentHistory'])->name('salesorder.get_payment_history');
    });

    Route::prefix('product_stock')->group(function() {
        Route::get('/', [ProductStockController::class, 'list'])->name('product_stock.list');
        Route::post('/store', [ProductStockController::class, 'store'])->name('product_stock.store');
        Route::post('/getProductInfo', [ProductStockController::class, 'getProductInfo'])->name('product_stock.get_product_info');
    });

    Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'list'])->name('user.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/info', [UserController::class, 'info'])->name('user.info');
        Route::get('/changePassword', [UserController::class, 'changePassword'])->name('user.change_password');
        Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('user.update_password');
        Route::get('/active/{id}', [UserController::class, 'activeAccount'])->name('user.active');
    });

    Route::prefix('employee')->group(function() {
        Route::get('/', [EmployeeController::class, 'list'])->name('employee.list');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/detail/{id}', [EmployeeController::class, 'detail'])->name('employee.detail');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    });

    Route::prefix('appointment')->group(function() {
        Route::get('/', [AppointmentController::class, 'list'])->name('appointment.list');
        Route::post('/store', [AppointmentController::class, 'store'])->name('appointment.store');
    });
});
