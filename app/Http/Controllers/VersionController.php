<?php

namespace App\Http\Controllers;

use App\Services\VersionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * VersionController
 *
 * Exposes the currently deployed application version to the frontend
 * so the client-side UpdateChecker can detect when a newer build has
 * gone live and prompt the user to refresh.
 */
class VersionController extends Controller
{
    public function __construct(private readonly VersionService $versionService)
    {
    }

    /**
     * GET /app-version
     *
     * Cache-safe endpoint (frontend appends ?t=timestamp) that returns
     * the current release metadata. Keep this payload small — it is
     * polled every 60s from every open tab.
     */
    public function show(Request $request): JsonResponse
    {
        return response()
            ->json($this->versionService->currentRelease())
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
