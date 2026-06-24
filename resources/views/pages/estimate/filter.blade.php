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

                            <div class="col-md-3 " id="estimate-number-section">
                                <label for="estimate_number" class="form-label">Estimate Number</label>
                                <input type="text" name="estimate_number" value="{{ request('estimate_number') }}" id="estimate_number" placeholder="EST-202606241516" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" multiple multiselect-max-items="1" multiselect-search="true">
                                    <option value="draft" {{ in_array('draft', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Draft</option>
                                    <option value="sent" {{ in_array('sent', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Sent</option>
                                    <option value="accepted" {{ in_array('accepted', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ in_array('rejected', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Rejected</option>
                                    <option value="expired" {{ in_array('expired', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Issue Date</label>
                                <div class="input-group">
                                    <input type="text" name="issue_date" id="issue_date" value="{{ request('issue_date') }}" class="form-control date-range" placeholder="Pick Issue Date Range">
                                    <span class="input-group-text date-range"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Expiry Date</label>
                                <div class="input-group">
                                    <input type="text" name="expiry_date" id="expiry_date" value="{{ request('expiry_date') }}" class="form-control date-range" placeholder="Pick Due Date Range">
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
                                <a href="{{ route('estimate.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-eraser-fill"></i> Reset</a>
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

        $('#filter-btn').on('click', function(e) {

            var url = '';

            function addParam(name, type = 'input') {
                var element = $(type + '[name="' + name + '"]');
                if (element.is(':visible') && element.val()) {
                    url += '&' + name + '=' + encodeURIComponent(element.val());
                }
            }

            // Handle select elements          
            addParam('pagination_per_page', 'select');
            // Handle input elements
            addParam('estimate_id');
            addParam('estimate_number');
            addParam('issue_date');
            addParam('expiry_date');



            var status = $('select[name=\'status\']').val();

            if (status) {
                url += '&status=' + encodeURIComponent(status);
            }




            location = '{{url("/")}}' + '/estimate/list?filters=true' + url;


        });
    });
</script>

<script>
    $("#issue_date").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        autoUpdateInput: false, // Keep input field empty initially
        locale: {
            format: "YYYY-M-DD"
        }
    }, function(start, end) {
        // When a user selects a date range, update the input field
        $('#issue_date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

        // Calculate total days selected
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total Days Selected: " + daysSelected);
    });

    // Optional: Clear input field when clicking "Cancel" in the date picker
    $('#issue_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });


    $("#expiry_date").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        autoUpdateInput: false, // Keep input field empty initially
        locale: {
            format: "YYYY-M-DD"
        }
    }, function(start, end) {
        // When a user selects a date range, update the input field
        $('#expiry_date').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

        // Calculate total days selected
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total Days Selected: " + daysSelected);
    });

    // Optional: Clear input field when clicking "Cancel" in the date picker
    $('#expiry_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>