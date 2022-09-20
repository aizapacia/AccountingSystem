<?php

use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home/distributor/{id}',[QuickSearchController::class,'distributorVal']);
Route::get('/home/order',[ReportController::class,'order']);


Route::get('/report',[ReportController::class, 'daily']);
Route::get('/report/all',[ReportController::class, 'all']);
Route::get('/report/{id}',[ReportController::class, 'disSpecific']);


Route::get('/distributor', [DistributorController::class,'all']);
Route::get('/distributor/{val}', [DistributorController::class,'disSpecific']);