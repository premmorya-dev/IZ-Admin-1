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
                                <label for="client_name" class="form-label">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" value="{{ request('client_name') }}" placeholder="Type to search client..." autocomplete="off">
                                <div id="clientList" class="list-group" style="position: absolute; z-index: 1000;"></div>
                            </div>

                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" multiple multiselect-max-items="1" multiselect-search="true">
                                    <option value="active" {{ in_array('active', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Active</option>
                                    <option value="deactive" {{ in_array('deactive', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Deactive</option>

                                </select>
                            </div>

                            <div class="col-md-3 ">
                                <label for="company_name" class="form-label">Company</label>
                                <input type="text" name="company_name" value="{{ request('company_name') }}" id="company_name" placeholder="Company Name" class="form-control">
                            </div>


                            <div class="col-md-3 ">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" value="{{ request('email') }}" id="email" placeholder="Email" class="form-control">
                            </div>

                            <div class="col-md-3 ">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" name="phone" value="{{ request('phone') }}" id="phone" placeholder="Phone" class="form-control">
                            </div>

                            <div class="col-md-3 ">
                                <label for="gst_number" class="form-label">Gst Number</label>
                                <input type="number" name="gst_number" value="{{ request('gst_number') }}" id="gst_number" placeholder="Gst Number" class="form-control">
                            </div>




                            <div class="col-md-3 ">
                                <label for="country_id" class="form-label">Country</label>
                                <select id="country_id" name="country_id" class="form-select" multiple multiselect-search="true">
                                    @foreach($data['countries'] as $country)
                                    <option value="{{ $country->country_id }}" {{ in_array($country->country_id, (array) explode(",", request('country_id'))) ? 'selected' : '' }}>
                                        {{ $country->country_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 ">
                                <label for="state_id" class="form-label">State</label>
                                <select id="state_id" name="state_id" class="form-select" multiple multiselect-search="true">
                                    <!-- States will be loaded dynamically -->
                                </select>

                            </div>




                            <div class="col-md-3">
                                <label class="form-label">Created At</label>
                                <div class="input-group">
                                    <input type="text" name="created_at" id="created_at" value="{{ request('created_at') }}" class="form-control date-range" placeholder="Pick Issue Date Range">
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
                                <a href="{{ route('client.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-eraser-fill"></i> Reset</a>
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
            addParam('client_name');
            addParam('company_name');

            addParam('email');
            addParam('phone');
            addParam('gst_number');
            addParam('created_at');

            var status = $('select[name=\'status\']').val();

            if (status) {
                url += '&status=' + encodeURIComponent(status);
            }
            var country_id = $('select[name=\'country_id\']').val();

            if (country_id) {
                url += '&country_id=' + encodeURIComponent(country_id);
            }

            var state_id = $('select[name=\'state_id\']').val();

            if (state_id) {
                url += '&state_id=' + encodeURIComponent(state_id);
            }




            location = '{{url("/")}}' + '/client/list?filters=true' + url;


        });
    });
</script>

<script>
    $("#created_at").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        autoUpdateInput: false, // Keep input field empty initially
        locale: {
            format: "YYYY-M-DD"
        }
    }, function(start, end) {
        // When a user selects a date range, update the input field
        $('#created_at').val(start.format("YYYY-M-DD") + " - " + end.format("YYYY-M-DD"));

        // Calculate total days selected
        var daysSelected = end.diff(start, 'days');
        $("#total_days").text("Total Days Selected: " + daysSelected);
    });

    // Optional: Clear input field when clicking "Cancel" in the date picker
    $('#created_at').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
</script>

<script>
    function refreshStates(selectedCountries) {
        // AJAX Call to fetch states
        $.ajax({
            type: "GET",
            url: "{{ route('get.states.by.country') }}",
            data: {
                country_id: selectedCountries
            },
            dataType: "json",
            success: function(response) {

                console.log(response.states)
                // Clear previous states
                $('#state_id').html('');

                // Append new state options
                $.each(response.states, function(key, state) {
                    $('#state_id').append(`<option value="${state.state_id}">${state.state_name}</option>`);
                });

                // Refresh the multiselect dropdown
                document.getElementById('state_id').loadOptions();

                let selectedState = "{{ request('state_id') }}".split(',').map(String);
                $('#state_id').val(selectedState).trigger('change');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching states:', error);
            }
        });
    }
    $(document).ready(function() {
        // Country change event
        $('#country_id').on('change', function() {
            var selectedCountries = $(this).val(); // Get selected country IDs (array)
            refreshStates(selectedCountries);
        });

        let country_id = "{{ request('country_id') }}";
        if (country_id) {
            let country = country_id.split(',').map(Number);
            $('#country_id').val(country).trigger('change'); // Preselect
            refreshProgramsBySeoUrls(country); // Load programs
        }


    });


    $(document).ready(function() {
        $('#client_name').keyup(function() {
            var query = $(this).val();

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('client.search2') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#clientList').fadeIn();
                        $('#clientList').html(data);
                    }
                });
            } else {
                $('#clientList').fadeOut();
            }
        });

        // Click to set the client name
        $(document).on('click', '.client-item', function() {
            $('#client_name').val($(this).text());
            $('#clientList').fadeOut();
        });

        // Click outside to hide
        $(document).click(function(e) {
            if (!$(e.target).closest('#client_name, #clientList').length) {
                $('#clientList').fadeOut();
            }
        });
    });


</script>