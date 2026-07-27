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
        @if($invoice->total_due > 0)
        <a href="#" class="record-payment-form" invoice-code="{{ $invoice->invoice_code }}">
            <i data-lucide="notebook-pen" class="text-primary"></i>
            Record Payment
        </a>
        @endif

        <a href="#" invoice-code="{{ $invoice->invoice_code }}" class="invoice-view-model">
            <i data-lucide="eye" class="text-primary"></i>
            View
        </a>

        <a href="{{ route('invoice.edit',['invoice_code' => $invoice->invoice_code ]) }}">
            <i data-lucide="pencil" class="text-warning"></i>
            Edit
        </a>



        <a href="{{ route('invoice.download',['invoice_code'=>$invoice->invoice_code]) }}?preview=true"
            target="_blank">
            <i data-lucide="printer" class="text-info"></i> Print

        </a>

        <a href="{{ route('invoice.download',['invoice_code'=>$invoice->invoice_code]) }}">
            <i data-lucide="download" class="text-success"></i>
            Download PDF
        </a>
        <a href="#" class="single-send-invoice-model" invoice-code="{{ $invoice->invoice_code }}">
            <i data-lucide="send" class="text-info"></i>
            Share to Email
        </a>
        <a href="{{ route('invoice.whatsapp.share', ['invoice_code' => $invoice->invoice_code]) }}" target="__blank">
            <i data-lucide="message-circle" class="text-success"></i>
            Share to WhatsApp
        </a>
        <a href="#" title="Delete Invoice"
            class="single-delete"
            invoice-code="{{ $invoice->invoice_code }}">
            <i data-lucide="trash-2" class="text-danger"></i>
            Delete
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
        var invoice_code = $(this).attr('invoice-code');
        $('#confirmed-single-delete').attr('invoice-code', invoice_code)
        $('#singleDeleteModal').modal('show');


    });


    $('#confirmed-single-delete').on('click', function(e) {
        e.preventDefault();
        var invoice_code = $(this).attr('invoice-code');
        $.ajax({
            url: "{{ route('invoice.destroy') }}",
            method: 'POST',
            data: {
                invoice_code: invoice_code,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.error === 0) {
                    location.reload();
                } else {
                    alert("Failed to delete invoices.");
                }
            },
            error: function() {
                alert("An error occurred while deleting invoices.");
            }
        });
    });
</script>