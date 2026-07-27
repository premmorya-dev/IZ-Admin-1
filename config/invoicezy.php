<?php

// config/invoicezy.php
// Keep release copy here so a deploy = "edit .env + this file", no migrations needed.
// When you ship a new version, bump APP_VERSION in .env and update the fields below.

return [
    'release_date'       => env('APP_RELEASE_DATE', date('Y-m-d')),
    'update_title'       => env('APP_UPDATE_TITLE', "Invoicezy has been updated"),
    'update_description' => env('APP_UPDATE_DESCRIPTION', "We've made improvements to your workspace."),
    'update_countdown'   => env('APP_UPDATE_COUNTDOWN', 60),

    // Simplest to hardcode per-release; swap for a DB table later if changelog grows.
    'update_changes' => [
        '💬 Enhanced WhatsApp Sharing',
        '📑 Automatic Invoice & Estimate Squence Numbering',
        '⚡ Faster Invoice Workflow',
        '🎨 UI Improvements & Bug Fixes',
        '🚀 Performance Improvements'
    ],
];
