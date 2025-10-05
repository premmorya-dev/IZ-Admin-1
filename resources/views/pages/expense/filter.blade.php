<style>
    .accordion-button {
        cursor: pointer;
    }
</style>

<div class="container mt-5">
    <div class="accordion mb-4" id="filterAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFilter">
                <div class="accordion-button collapsed" role="button"
                    data-bs-target="#collapseFilter"
                    aria-expanded="false"
                    aria-controls="collapseFilter"
                    onclick="toggleAccordion(this)">
                    <i class="fa-solid fa-filter me-2"></i> Filter
                </div>
            </h2>
            <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#filterAccordion">
                <div class="accordion-body">
                    <div class="accordion-body">
                        <form action="" method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label for="select_expense_param" class="form-label">Expense Parameter</label>
                                <select id="select_expense_param" name="select_expense_param" class="form-select">                                  
                                    <option value="expense_number_is" {{ request('select_expense_param') ==   'expense_number_is' ? 'selected' : '' }}>Expense # IS</option>                                  
                                    <option value="expense_number_multiline" {{ request('select_expense_param') ==   'expense_number_multiline' ? 'selected' : '' }}>Expense # IN (Multi Line)</option>
                                </select>
                            </div>

                            <div class="col-md-3 " id="expense-id-section">
                                <label for="expense_id" class="form-label">Expense Id</label>
                                <input type="text" name="expense_id" value="{{ request('expense_id') }}" id="expense_id" placeholder="Registration Id" class="form-control">
                            </div>

                            <div class="col-md-3 " id="expense-id-multiline-section">
                                <label for="expense_id_multiline" class="form-label">Expense Id</label>
                                <textarea name="expense_id_multiline" id="expense_id_multiline" class="form-control">{{ request('expense_id_multiline') }}</textarea>
                            </div>

                            <div class="col-md-3 " id="expense-number-section">
                                <label for="expense_number" class="form-label">Expense Number</label>
                                <input type="text" name="expense_number" value="{{ request('expense_number') }}" id="expense_number" placeholder="Registration Id" class="form-control">
                            </div>

                            <div class="col-md-3 " id="expense-number-multiline-section">
                                <label for="expense_number_multiline" class="form-label">Expense Number</label>
                                <textarea name="expense_number_multiline" id="expense_number_multiline" class="form-control">{{ request('expense_number_multiline') }}</textarea>
                            </div>

                         

                            <div class="col-md-3 ">
                                <label for="tax_total" class="form-label">Tax Total</label>
                                <input type="number" name="tax_total" value="{{ request('tax_total') }}" id="tax_total" placeholder="Tax Total" class="form-control">
                            </div>
                            <div class="col-md-3 ">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" name="discount" value="{{ request('discount') }}" id="discount" placeholder="Discount" class="form-control">
                            </div>

                            <div class="col-md-3 ">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" value="{{ request('amount') }}" id="amount" placeholder="Amount" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Expense Date</label>
                                <div class="input-group">
                                    <input type="text" name="expense_date" id="expense_date" value="{{ request('expense_date') }}" class="form-control date-range" placeholder="Pick Issue Date Range">
                                    <span class="input-group-text date-range"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>

                          
                            <div class="col-md-3 col-sm-12">
                                <label for="pagination_per_page" class="form-label">Records Per Page</label>
                                <select id="pagination_per_page" name="pagination_per_page" class="form-select">
                                    <option value=""><--Select--></option>
                                    <option value="50" {{ request('pagination_per_page') ==   '50' ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('pagination_per_page') ==   '100' ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ request('pagination_per_page') ==   '200' ? 'selected' : '' }}>200</option>
                                    <option value="500" {{ request('pagination_per_page') ==   '500' ? 'selected' : '' }}>500</option>
                                    <option value="1000" {{ request('pagination_per_page') ==   '1000' ? 'selected' : '' }}>1000</option>
                                </select>
                            </div>


                            <div class="col-12 text-end">
                                <span id="filter-btn" class="btn btn-primary btn-sm "><i class="fa-solid fa-filter"></i> Filter</span>
                                <a href="{{ route('expense.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-eraser-fill"></i> Reset</a>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS CDN (with Popper) -->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

<script>
    function toggleAccordion(button) {
        const targetId = button.getAttribute('data-bs-target');
        const target = document.querySelector(targetId);
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        button.classList.toggle('collapsed');
        button.setAttribute('aria-expanded', !isExpanded);

        const collapseInstance = bootstrap.Collapse.getInstance(target) || new bootstrap.Collapse(target, {
            toggle: false
        });

        if (isExpanded) {
            collapseInstance.hide();
        } else {
            collapseInstance.show();
           
        }
    }
</script>






<script>

$(document).ready(function() {

    function refreshSelectCustomerParam(select_expense_param) {
            if (select_expense_param == 'expense_id_is') {
                $('#expense_id').attr('placeholder', '12345')
            } else if (select_expense_param == 'expense_id_in') {
                $('#expense_id').attr('placeholder', '12345,1265')
            } else if (select_expense_param == 'expense_id_multiline') {
                $('#expense_id_multiline').attr('placeholder', '12345\n1265')
            } else if (select_expense_param == 'expense_number_is') {
                $('#expense_number').attr('placeholder', 'INV-2023')
            } else if (select_expense_param == 'expense_number_in') {
                $('#expense_number').attr('placeholder', 'INV-2023,INV-20232')
            } else if (select_expense_param == 'expense_number_multiline') {
                $('#expense_number_multiline').attr('placeholder', 'INV-2023\nINV-20232')
            }
        }

        function refreshCustomerParam(select_expense_param) {
            if (select_expense_param == 'expense_id_is' || select_expense_param == 'expense_id_in') {
                $('#expense-id-section').show();
                $('#expense-number-section').hide();             
                $('#expense-id-multiline-section').hide();
                $('#expense-number-multiline-section').hide();
            } else if (select_expense_param == 'expense_id_multiline') {
                $('#expense-id-multiline-section').show();
                $('#expense-id-section').hide();
                $('#expense-number-section').hide();            
                $('#expense-number-multiline-section').hide();
            } else if (select_expense_param == 'expense_number_is' || select_expense_param == 'expense_number_in') {
                $('#expense-id-section').hide();
                $('#expense-number-section').show();              
                $('#expense-id-multiline-section').hide();
                $('#expense-number-multiline-section').hide();
            } else if (select_expense_param == 'expense_number_multiline') {
                $('#expense-number-multiline-section').show();
                $('#expense-id-multiline-section').hide();
                $('#expense-id-section').hide();
                $('#expense-number-section').hide();
            

            }else {
                $('#expense-id-section').show();
                $('#expense-number-section').hide();           
                $('#expense-id-multiline-section').hide();
                $('#expense-number-multiline-section').hide();
            }
        }

        let select_expense_param = $('#select_expense_param').val();
        refreshCustomerParam(select_expense_param);
        refreshSelectCustomerParam(select_expense_param)

        $('#select_expense_param').change(function() {
            let customer_param = this.value;
            refreshCustomerParam(customer_param);
            refreshSelectCustomerParam(customer_param)

        });

})
</script>

<script>
    $(document).ready(function() {

        $('#filter-btn').on('click', function(e) {

            var url = '';

            function addParam(name, type = 'input') {
                var element = $(type + '[name="' + name + '"]');
                if (element.is(':visible') && element.val()) {
                    url += '&' + name + '=' + encodeURIComponent(element.val());
                }
            }

            // Handle select elements
            addParam('select_expense_param', 'select');   
            addParam('pagination_per_page', 'select');     
          
           

            // Handle input elements
            addParam('expense_id');
            addParam('expense_id_multiline','textarea');
            addParam('expense_number');
            addParam('expense_number_multiline','textarea');
          
            addParam('discount');
            addParam('amount');
            addParam('expense_date');
           
     
            location = '{{url("/")}}' + '/expense/list?filters=true' + url;


        });
    });
</script>

<script>
 


    $("#expense_date").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        autoUpdateInput: false, // Keep input field empty initially
        locale: {
            format: "YYYY-M-DD"
        }
    }, function(start, end) {
        // When a user selects a date range, update the input field
        $('#expense_date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

        // Calculate total days selected
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total Days Selected: " + daysSelected);
    });

    // Optional: Clear input field when clicking "Cancel" in the date picker
    $('#expense_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });


    $("#due_date").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        autoUpdateInput: false, // Keep input field empty initially
        locale: {
            format: "YYYY-M-DD"
        }
    }, function(start, end) {
        // When a user selects a date range, update the input field
        $('#due_date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

        // Calculate total days selected
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total Days Selected: " + daysSelected);
    });

    // Optional: Clear input field when clicking "Cancel" in the date picker
    $('#due_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });




</script>