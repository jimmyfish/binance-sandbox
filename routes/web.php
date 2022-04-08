<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\IndexAction;
use App\Http\Controllers\Log\ShowLogAction;
use App\Http\Controllers\Watchlists\ViewAction;
use App\Http\Controllers\Order\ListAllOrderAction;
use App\Http\Controllers\Order\ShowTradeStrategiesAction;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth'
], function () {
    Route::get('/', IndexAction::class)->name('home');
    Route::get('watchlists', ViewAction::class)->name('watchlists.view');

    Route::get('orders', ListAllOrderAction::class)->name('order.list');

    Route::get('logs', ShowLogAction::class)->name('log.list');

    Route::get('trade-strategies', ShowTradeStrategiesAction::class)->name('strategy.trade.show');
});

require __DIR__.'/auth.php';
