<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/item/edit/{itemID}', [ItemController::class, 'getItem']);
Route::patch('/item/{item}', [ItemController::class, 'updateItem']);

Route::get('/donors', [DonorController::class, 'index']);
Route::post('/donor', [DonorController::class, 'addDonor']);

Route::get('/recipients', [RecipientController::class, 'index']);
Route::post('/recipient', [RecipientController::class, 'addRecipient']);

Route::post('/item', [ItemController::class, 'addItem']);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem']);

Route::post('/announcement', [AnnouncementController::class, 'newAnnouncement']);
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
Route::get('/create-announcement', [AnnouncementController::class, 'createAnnouncement']);
Route::post('/announcement-attachment', [\App\Http\Controllers\AnnouncementAttachmentController::class, 'addImage']);
