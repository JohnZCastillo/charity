<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Charity\AboutController;
use App\Http\Controllers\Charity\AnnouncementController as CharityAnnouncementController;
use App\Http\Controllers\Charity\ContactController;
use App\Http\Controllers\Charity\EventController as CharityEventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\AccountController;
use App\Http\Controllers\Inventory\DonorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;


Route::prefix('inventory')->middleware(['auth'])->group(function () {

    Route::post('/login', [AuthController::class, 'login'])
        ->withoutMiddleware(['auth']);

    Route::get('/login', [AuthController::class, 'index'])
        ->withoutMiddleware(['auth'])
        ->name('login');

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/donors', [DonorController::class, 'index']);
    Route::get('/donors/{donorID}', [DonorController::class, 'getDonor']);
    Route::patch('/donors/{donorID}', [DonorController::class, 'updateDonor']);
    Route::get('/account', [AccountController::class, 'index']);
    Route::get('/recipients', [RecipientController::class, 'index']);
    Route::get('/recipients/{recipientID}', [RecipientController::class, 'getRecipient']);
    Route::patch('/recipients/{recipientID}', [RecipientController::class, 'updateRecipient']);
    Route::post('/recipient', [RecipientController::class, 'addRecipient']);

    Route::get('/announcement/{announcementID}', [AnnouncementController::class, 'viewAnnouncement']);
    Route::patch('/announcement/{announcementID}', [AnnouncementController::class, 'updateAnnouncement']);
    Route::delete('/announcement/{announcementID}', [AnnouncementController::class, 'deleteAnnouncement']);

    Route::get('/report', [\App\Http\Controllers\Inventory\ReportController::class, 'report']);

    Route::post('/event', [\App\Http\Controllers\Inventory\EventController::class, 'newEvent']);
    Route::get('/events', [\App\Http\Controllers\Inventory\EventController::class, 'index']);
    Route::get('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'viewEvent']);
    Route::delete('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'deleteEvent']);
    Route::patch('/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'updateEvent']);

    Route::post('/donate', [\App\Http\Controllers\DonationController::class, 'donate']);
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');

});

Route::get('/', [HomeController::class, 'index']);

Route::prefix('charity')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/announcements', [CharityAnnouncementController::class, 'index']);
    Route::get('/contact-us', [ContactController::class, 'index']);
    Route::get('/about-us', [AboutController::class, 'index']);
    Route::get('/events', [CharityEventController::class, 'index']);
    Route::get('/appointment', [\App\Http\Controllers\Charity\AppointmentController::class, 'index']);
});


Route::get('/item/edit/{itemID}', [ItemController::class, 'getItem']);
Route::patch('/item/{item}', [ItemController::class, 'updateItem']);
Route::post('/donor', [DonorController::class, 'addDonor']);

Route::post('/item', [ItemController::class, 'addItem']);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem']);
Route::post('/announcement', [AnnouncementController::class, 'newAnnouncement']);
Route::post('/announcement-attachment', [\App\Http\Controllers\AnnouncementAttachmentController::class, 'addImage']);
Route::get('/create-announcement', [AnnouncementController::class, 'createAnnouncement']);

Route::get('/report', [\App\Http\Controllers\Inventory\ReportController::class, 'testReport']);

