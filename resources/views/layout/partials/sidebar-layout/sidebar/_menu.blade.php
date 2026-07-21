

<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
        data-kt-scroll-save-state="true" style="margin-bottom: 70px !important;">

        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6"
            id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <!-- Upgrade Banner -->
            <div class="menu-item">
                <div class="upgrade-card"
                    id="upgrade"
                    onclick='window.location.href="{{ route('plan.upgrade') }}"'>
                    <div class="upgrade-icon">🚀</div>
                    <span class="upgrade-title">Upgrade Plan</span>
                    <span class="upgrade-sub">Unlock premium features</span>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon icon-dashboard"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </div>

            <!-- Sales Section -->
            <div class="menu-item pt-4">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Sales</span>
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
                    <span class="menu-icon icon-sales"><i data-lucide="file-plus"></i></span>
                    <span class="menu-title">Estimates</span>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('client.*') ? 'active' : '' }}">
                <a href="{{ route('client.list') }}" class="menu-link">
                    <span class="menu-icon icon-sales"><i data-lucide="users"></i></span>
                    <span class="menu-title">Clients</span>
                </a>
            </div>

            <!-- Purchases Section -->
            <div class="menu-item pt-4">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">Purchases</span>
                </div>
            </div>
            <div class="menu-item {{ request()->routeIs('vendor.*') ? 'active' : '' }}">
                <a href="{{ route('vendor.list') }}" class="menu-link">
                    <span class="menu-icon icon-purchases"><i data-lucide="briefcase"></i></span>
                    <span class="menu-title">Vendors</span>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('bill.*') ? 'active' : '' }}">
                <a href="{{ route('bill.list') }}" class="menu-link">
                    <span class="menu-icon icon-purchases"><i data-lucide="receipt-text"></i></span>
                    <span class="menu-title">Bills</span>
                </a>
            </div>

            <!-- Expense Section -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('expense.*') ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-expense"><i data-lucide="activity"></i></span>
                    <span class="menu-title">Expenses</span>
                    <span class="menu-arrow"> <i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.list') }}">
                            <span class="menu-icon icon-expense"><i data-lucide="file-plus"></i></span>
                            <span class="menu-title">All Expenses</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.item.list') }}">
                            <span class="menu-icon icon-expense"><i data-lucide="file-plus"></i></span>
                            <span class="menu-title">Expense Items</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.category.list') }}">
                            <span class="menu-icon icon-expense"><i data-lucide="boxes"></i></span>
                            <span class="menu-title">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventory Section -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('item.*') ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-inventory"><i data-lucide="package-search"></i></span>
                    <span class="menu-title">Inventory</span>
                    <span class="menu-arrow"> <i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('item.list') }}">
                            <span class="menu-icon icon-inventory"><i data-lucide="boxes"></i></span>
                            <span class="menu-title">Items</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('item.category.list') }}">
                            <span class="menu-icon icon-inventory"><i data-lucide="list-tree"></i></span>
                            <span class="menu-title">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="menu-item pt-4 {{ request()->routeIs('report.*') ? 'active' : '' }}">
                <a href="{{ route('report.index') }}" class="menu-link">
                    <span class="menu-icon icon-reports"><i data-lucide="bar-chart"></i></span>
                    <span class="menu-title">Reports</span>
                </a>
            </div>

            <!-- Settings -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion pt-4 {{ request()->routeIs(['settings.*','tax.*','discount.*','upi_id.*']) ? 'show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon icon-settings"><i data-lucide="settings"></i></span>
                    <span class="menu-title">Business Settings</span>
                    <span class="menu-arrow"> <i data-lucide="chevron-down"></i></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('settings.edit') }}">
                            <span class="menu-icon icon-settings"><i data-lucide="briefcase"></i></span>
                            <span class="menu-title">Business Info</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('tax.list') }}">
                            <span class="menu-icon icon-settings"><i data-lucide="circle-dollar-sign"></i></span>
                            <span class="menu-title">Tax</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('discount.list') }}">
                            <span class="menu-icon icon-settings"><i data-lucide="tag"></i></span>
                            <span class="menu-title">Discount</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('upi_id.list') }}">
                            <span class="menu-icon icon-settings"><i data-lucide="qr-code"></i></span>
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