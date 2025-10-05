<!-- Business Dropdown in Sidebar -->
<div class="list-group">
     <!-- Business Toggle -->
     <a href="#" id="businessToggle" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ \App\Http\Controllers\SettingController::getCompanyImage() }}" 
                 class="me-2 rounded-circle" 
                 style="width: 40px; height: 40px; object-fit: contain;">
            <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
        </div>
        <i class="bi bi-chevron-down" id="businessToggleIcon"></i>
    </a> 


    <!-- Collapsible Business Menu Items -->
    <div class="collapse-custom" id="businessMenu" style="display: none;">
      
        <div class="list-group-item text-muted small">
            <i class="bi bi-person-circle me-2"></i> Logged in as: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </div>
        <a href="{{ route('settings.account') }}" class="list-group-item list-group-item-action">
            <i class="bi bi-gear me-2"></i> Account
        </a>
        <a href="{{ route('plan.upgrade') }}" class="list-group-item list-group-item-action">
            <i class="bi bi-card-checklist me-2"></i> Subscription
        </a>
        <a href="{{ route('billing') }}" class="list-group-item list-group-item-action">
            <i class="bi bi-credit-card me-2"></i> Billing
        </a>
      
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
            <i class="bi bi-box-arrow-right me-2"></i> Log Out
        </a>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#businessToggle').click(function (e) {
        e.preventDefault();
        $('#businessMenu').slideToggle(200);
        $('#businessToggleIcon').toggleClass('bi-chevron-down bi-chevron-up');
    });
});
</script>

<!-- Lucide Icon Loader -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('sidebarToggle');
        toggleBtn?.addEventListener('click', function () {
            document.body.classList.toggle('sidebar-collapsed');
            document.cookie = "sidebar_minimize_state=" + (document.body.classList.contains('sidebar-collapsed') ? "on" : "off") + "; path=/";
        });

        // Restore from cookie
        @if(isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on")
            document.body.classList.add('sidebar-collapsed');
        @endif
    });
</script>

<style>
    .sidebar-collapsed .sidebar {
        width: 60px !important;
    }
    .sidebar-collapsed .sidebar .sidebar-content {
        display: none;
    }
</style>
