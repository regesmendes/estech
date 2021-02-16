<?php

use App\Http\Controllers\PricesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/live-prices', function() {
    return Storage::disk('local')->get('live-prices.json');
});

Route::get('/prices', [PricesController::class, 'getPrices']);
