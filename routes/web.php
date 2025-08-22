<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketplaceController;

Route::get('/', function () {
    return view('home');
});

// Authentication Routes - Guest Only
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Community Routes
    Route::get('/community', [App\Http\Controllers\CommunityController::class, 'feed'])->name('community.feed');
    Route::post('/community/post', [App\Http\Controllers\CommunityController::class, 'storePost'])->name('community.post.store');
    Route::get('/community/post/{post}/edit', [App\Http\Controllers\CommunityController::class, 'editPost'])->name('community.post.edit');
    Route::put('/community/post/{post}', [App\Http\Controllers\CommunityController::class, 'updatePost'])->name('community.post.update');
    Route::delete('/community/post/{post}', [App\Http\Controllers\CommunityController::class, 'destroyPost'])->name('community.post.destroy');
    
    // Event Routes
    Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [App\Http\Controllers\EventController::class, 'create'])->name('events.create');
    Route::post('/events', [App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [App\Http\Controllers\EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/rsvp', [App\Http\Controllers\EventController::class, 'rsvp'])->name('events.rsvp');
    
    // Marketplace Routes
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/create', [MarketplaceController::class, 'create'])->name('marketplace.create');
    Route::post('/marketplace', [MarketplaceController::class, 'store'])->name('marketplace.store');
    Route::get('/marketplace/my-listings', [MarketplaceController::class, 'myListings'])->name('marketplace.my-listings');
    Route::get('/marketplace/{item}', [MarketplaceController::class, 'show'])->name('marketplace.show');
    Route::get('/marketplace/{item}/edit', [MarketplaceController::class, 'edit'])->name('marketplace.edit');
    Route::put('/marketplace/{item}', [MarketplaceController::class, 'update'])->name('marketplace.update');
    Route::delete('/marketplace/{item}', [MarketplaceController::class, 'destroy'])->name('marketplace.destroy');
});

// Include Help Module Routes
require __DIR__.'/help.php';
