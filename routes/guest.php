<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\Auth\SocialiteController;

// you can use verified middleware for verify email address.
//Email tracking route
Route::get('/email-open/{id}', function ($id) { 
    // Log email open into DB
    \DB::table('leads')
        ->where('id', $id)
        ->update([
            'is_opened' => 'Y',
            'opened_at' => now()
        ]);

    // Return a 1x1 transparent PNG
    $transparentImage = base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAA
         AAC0lEQVR42mP8z8AARwMDgP8BAG0BBsdo7FYAAAAASUVORK5CYII='
    );

    return response($transparentImage)
        ->header('Content-Type', 'image/png');
})->name('email.tracking');
//Email tracking route end

Route::get('/auth/callback', [DashboardController::class, 'handleCallback'])->name('auth.callback')->middleware('web');

Route::get('estimate/acceptance/{estimate_code}', [EstimateController::class, 'estimateAcceptance'])->name('estimate.acceptance');


Route::get('/coming-soon', function () {
    return view('pages/system.coming_soon');
})->name('coming_soon');


Route::get('/payment', function () {
    return view('pages.test');
});

Route::get('/error', function () {
    abort(500);
});


Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);