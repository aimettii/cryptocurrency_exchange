<?php

use App\Services\BlockchainAPI\BlockchainAPIService;
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

Route::resource('rates', 'TickerAPIController')
    ->only(['index']);

Route::resource('convert', 'OrderAPIController')
    ->only(['store']);
