<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Auth\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [AuthController::class, 'getLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'userLogin'])->name('post.login');
});


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'auth:admin',
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('logout', [DashboardController::class, 'logOut'])->name('logout');
    Route::resource('stock',StockController::class);
    Route::get('tabulator-stock', [StockController::class, 'tabulatorList'])->name('stock.tabulator');
});
