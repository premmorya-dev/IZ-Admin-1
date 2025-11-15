<style>
    .wide-dropdown {
        min-width: 220px;
        /* or more */
        padding: 0.5rem 1rem;
        /* optional for better spacing */
    }
</style>

<div class="dropdown">
    <button class="dropdown-toggle" onclick="toggleDropdown(this)">
        <i data-lucide="more-vertical"></i>
    </button>
    <div class="dropdown-menu wide-dropdown">
        @if( $bill->total_due > 0 )
        <a href="#" class="record-payment-form" bill-code="{{ $bill->bill_code }}"><i data-lucide="notebook-pen" class="text-primary"></i> Record Payment</a>
        @endif

        <a href="#" bill-code="{{ $bill->bill_code }}" class="bill-view-model"><i data-lucide="eye" class="text-primary"></i> View</a>
        <a href="{{ route('bill.edit',['bill_code' => $bill->bill_code ]) }}"><i data-lucide="pencil" class="text-warning"></i> Edit</a>

       
        <a href="#" title="Delete bill" class="single-delete" bill-code="{{ $bill->bill_code }}">
                <i data-lucide="trash-2"  class="text-danger"></i> Delete
            </a>
       
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

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>


    $('.single-delete').on('click', function() {
       var bill_code = $(this).attr('bill-code');
       $('#confirmed-single-delete').attr('bill-code',bill_code)
       $('#singleDeleteModal').modal('show');

      
    });


    $('#confirmed-single-delete').on('click', function(e) {
        e.preventDefault();
       var bill_code = $(this).attr('bill-code');
        $.ajax({
            url: "{{ route('bill.destroy') }}",
            method: 'POST',
            data: {
                bill_code: bill_code,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.error === 0) {
                    location.reload();
                } else {
                    alert("Failed to delete bills.");
                }
            },
            error: function() {
                alert("An error occurred while deleting bills.");
            }
        });
    });


</script>