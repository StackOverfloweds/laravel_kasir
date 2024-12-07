<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PengeluaranBelanjaController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\SalesTransactionController;


Route::prefix('auth')->group(function () {
    // Rute login
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Rute register
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::patch('register/{id}', [RegisterController::class, 'update'])->name('update');
    Route::delete('register/{id}', [RegisterController::class, 'deleteUser'])->name('delete');



    // Rute logout
    Route::delete('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::get('/admin/users', [UserController::class, 'index'])->name('users.store');  // Menambahkan user baru

Route::prefix('admin')->group(function () {
    // Manajemen User
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show'); // Menampilkan detail user

    // Manajemen Menu
    Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store');  // Menambahkan menu baru
    Route::get('menus/{id}', [MenuController::class, 'show'])->name('menus.show'); // Menampilkan detail menu
    Route::patch('menus/{id}', [MenuController::class, 'update'])->name('menus.update'); // Mengupdate menu
    Route::delete('menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy'); // Menghapus menu

    // Manajemen Laporan Penjualan
    Route::post('sales-reports', [SalesReportController::class, 'store'])->name('sales-reports.store');  // Menambahkan laporan penjualan
    Route::get('sales-reports/{id}', [SalesReportController::class, 'show'])->name('sales-reports.show'); // Menampilkan laporan penjualan
    Route::patch('sales-reports/{id}', [SalesReportController::class, 'update'])->name('sales-reports.update'); // Mengupdate laporan penjualan
    Route::delete('sales-reports/{id}', [SalesReportController::class, 'destroy'])->name('sales-reports.destroy'); // Menghapus laporan penjualan

    // Manajemen Transaksi Penjualan
    Route::post('sales-transactions', [SalesTransactionController::class, 'store'])->name('sales-transactions.store');  // Menambahkan transaksi penjualan
    Route::get('sales-transactions/{id}', [SalesTransactionController::class, 'show'])->name('sales-transactions.show'); // Menampilkan transaksi penjualan
    Route::patch('sales-transactions/{id}', [SalesTransactionController::class, 'update'])->name('sales-transactions.update'); // Mengupdate transaksi penjualan
    Route::delete('sales-transactions/{id}', [SalesTransactionController::class, 'destroy'])->name('sales-transactions.destroy'); // Menghapus transaksi penjualan

    Route::prefix('pengeluaran-belanja')->group(function () {
        Route::get('/', [PengeluaranBelanjaController::class, 'index']); // Get all expenses
        Route::post('/', [PengeluaranBelanjaController::class, 'store']); // Add a new expense
        Route::get('{id}', [PengeluaranBelanjaController::class, 'show']); // Get a specific expense
        Route::put('{id}', [PengeluaranBelanjaController::class, 'update']); // Update an expense
        Route::delete('{id}', [PengeluaranBelanjaController::class, 'destroy']); // Delete an expense
    });
});