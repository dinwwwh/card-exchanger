<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
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

Route::get('', function () {
    return inertia('Welcome');
});

/** Card routes */
Route::prefix('cards')->group(function () {

    Route::get('exchange', [CardController::class, 'viewExchange'])
        ->name('card.exchange');

    Route::post('exchange', [CardController::class, 'exchange'])
        ->name('card.exchange');
});
