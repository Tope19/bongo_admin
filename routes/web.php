<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Ecommerce\UserController;
use App\Http\Controllers\Admin\Ecommerce\OrderController;
use App\Http\Controllers\Admin\Ecommerce\ProductController;
use App\Http\Controllers\Admin\Ecommerce\ProductSizeController;
use App\Http\Controllers\Admin\Logistics\PackageTypeController;
use App\Http\Controllers\Admin\Ecommerce\ProductImageController;
use App\Http\Controllers\Admin\Logistics\PriceSettingController;
use App\Http\Controllers\Admin\Logistics\LogisticOrderController;
use App\Http\Controllers\Admin\Ecommerce\ProductCategoryController;
use App\Http\Controllers\Admin\Ecommerce\TransactionHistoryController;
use App\Http\Controllers\Admin\Logistics\LogisticTransactionHistoryController;


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

Route::get('/', function () {
    return redirect()->route('auth.admin.login');
});
Route::get('/login', [AuthController::class, 'loginView'])->name('auth.admin.login');
Route::post('/login/save', [AuthController::class, 'login'])->name('auth.admin.login.save');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::group(['prefix' => 'dashboard', 'middleware' => 'admin'], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::patch('/orders/{order}/update-status', [DashboardController::class, 'updateOrderStatus'])->name('orders.update.status');


    // Product Routes
     Route::resource('products', ProductController::class);
     Route::resource('categories', ProductCategoryController::class);
     Route::resource('sizes', ProductSizeController::class);
     Route::resource('product-images', ProductImageController::class);
     Route::resource('orders', OrderController::class);
     Route::resource('transactions', TransactionHistoryController::class);
     Route::resource('users', UserController::class);
     Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');


     // Logistics Routes
     Route::resource('logistics', LogisticOrderController::class);
     Route::patch('/logistics/{id}/status', [LogisticOrderController::class, 'updateStatus'])->name('logistics.update.status');
     Route::resource('price-settings', PriceSettingController::class);
     Route::patch('/price-settings', [PriceSettingController::class, 'updateSetting'])->name('price-settings.update');
     Route::resource('package-types', PackageTypeController::class);
     Route::resource('logistic-transactions', LogisticTransactionHistoryController::class);


});






// Route::middleware('role:admin')->group(function () {
//     // Routes only accessible to admins
// });
