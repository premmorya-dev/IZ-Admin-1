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



                            <div class="col-md-3 ">
                                <label for="item_name" class="form-label">Item Name</label>
                                <input type="text" name="item_name" value="{{ request('item_name') }}" id="item_name" placeholder="Item Name" class="form-control">
                            </div>


                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" multiple multiselect-max-items="1" multiselect-search="true">
                                    <option value="Y" {{ in_array('Y', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Active</option>
                                    <option value="N" {{ in_array('N', (array) explode("," , request('status') )  ) ? 'selected' : '' }}>Deactive</option>

                                </select>
                            </div>



                          <div class="col-md-3">
                                <label for="item_type" class="form-label">Type</label>
                                <select id="item_type" name="item_type" class="form-select" >
                                     <option value=""><--Select--></option>
                                    <option value="product" {{ in_array('product', (array) explode("," , request('item_type') )  ) ? 'selected' : '' }}>Product</option>
                                    <option value="service" {{ in_array('service', (array) explode("," , request('item_type') )  ) ? 'selected' : '' }}>Service</option>
                                </select>
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
                                <a href="{{ route('item.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-eraser-fill"></i> Reset</a>
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
            addParam('item_name');
            addParam('item_type', 'select');
            addParam('hsn_sac');

            var status = $('select[name=\'status\']').val();

            if (status) {
                url += '&status=' + encodeURIComponent(status);
            }




            location = '{{url("/")}}' + '/item/list?filters=true' + url;


        });
    });
</script>


