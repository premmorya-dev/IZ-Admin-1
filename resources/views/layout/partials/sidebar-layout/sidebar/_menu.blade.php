<style>
	.menu-link {
		text-decoration: none;
		/* No underline normally */
	}

	.menu-link:hover .menu-title,
	.menu-link:hover .menu-icon i {
		color: #cccccc !important;
		/* Lighter gray shade for dull effect */
	}

	.upgrade {
		background-color: blue !important;
		color: white !important;
		border: none !important;
		cursor: pointer !important;
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
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6"
            id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <!-- Upgrade Banner -->
            <div class="menu-item">
                <div class="alert bg-primary text-center mb-3 upgrade cursor-pointer shadow-sm"
                     id="upgrade"
                     onclick='window.location.href="{{ route('plan.upgrade') }}"'>
                    <span class="text-white fw-bold fs-5">🚀 Upgrade Plan</span>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="layout-dashboard" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Dashboard</span>
                </a>
            </div>

            <!-- Sales Section -->
            <div class="menu-item pt-4">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7 text-gray-400">Sales</span>
                </div>
            </div>
            <div class="menu-item">
                <a href="{{ route('invoice.list') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="file-text" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Invoices</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('estimate.list') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="file-plus" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Estimates</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('client.list') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="users" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Clients</span>
                </a>
            </div>

            <!-- Purchases Section -->
            <div class="menu-item pt-4">
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7 text-gray-400">Purchases</span>
                </div>
            </div>
            <div class="menu-item">
                <a href="{{ route('vendor.list') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="briefcase" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Vendors</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('coming_soon') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="receipt-text" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Bills</span>
                </a>
            </div>

            <!-- Expense Section -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon"><i data-lucide="activity" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Expenses</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.list') }}">
                            <span class="menu-icon"><i data-lucide="file-plus" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">All Expenses</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.item.list') }}">
                            <span class="menu-icon"><i data-lucide="file-plus" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Expense Items</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('expense.category.list') }}">
                            <span class="menu-icon"><i data-lucide="boxes" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventory Section -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                <span class="menu-link">
                    <span class="menu-icon"><i data-lucide="package-search" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Inventory</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('item.list') }}">
                            <span class="menu-icon"><i data-lucide="boxes" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Items</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('item.category.list') }}">
                            <span class="menu-icon"><i data-lucide="list-tree" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Categories</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="menu-item pt-4">
                <a href="{{ route('report.index') }}" class="menu-link">
                    <span class="menu-icon"><i data-lucide="bar-chart" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Reports</span>
                </a>
            </div>

            <!-- Settings -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion pt-4">
                <span class="menu-link">
                    <span class="menu-icon"><i data-lucide="settings" class="fs-3 text-white"></i></span>
                    <span class="menu-title text-white">Business Settings</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('settings.edit') }}">
                            <span class="menu-icon"><i data-lucide="briefcase" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Business Info</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('tax.list') }}">
                            <span class="menu-icon"><i data-lucide="circle-dollar-sign" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Tax</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('discount.list') }}">
                            <span class="menu-icon"><i data-lucide="tag" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">Discount</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('upi_id.list') }}">
                            <span class="menu-icon"><i data-lucide="qr-code" class="fs-3 text-white"></i></span>
                            <span class="menu-title text-white">UPI IDs</span>
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
