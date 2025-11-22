<div class="dropdown">
    <a href="#" class="btn btn-primary btn-sm" id="action-btn" onclick="toggleDropdown(this)"> <i class="fa-solid fa-gear"></i> Actions <i data-lucide="more-vertical"></i> </a>
    <div class="dropdown-menu custom-dropdown">
        <a href="#" onclick="gtag('event', 'invoice_saved')" class="save-invoice"  send-status="false" ><i data-lucide="save" class="text-primary"></i> Save</a>
        <a href="#" class="save-invoice" send-status="true" ><i data-lucide="send" class="text-info"></i> Save & Send Invoice</a>
       
    </div>
</div>
<input type="hidden" name="send_status" id="send_status"  value="" >

<script>
    function toggleDropdown(button) {
        const menu = button.nextElementSibling;
        const allMenus = document.querySelectorAll('.dropdown-menu');
        allMenus.forEach(m => m !== menu && m.classList.remove('show'));
        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove('show'));
        }
    });
</script>