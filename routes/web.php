<?php

use App\Http\Controllers\PriceController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('register_user', [\App\Http\Controllers\HomeController::class, 'register']);
Route::post('store_register_user', [\App\Http\Controllers\HomeController::class, 'store_register']);
Route::get('/verification', [\App\Http\Controllers\HomeController::class, 'verification']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::group(['middleware' => 'level:1'], function () {
        // permission
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::delete('permissions_mass_destroy', [\App\Http\Controllers\Admin\PermissionController::class, 'massDestroy'])->name('permissions.mass_destroy');
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::delete('roles_mass_destroy', [\App\Http\Controllers\Admin\RoleController::class, 'massDestroy'])->name('roles.mass_destroy');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::delete('users_mass_destroy', [\App\Http\Controllers\Admin\UserController::class, 'massDestroy'])->name('users.mass_destroy');
    });

    Route::group(['middleware' => 'level:2'], function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::delete('categories_mass_destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'massDestroy'])->name('categories.mass_destroy');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::delete('products_mass_destroy', [\App\Http\Controllers\Admin\ProductController::class, 'massDestroy'])->name('products.mass_destroy');
        Route::post('products/search', [\App\Http\Controllers\Admin\ProductController::class, 'search'])->name('products.search');
        Route::resource('varieties', \App\Http\Controllers\Admin\VarietyController::class);
        Route::resource('prices', \App\Http\Controllers\Admin\PriceController::class);
        Route::resource('stocks', \App\Http\Controllers\Admin\StockController::class);
        Route::resource('statuses', \App\Http\Controllers\Admin\StatusController::class);
        Route::resource('gabungan', \App\Http\Controllers\Admin\GabunganController::class);
        Route::resource('histories', \App\Http\Controllers\Admin\StocksHistoriesController::class);

        //route import-export
        Route::post('/gabungan/export', [\App\Http\Controllers\Admin\GabunganController::class, 'export'])->name('gabungan.export');
        Route::post('/gabungan/importUpdate', [\App\Http\Controllers\Admin\GabunganController::class, 'importUpdate'])->name('gabungan.importUpdate');
        // Route::get('/update-excel', [\App\Http\Controllers\Admin\GabunganController::class, 'showUpdateExcelForm'])->name('update-excel-form');
        // Route::post('/update-excel', [\App\Http\Controllers\Admin\GabunganController::class, 'updateExcel'])->name('update-excel');

        Route::resource('transaksis', \App\Http\Controllers\TransaksiController::class);
        Route::get('transaksis', [\App\Http\Controllers\TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('transaksis/import', [\App\Http\Controllers\TransaksiController::class, 'import'])->name('transaksis.import');
        Route::get('ringkasan', [\App\Http\Controllers\TransaksiController::class, 'ringkasan'])->name('transaksi.ringkasan');
        Route::get('penghasilan', [\App\Http\Controllers\TransaksiController::class, 'penghasilan'])->name('transaksis.penghasilan');

        // report
        Route::get('reports/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('reports.revenue');

        Route::get('laporan', [\App\Http\Controllers\TransaksiController::class, 'laporan'])->name('transaksis.laporan');

        //export laporan
        Route::post('export_laporan', [\App\Http\Controllers\LaporanController::class, 'export_laporan'])->name('laporan.export');
    });
});

Auth::routes();
