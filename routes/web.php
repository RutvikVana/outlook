<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;

// Route to welcome page
Route::get('/', [HomeController::class, 'welcome']);

// Microsoft OAuth routes
Route::get('/signin', [AuthController::class, 'redirectToMicrosoft']);
Route::get('/callback', [AuthController::class, 'handleMicrosoftCallback'])->name('microsoft.callback');
Route::get('/signout', [AuthController::class, 'signout']);

// Routes for fetching emails and calendar events
Route::get('/emails', [HomeController::class, 'getEmails']);
Route::get('/calendar', [HomeController::class, 'getCalendarEvents']);
