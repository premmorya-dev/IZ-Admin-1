<div class="dropdown">
    <button class="dropdown-toggle" onclick="toggleDropdown(this)">
        <i data-lucide="more-vertical"></i>
    </button>
    <div class="dropdown-menu">
       
        <a href="{{ route('expense.category.edit',['expense_category_code' => $expense_categories->expense_category_code  ]  ) }}"><i data-lucide="eye" class="text-primary"></i> View</a>
        <a href="{{ route('expense.category.edit',['expense_category_code' => $expense_categories->expense_category_code  ]  ) }}"><i data-lucide="pencil" class="text-warning"></i> Edit</a>
        <a href="" class="deleteSingleBtn" data-id="{{ $expense_categories->expense_category_code }}"><i data-lucide="trash-2" class="text-danger"></i> Delete</a>



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