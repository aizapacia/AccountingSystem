<?php

use App\Http\Controllers\DistributorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();


Route::get('/search/{searchby}', [SearchController::class, 'searchVal'])
    ->name('quickSearch');
Route::get('/distributorOrder/{id}', [SearchController::class, 'disTable'])->name('disTable');

Route::get('/report', [ReportController::class, 'index'])->name('report');
Route::get('/reportFilter', [ReportController::class, 'search'])->name('reportSearch');
Route::get('/download/{dID}/{dateby}/{fdate}/{tdate}', [ReportController::class, 'download'])->name('download');

Route::get('/distributor', [DistributorController::class, 'index'])->name('distributor');
