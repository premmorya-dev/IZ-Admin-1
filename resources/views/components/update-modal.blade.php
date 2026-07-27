{{--
    izy-update-modal
    ------------------------------------------------------------------
    Fullscreen "new version available" overlay.
    - Injected once, globally, via the main admin layout.
    - Hidden by default (aria-hidden), JS toggles `.is-visible`.
    - Content (title/description/changes/countdown) is filled in at
      runtime from GET /app-version — nothing here is hardcoded except
      the skeleton, so a re-deploy never requires touching this file.
--}}

<meta name="app-version" content="{{ config('app.version', '1.0.0') }}">

<div
    id="izyUpdateModal"
    class="izy-update-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="izyUpdateTitle"
    aria-hidden="true"
>
    <div class="izy-update-overlay__bg" aria-hidden="true"></div>

    <div class="izy-update-card" tabindex="-1">

        <div class="izy-update-card__lottie" id="izyUpdateLottie" aria-hidden="true"></div>

        <span class="izy-update-badge">
            <i class="bi bi-arrow-repeat"></i>
            <span id="izyUpdateBadgeVersion">Version Available</span>
        </span>

        <h2 class="izy-update-title" id="izyUpdateTitle">Invoicezy has been updated</h2>

        <p class="izy-update-desc">
            <span id="izyUpdateDescription">We've made improvements to your workspace.</span>
            <span class="izy-update-desc__sub">Please refresh to continue using the latest version and clear browser cache.</span>
        </p>

        <div class="izy-update-changes" id="izyUpdateChanges" aria-label="What's new">
            {{-- <li> items injected by UpdateModal.renderChanges() --}}
        </div>

        <div class="izy-update-warning" id="izyUpdateDirtyWarning" hidden>
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>You have unsaved changes. Please save your work before refreshing.</span>
        </div>

        <button type="button" class="izy-update-refresh-btn" id="izyUpdateRefreshBtn">
            <span>Refresh Now</span>
            <i class="bi bi-arrow-clockwise"></i>
        </button>

        <p class="izy-update-countdown" id="izyUpdateCountdownWrap">
            Refreshing automatically in
            <span class="izy-update-countdown__num" id="izyUpdateCountdownNum">60</span>
            seconds
        </p>

    </div>
</div>

{{-- Bootstrap Icons (skip if already loaded globally in your main layout) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{--
    Lottie CDN script intentionally removed — zero external JS dependency.
    The icon fallback (CSS-only, see update-modal.css .izy-lottie-fallback)
    is used automatically instead. Re-add the lottie-player script tag here
    only if you self-host the .js file to avoid any third-party script risk.
--}}

<link rel="stylesheet" href="{{ asset('css/update-modal.css') }}">
<script defer src="{{ asset('js/version-service.js') }}"></script>
<script defer src="{{ asset('js/countdown.js') }}"></script>
<script defer src="{{ asset('js/update-modal.js') }}"></script>
<script defer src="{{ asset('js/update-checker.js') }}"></script>
