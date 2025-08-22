<?php

use App\Http\Controllers\HelpController;
use App\Http\Controllers\HelpFeedbackController;
use App\Http\Controllers\HelpMessageController;
use App\Http\Controllers\HelpOfferController;
use App\Http\Controllers\HelperProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Help Module Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('help')->name('help.')->group(function () {
    // Main Help Routes
    Route::get('/', [HelpController::class, 'index'])->name('index');
    Route::get('/create', [HelpController::class, 'create'])->name('create');
    Route::post('/', [HelpController::class, 'store'])->name('store');
    Route::get('/{helpRequest}', [HelpController::class, 'show'])->name('show');
    Route::get('/{helpRequest}/edit', [HelpController::class, 'edit'])->name('edit');
    Route::put('/{helpRequest}', [HelpController::class, 'update'])->name('update');
    Route::post('/{helpRequest}/cancel', [HelpController::class, 'cancel'])->name('cancel');
    Route::post('/{helpRequest}/complete', [HelpController::class, 'complete'])->name('complete');
    
    // Category-specific help requests
    Route::get('/category/{category:slug}', [HelpController::class, 'category'])->name('category');
    
    // My Help Requests
    Route::get('/my-requests', [HelpController::class, 'myRequests'])->name('my-requests');
    
    // Search for help requests
    Route::get('/search', [HelpController::class, 'search'])->name('search');
    
    // Get skills for a category (AJAX)
    Route::get('/category/{category}/skills', [HelpController::class, 'getCategorySkills'])->name('category.skills');
    
    // Help Offer Routes
    Route::post('/{helpRequest}/offer', [HelpOfferController::class, 'store'])->name('offer.store');
    Route::put('/offer/{offer}', [HelpOfferController::class, 'update'])->name('offer.update');
    Route::post('/offer/{offer}/withdraw', [HelpOfferController::class, 'withdraw'])->name('offer.withdraw');
    Route::post('/offer/{offer}/accept', [HelpOfferController::class, 'accept'])->name('offer.accept');
    Route::post('/offer/{offer}/reject', [HelpOfferController::class, 'reject'])->name('offer.reject');
    Route::post('/{helpRequest}/start', [HelpOfferController::class, 'startHelp'])->name('start');
    Route::get('/my-offers', [HelpOfferController::class, 'myOffers'])->name('my-offers');
    
    // Help Message Routes
    Route::post('/{helpRequest}/message', [HelpMessageController::class, 'store'])->name('message.store');
    Route::delete('/message/{message}', [HelpMessageController::class, 'destroy'])->name('message.destroy');
    Route::get('/message/{message}/attachment/{index}', [HelpMessageController::class, 'downloadAttachment'])->name('message.attachment');
    
    // Help Feedback Routes
    Route::get('/{helpRequest}/feedback', [HelpFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/{helpRequest}/feedback', [HelpFeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{feedback}/respond', [HelpFeedbackController::class, 'respond'])->name('feedback.respond');
    Route::post('/feedback/{feedback}/respond', [HelpFeedbackController::class, 'storeResponse'])->name('feedback.respond.store');
    
    // Helper Profile Routes
    Route::get('/profile', [HelperProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [HelperProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [HelperProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/availability', [HelperProfileController::class, 'updateAvailability'])->name('profile.availability.update');
    Route::get('/helper/{user}', [HelperProfileController::class, 'publicProfile'])->name('helper.profile');
    Route::get('/leaderboard', [HelperProfileController::class, 'topHelpers'])->name('leaderboard');
});
