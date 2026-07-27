<?php

namespace App\Services;

/**
 * VersionService
 *
 * Central place to define "what a release looks like". If you later want
 * to pull the changelog from a DB table (e.g. `release_notes`) instead of
 * config, this is the only class that needs to change — controller and
 * frontend stay untouched.
 */
class VersionService
{
    /**
     * Returns the payload consumed by GET /app-version.
     *
     * version      -> compared against <meta name="app-version"> on the page
     * release_date -> shown for context only, not used in comparison logic
     * countdown    -> seconds before auto-refresh fires client-side
     * changes      -> rendered as the "What's new" list in the modal
     */
    public function currentRelease(): array
    {
        return [
            'version'      => config('app.version', env('APP_VERSION', '1.0.0')),
            'release_date' => config('invoicezy.release_date', now()->toDateString()),
            'title'        => config('invoicezy.update_title', "Invoicezy has been updated"),
            'description'  => config('invoicezy.update_description', "We've made improvements to your workspace."),
            'countdown'    => (int) config('invoicezy.update_countdown', 60),
            'changes'      => config('invoicezy.update_changes', [
                'Improved WhatsApp Sharing',
                'Faster Invoice Generation',
                'Bug Fixes & Performance Improvements',
            ]),
        ];
    }
}
