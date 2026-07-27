<?php

// Add this line inside routes/web.php (do NOT put it inside the auth/admin
// middleware group — logged-out and logged-in tabs both need to poll it).

use App\Http\Controllers\VersionController;

Route::get('/app-version', [VersionController::class, 'show'])
    ->name('app-version')
    ->middleware('throttle:30,1'); // 30 requests/min per IP — generous for 60s polling, blocks abuse
