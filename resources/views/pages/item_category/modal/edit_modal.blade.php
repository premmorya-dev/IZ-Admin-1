
    <!-- Edit Category Model -->
    <div class="modal fade" id="editItemCategory-modal" tabindex="-1" aria-labelledby="editItemCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white rounded-top-3">
                    <h4 class="modal-title" id="editItemCategoryModalLabel">Edit Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="editItemCategory-modal-body py-3 px-3">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).on('click', '.edit-item-category, .item-category-name', function(e) {
            e.preventDefault();
            $('.editItemCategory-modal-body').empty();

            var item_category_code = $(this).attr('item-category-code');

            try {

                var editors = {}; // store editors globally so they are not reinitialized

                $.ajax({
                    url: "{{ route('item.category.edit') }}",
                    data: {
                        item_category_code: item_category_code
                    },
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {

                        $('.editItemCategory-modal-body').html(response);
                        $('#editItemCategory-modal').modal('show');
                    }
                });

            } catch (error) {
                console.error('Error:', error);
            }


        });
    </script>