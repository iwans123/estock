<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FirstShopController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecondShopController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('logout-user', function () {
    Auth::logout();
    return redirect('/');
})->name('logout-user');

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard.index');
    Route::get('/dashboard/chart', [DashboardController::class, 'chart']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::controller(ItemController::class)->prefix('item')->middleware('role:admin|toko-1')->group(function () {
        Route::get('', 'index')->name('item.index');
        Route::get('create', 'create')->name('item.create');
        Route::post('store', 'store')->name('item.store');
        Route::get('edit/{id}', 'edit')->name('item.edit');
        Route::post('update/{id}', 'update')->name('item.update');
        Route::get('delete/{id}', 'destroy')->name('item.destroy');
    });
    Route::resource('first-shop', FirstShopController::class);
    Route::resource('second-shop', SecondShopController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::controller(OrderController::class)->prefix('order')->group(function () {
        Route::get('', 'index')->name('order.index');
        Route::post('store', 'store')->name('order.store');
        Route::get('delete/{id}', 'destroy')->name('order.destroy');
    });
});

require __DIR__ . '/auth.php';
