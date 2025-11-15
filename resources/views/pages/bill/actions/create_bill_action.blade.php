<div class="dropdown">
    <a href="#" class="btn btn-primary btn-sm" onclick="toggleDropdown(this)"> <i class="fa-solid fa-gear"></i> Actions <i data-lucide="more-vertical"></i> </a>
    <div class="dropdown-menu custom-dropdown">
        <a href="#" class="save-bill" ><i data-lucide="save" class="text-primary"></i> Add</a>
    </div>
</div>

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