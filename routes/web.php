<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/item/edit/{itemID}', [ItemController::class, 'getItem']);
Route::patch('/item/{item}', [ItemController::class, 'updateItem']);

Route::post('/item', [ItemController::class, 'addItem']);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem']);
