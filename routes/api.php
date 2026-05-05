<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\MidtransCallbackController;
Route::post('/midtrans-callback', [MidtransCallbackController::class, 'callback'])->name('midtrans.callback');
