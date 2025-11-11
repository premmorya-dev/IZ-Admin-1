<div class="dropdown">
    <a href="#" class="btn btn-primary btn-sm" onclick="toggleDropdown(this)"> <i class="fa-solid fa-gear"></i> Update Invoice <i data-lucide="more-vertical"></i> </a>
    <div class="dropdown-menu custom-dropdown">
        <a href="#" class="update-invoice" send-status="false" paid-status="false"><i data-lucide="save" class="text-primary"></i> Update</a>
        <a href="#" class="update-invoice" send-status="true" paid-status="false"><i data-lucide="send" class="text-info"></i> Update & Send Invoice</a>
        <a href="#" class="record-payment-form" invoice-code="{{ $data['invoice']->invoice_code }}" ><i data-lucide="indian-rupee" class="text-success"></i> Record Payment</a>

    </div>
</div>
<input type="hidden" name="send_status" id="send_status" value="">

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