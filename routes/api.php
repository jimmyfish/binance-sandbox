<?php

use App\Http\Controllers\LoggerAction;
use App\Http\Controllers\Order\CreateOrderAction;
use App\Http\Controllers\Order\SellOrderAction;
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

Route::post('order', CreateOrderAction::class)->name('order.create');
Route::delete('order', SellOrderAction::class)->name('order.close');
Route::get('order', SellOrderAction::class)->name('order.close.get');

Route::post('log', LoggerAction::class)->name('log.write');
