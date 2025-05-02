<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Route to welcome page
Route::get('/', [HomeController::class, 'welcome']);

// Microsoft OAuth routes
Route::get('/signin', [AuthController::class, 'redirectToMicrosoft'])->name('microsoft.redirect');
Route::get('/callback', [AuthController::class, 'handleMicrosoftCallback'])->name('microsoft.callback');
Route::get('/signout', [AuthController::class, 'signout'])->name('signout');

// Routes for fetching Outlook data
Route::get('/emails', [HomeController::class, 'getEmails'])->name('emails');
Route::get('/calendar', [HomeController::class, 'getCalendarEvents'])->name('calendar');
