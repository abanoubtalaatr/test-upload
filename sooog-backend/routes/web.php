<?php

use App\Order\Domain\Models\Order;
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

Route::get('/', function () {
    return view('welcome');
});
//Route::get('hyperPayView',[\App\Infrastructure\Http\Controllers\PyamentController::class,'hyperPayView'])->name('hyperPay');
Route::view('payment-success','success')->name('payment-success');
Route::view('payment-error','fail')->name('payment-error');

Route::get("/export-to-excel", \App\Admin\Actions\Admin\ExportAdminsToExcelAction::class)->name("admins.export");
