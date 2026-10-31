

<style>

/* ==========================================================================
   Invoicezy — Premium Sidebar
   Everything is scoped under .app-sidebar so it never leaks into
   header dropdowns / other Metronic menus.
   ========================================================================== */

.app-sidebar {
    --sb-bg-1: #0A0C1A;
    --sb-bg-2: #0F1226;
    --sb-text: #8F96B2;
    --sb-text-strong: #F5F6FC;
    --sb-muted: #5C6382;
    --sb-line: rgba(255, 255, 255, .06);
    --sb-hover: rgba(255, 255, 255, .05);
    --sb-accent-1: #6366F1;
    --sb-accent-2: #8B5CF6;
    --sb-ease: cubic-bezier(.4, 0, .2, 1);

    background: linear-gradient(180deg, var(--sb-bg-2) 0%, var(--sb-bg-1) 100%) !important;
    border-right: 1px solid var(--sb-line);
    box-shadow: none;
    position: relative;
    font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
}

/* one quiet glow at the top — the only ambient decoration */
.app-sidebar::before {
    content: '';
    position: absolute;
    top: -120px;
    left: -80px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(99, 102, 241, .16) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.app-sidebar .app-sidebar-menu,
.app-sidebar #kt_app_sidebar_menu_wrapper,
.app-sidebar #kt_app_sidebar_menu {
    position: relative;
    z-index: 1;
}

/* soft fade on scroll edges */
.app-sidebar #kt_app_sidebar_menu_wrapper {
    -webkit-mask-image: linear-gradient(180deg, transparent 0, #000 14px, #000 calc(100% - 14px), transparent 100%);
    mask-image: linear-gradient(180deg, transparent 0, #000 14px, #000 calc(100% - 14px), transparent 100%);
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, .14) transparent;
}

.app-sidebar #kt_app_sidebar_menu_wrapper::-webkit-scrollbar { width: 5px; }
.app-sidebar #kt_app_sidebar_menu_wrapper::-webkit-scrollbar-track { background: transparent; }
.app-sidebar #kt_app_sidebar_menu_wrapper::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, .12);
    border-radius: 10px;
}
.app-sidebar #kt_app_sidebar_menu_wrapper::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, .22); }


/* ---------- Upgrade card ---------- */
.app-sidebar .upgrade-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    margin: 2px 0 20px;
    border-radius: 12px;
    text-decoration: none;
    cursor: pointer;
    background: linear-gradient(135deg, rgba(99, 102, 241, .16) 0%, rgba(139, 92, 246, .05) 100%);
    border: 1px solid rgba(129, 140, 248, .26);
    transition: border-color .2s var(--sb-ease), box-shadow .2s var(--sb-ease), background .2s var(--sb-ease);
}

.app-sidebar .upgrade-card:hover {
    border-color: rgba(167, 139, 250, .55);
    background: linear-gradient(135deg, rgba(99, 102, 241, .24) 0%, rgba(139, 92, 246, .09) 100%);
    box-shadow: 0 10px 28px rgba(99, 102, 241, .22);
}

.app-sidebar .upgrade-card .upgrade-icon {
    width: 34px;
    height: 34px;
    flex-shrink: 0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    background: linear-gradient(135deg, var(--sb-accent-1), var(--sb-accent-2));
    box-shadow: 0 6px 16px rgba(99, 102, 241, .45), inset 0 1px 0 rgba(255, 255, 255, .28);
}

.app-sidebar .upgrade-card .upgrade-icon svg,
.app-sidebar .upgrade-card .upgrade-icon i { width: 17px; height: 17px; }

.app-sidebar .upgrade-card .upgrade-text { display: flex; flex-direction: column; min-width: 0; }

.app-sidebar .upgrade-card .upgrade-title {
    color: var(--sb-text-strong);
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.25;
}

.app-sidebar .upgrade-card .upgrade-sub {
    color: var(--sb-text);
    font-size: 11.5px;
    line-height: 1.3;
    margin-top: 2px;
}

.app-sidebar .upgrade-card .upgrade-arrow {
    margin-left: auto;
    color: var(--sb-muted);
    display: flex;
    transition: transform .2s var(--sb-ease), color .2s;
}

.app-sidebar .upgrade-card .upgrade-arrow svg { width: 16px; height: 16px; }
.app-sidebar .upgrade-card:hover .upgrade-arrow { transform: translateX(3px); color: #fff; }


/* ---------- Section labels ---------- */
.app-sidebar .menu-section { margin-top: 20px; }

.app-sidebar .menu-section .menu-content { padding: 0 12px 6px; }

.app-sidebar .menu-heading {
    display: block;
    font-size: 11.5px;
    font-weight: 600;
    letter-spacing: .01em;
    text-transform: none;
    color: var(--sb-muted) !important;
}


/* ---------- Menu items ---------- */
.app-sidebar .menu .menu-item { margin-bottom: 2px; }

.app-sidebar .menu .menu-item .menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 7px 12px 7px 8px;
    border-radius: 10px;
    position: relative;
    text-decoration: none;
    background: transparent;
    transition: background .18s var(--sb-ease), box-shadow .18s var(--sb-ease);
}

.app-sidebar .menu .menu-item .menu-link:hover { background: var(--sb-hover); }

.app-sidebar .menu .menu-item .menu-link:focus-visible {
    outline: 2px solid rgba(129, 140, 248, .75);
    outline-offset: 2px;
}

.app-sidebar .menu .menu-title {
    font-size: 13.5px;
    font-weight: 500;
    line-height: 1.3;
    color: var(--sb-text) !important;
    white-space: nowrap;
    transition: color .18s;
}

.app-sidebar .menu .menu-link:hover .menu-title { color: var(--sb-text-strong) !important; }


/* ---------- Icon tiles (neutral at rest, colour on interaction) ---------- */
.app-sidebar .menu-icon {
    --tone: 143, 150, 178;
    width: 30px;
    height: 30px;
    flex-shrink: 0;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, .04);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .05);
    color: rgba(var(--tone), .9) !important;
    transition: background .18s var(--sb-ease), box-shadow .18s var(--sb-ease), color .18s;
}

.app-sidebar .menu-icon svg,
.app-sidebar .menu-icon i {
    width: 16px;
    height: 16px;
    font-size: 16px !important;
    stroke-width: 1.9;
}

/* tone per group (RGB triplets so we can reuse them with any alpha) */
.app-sidebar .icon-dashboard { --tone: 129, 140, 248; }
.app-sidebar .icon-sales     { --tone: 52, 211, 153; }
.app-sidebar .icon-purchases { --tone: 251, 146, 60; }
.app-sidebar .icon-expense   { --tone: 244, 114, 182; }
.app-sidebar .icon-inventory { --tone: 56, 189, 248; }
.app-sidebar .icon-reports   { --tone: 192, 132, 252; }
.app-sidebar .icon-settings  { --tone: 250, 204, 21; }

.app-sidebar .menu-link:hover .menu-icon {
    background: rgba(var(--tone), .14);
    box-shadow: inset 0 0 0 1px rgba(var(--tone), .22);
}


/* ---------- Active state (the one memorable moment) ---------- */
.app-sidebar .menu .menu-item.active > .menu-link {
    background: linear-gradient(90deg, rgba(99, 102, 241, .20) 0%, rgba(139, 92, 246, .04) 100%);
    box-shadow: inset 0 0 0 1px rgba(129, 140, 248, .18);
}

.app-sidebar .menu .menu-item.active > .menu-link::before {
    content: '';
    position: absolute;
    left: -12px;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 56%;
    border-radius: 0 4px 4px 0;
    background: linear-gradient(180deg, #818CF8, #C084FC);
    box-shadow: 0 0 12px rgba(129, 140, 248, .75);
}

.app-sidebar .menu .menu-item.active > .menu-link .menu-title {
    color: var(--sb-text-strong) !important;
    font-weight: 600;
}

.app-sidebar .menu .menu-item.active > .menu-link .menu-icon {
    background: rgba(var(--tone), .18);
    box-shadow: inset 0 0 0 1px rgba(var(--tone), .42), 0 0 18px rgba(var(--tone), .35);
    color: rgb(var(--tone)) !important;
}


/* ---------- Accordion ---------- */
.app-sidebar .menu-accordion > .menu-link .menu-arrow {
    margin-left: auto;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    color: var(--sb-muted);
    transition: transform .25s var(--sb-ease), color .18s;
}

/* kill the old pseudo-element chevron — we use the Lucide icon only */
.app-sidebar .menu-accordion > .menu-link .menu-arrow::before,
.app-sidebar .menu-accordion > .menu-link .menu-arrow::after { content: none; }

.app-sidebar .menu-arrow svg,
.app-sidebar .menu-arrow i { width: 15px; height: 15px; }

.app-sidebar .menu-accordion > .menu-link:hover .menu-arrow { color: var(--sb-text-strong); }
.app-sidebar .menu-accordion.show > .menu-link .menu-arrow { transform: rotate(180deg); color: #A5B4FC; }

/* open parent, or parent whose child is active, reads as "current section" */
.app-sidebar .menu-accordion.show > .menu-link .menu-title,
.app-sidebar .menu-accordion:has(.menu-sub .menu-item.active) > .menu-link .menu-title {
    color: var(--sb-text-strong) !important;
}

.app-sidebar .menu-accordion:has(.menu-sub .menu-item.active) > .menu-link .menu-icon {
    background: rgba(var(--tone), .18);
    box-shadow: inset 0 0 0 1px rgba(var(--tone), .42);
    color: rgb(var(--tone)) !important;
}

/* sub menu: a quiet tree line aligned under the parent icon */
.app-sidebar .menu .menu-sub-accordion {
    position: relative;
    margin: 2px 0 6px 23px;
    padding: 0 0 0 14px;
    border-left: 1px solid var(--sb-line);
}

.app-sidebar .menu-sub-accordion .menu-item { margin-bottom: 1px; }

.app-sidebar .menu .menu-sub-accordion .menu-item .menu-link {
    padding: 7px 10px;
    border-radius: 8px;
}

.app-sidebar .menu-sub-accordion .menu-title { font-size: 13px; }

.app-sidebar .menu .menu-sub-accordion .menu-item.active > .menu-link {
    background: rgba(99, 102, 241, .14);
    box-shadow: none;
}

/* the rail sits on the tree line instead of the sidebar edge */
.app-sidebar .menu .menu-sub-accordion .menu-item.active > .menu-link::before {
    left: -15px;
    height: 16px;
    width: 2px;
    border-radius: 2px;
}


/* ---------- Collapsed / icon-only ---------- */
.app-sidebar-collapse .menu-title,
.app-sidebar-collapse .menu-heading,
.app-sidebar-collapse .upgrade-text,
.app-sidebar-collapse .upgrade-arrow,
.app-sidebar-collapse .menu-arrow,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .menu-title,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .menu-heading,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .upgrade-text,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .upgrade-arrow,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .menu-arrow { display: none; }

.app-sidebar-collapse .menu-link,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .menu-link { justify-content: center; padding-left: 8px; padding-right: 8px; }

.app-sidebar-collapse .upgrade-card,
[data-kt-app-sidebar-minimize="on"] .app-sidebar:not(:hover) .upgrade-card { justify-content: center; padding: 10px; }


/* ---------- Responsive (unchanged behaviour) ---------- */
@media (max-width: 991.98px) {
    .app-sidebar {
        position: fixed !important;
        left: -100% !important;
        width: 280px;
        transition: left .3s ease;
        z-index: 1055;
    }

    .app-sidebar.drawer-on { left: 0 !important; }

    .app-wrapper,
    .app-main,
    .app-page,
    .app-content {
        margin-left: 0 !important;
        padding-left: 0 !important;
        width: 100% !important;
    }
}

@media (prefers-reduced-motion: reduce) {
    .app-sidebar *,
    .app-sidebar *::before { transition: none !important; }
}

</style>

<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
        data-kt-scroll-save-state="true" style="margin-bottom: 70px !important;">

        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded px-3 fw-semibold fs-6"
            id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <!-- Upgrade -->
            <div class="menu-item">
                <a href="{{ route('plan.upgrade') }}" class="upgrade-card" id="upgrade">
                    <span class="upgrade-icon"><i data-lucide="sparkles"></i></span>
                    <span class="upgrade-text">
                        <span class="upgrade-title">Upgrade plan</span>
                        <span class="upgrade-sub">Unlock premium features</span>
                    </span>
                    <span class="upgrade-arrow"><i data-lucide="chevron-right"></i></span>
                </a>
            </div>

            <!-- Dashboard -->
            <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon icon-dashboard"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <!-- Sales -->
            <div class="menu-item menu-section">
                <div class="menu-content">
                    <span class="menu-heading">Sales</span>
                </div>
            </div>
            <div class="menu-item {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
                <a href="{{ route('invoice.list') }}" class="menu-link">
                    <span class="menu-icon icon-sales"><i data-lucide="file-text"></i></span>
                    <span class="menu-title">Invoices</span>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('estimate.*') ? 'active' : '' }}">
                <a href="{{ route('estimate.list') }}" class="menu-link">
                    <span class="menu-icon icon-sales"><i data-lucide="clipboard-list"></i></span>
                    <span class="menu-title">Estimates</span>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('client.*') ? 'active' : '' }}">
                <a href="{{ route('client.list') }}" class="menu-link">
                    <span class="menu-icon icon-sales"><i data-lucide="users"></i></span>
                    <span class="menu-title">Clients</span>
                </a>
            </div>

            <!-- Purchases -->
            <div class="menu-item menu-section">
                <div class="menu-content">
                    <span class="menu-heading">Purchases</span>
                </div>
            </div>
            <div class="menu-item {{ request()->routeIs('vendor.*') ? 'active' : '' }}">
                <a href="{{ route('vendor.list') }}" class="menu-link">
                    <span class="menu-icon icon-purchases"><i data-lucide="store"></i></span>
                    <span class="menu-title">Vendors</span>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('bill.*') ? 'active' : '' }}">
                <a href="{{ route('bill.list') }}" class="menu-link">
                    <span class="menu-icon icon-purchases"><i data-lucide="receipt-text"></i></span>
                    <span class="menu-title">Bills</span>
                </a>
            </div>

            <!-- Expenses -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('expense.*') ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-expense"><i data-lucide="wallet"></i></span>
                    <span class="menu-title">Expenses</span>
                    <span class="menu-arrow"><i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item {{ request()->routeIs('expense.*') && !request()->routeIs('expense.item.*', 'expense.category.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('expense.list') }}">
                            <span class="menu-title">All expenses</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('expense.item.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('expense.item.list') }}">
                            <span class="menu-title">Expense items</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('expense.category.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('expense.category.list') }}">
                            <span class="menu-title">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="menu-item menu-section">
                <div class="menu-content">
                    <span class="menu-heading">Products</span>
                </div>
            </div>
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('item.*') ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-inventory"><i data-lucide="package-search"></i></span>
                    <span class="menu-title">Inventory</span>
                    <span class="menu-arrow"><i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item {{ request()->routeIs('item.*') && !request()->routeIs('item.category.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('item.list') }}">
                            <span class="menu-title">Items</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('item.category.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('item.category.list') }}">
                            <span class="menu-title">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Business -->
            <div class="menu-item menu-section">
                <div class="menu-content">
                    <span class="menu-heading">Business</span>
                </div>
            </div>
            <div class="menu-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                <a href="{{ route('report.index') }}" class="menu-link">
                    <span class="menu-icon icon-reports"><i data-lucide="bar-chart"></i></span>
                    <span class="menu-title">Reports</span>
                </a>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs(['settings.*','tax.*','discount.*','upi_id.*']) ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-settings"><i data-lucide="settings"></i></span>
                    <span class="menu-title">Business settings</span>
                    <span class="menu-arrow"><i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('settings.edit') }}">
                            <span class="menu-title">Business info</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('tax.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('tax.list') }}">
                            <span class="menu-title">Tax</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('discount.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('discount.list') }}">
                            <span class="menu-title">Discount</span>
                        </a>
                    </div>
                    <div class="menu-item {{ request()->routeIs('upi_id.*') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('upi_id.list') }}">
                            <span class="menu-title">UPI IDs</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->