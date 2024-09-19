<?php

use App\Http\Controllers\AnnouncementController;
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


Route::get('/inventory/dashboard', [DashboardController::class, 'index']);
Route::get('/inventory/items', [ItemController::class, 'index']);
Route::get('/item/edit/{itemID}', [ItemController::class, 'getItem']);
Route::patch('/item/{item}', [ItemController::class, 'updateItem']);

Route::get('/inventory/donors', [DonorController::class, 'index']);
Route::get('/inventory/donors/{donorID}', [DonorController::class, 'getDonor']);
Route::patch('/inventory/donors/{donorID}', [DonorController::class, 'updateDonor']);
Route::post('/donor', [DonorController::class, 'addDonor']);
Route::get('/inventory/account', [AccountController::class, 'index']);

Route::get('/inventory/recipients', [RecipientController::class, 'index']);
Route::get('/inventory/recipients/{recipientID}', [RecipientController::class, 'getRecipient']);
Route::patch('/inventory/recipients/{recipientID}', [RecipientController::class, 'updateRecipient']);
Route::post('/inventory/recipient', [RecipientController::class, 'addRecipient']);

Route::post('/item', [ItemController::class, 'addItem']);
Route::delete('/item/{item}', [ItemController::class, 'deleteItem']);

Route::post('/announcement', [AnnouncementController::class, 'newAnnouncement']);

Route::get('/inventory/announcement/{announcementID}', [AnnouncementController::class, 'viewAnnouncement']);
Route::patch('/inventory/announcement/{announcementID}', [AnnouncementController::class, 'updateAnnouncement']);
Route::delete('/inventory/announcement/{announcementID}', [AnnouncementController::class, 'deleteAnnouncement']);


Route::get('/inventory/report', [\App\Http\Controllers\Inventory\ReportController::class, 'report']);

Route::post('/inventory/event', [\App\Http\Controllers\Inventory\EventController::class, 'newEvent']);
Route::get('/inventory/events', [\App\Http\Controllers\Inventory\EventController::class, 'index']);
Route::get('/inventory/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'viewEvent']);
Route::delete('/inventory/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'deleteEvent']);
Route::patch('/inventory/events/{eventID}', [\App\Http\Controllers\Inventory\EventController::class, 'deleteEvent']);

Route::post('/inventory/donate', [\App\Http\Controllers\DonationController::class, 'donate']);

Route::get('/inventory/announcements', [AnnouncementController::class, 'index'])->name('announcements');
Route::get('/create-announcement', [AnnouncementController::class, 'createAnnouncement']);
Route::post('/announcement-attachment', [\App\Http\Controllers\AnnouncementAttachmentController::class, 'addImage']);

Route::get('/charity', [HomeController::class, 'index']);
Route::get('/charity/announcements', [CharityAnnouncementController::class, 'index']);
Route::get('/charity/contact-us', [ContactController::class, 'index']);
Route::get('/charity/about-us', [AboutController::class, 'index']);
Route::get('/charity/events', [CharityEventController::class, 'index']);
