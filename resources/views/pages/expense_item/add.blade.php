  <form action="{{ route('expense.item.store') }}" id="add-expense_item-form" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')

      <div class="card shadow-lg border-0 rounded-4">

          <div class="card-body p-4 row">

              <div class="col-md-12 mt-3">
                  <label class="form-label">Name</label>
                  <input type="text" name="expense_item_name" value="{{ old('expense_item_name') }}" class="form-control" placeholder="Expense Item Name">
              </div>

              <div class="col-md-12 mt-3">
                  <label class="form-label">Expense Category</label>
                  <select name="expense_category_id" class="form-select">
                      @foreach( $data['expense_categories'] as $expense_categories )
                      <option value="{{ $expense_categories->expense_category_id }}" {{ old('expense_category_id')   == $expense_categories->expense_category_id ? 'selected' : '' }}>{{ $expense_categories->expense_category_name  }}</option>

                      @endforeach
                  </select>
              </div>


              <div class="col-md-6 mt-3">
                  <label class="form-label">Hsn/Sac</label>
                  <input type="number" name="hsn_sac" value="{{ old('hsn_sac') }}" class="form-control" placeholder="HSN/SAC">
              </div>

              <div class="col-md-6 mt-3">
                  <label class="form-label">Unit Price</label>
                  <input type="number" name="unit_price" value="{{ old('unit_price') }}" class="form-control" placeholder="Unit Price">
              </div>



              <div class="col-md-6 mt-3">
                  <label class="form-label">Type</label>
                  <select name="expense_item_type" class="form-select">
                      <option value="product" {{ old('expense_item_type' )   == 'product' ? 'selected' : '' }}>Product</option>
                      <option value="service" {{ old('expense_item_type' )  == 'service' ? 'selected' : '' }}>Service</option>
                  </select>
              </div>

              <div class="col-md-6 mt-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select">
                      <option value="Y" {{ old('status' )   == 'Y' ? 'selected' : '' }}>Active</option>
                      <option value="N" {{ old('status' )  == 'N' ? 'selected' : '' }}>Deactive</option>
                  </select>
              </div>

              <div class="col-md-12 mt-3">
                  <label for="tax_id" class="form-label">Tax</label>
                  <select id="tax_id" name="tax_id" class="form-select">
                      <option value="0">No Tax</option>
                      @foreach($data['taxes'] as $tax )
                      <option value="{{ $tax->tax_id }}" {{ old('tax_id' ?? '') == $tax->tax_id ? 'selected' : '' }}>{{ $tax->name }} | {{ $tax->percent }}%</option>
                      @endforeach
                  </select>
              </div>

              <div class="col-md-12 mt-3">
                  <label for="discount_id" class="form-label">Discount</label>
                  <select id="discount_id" name="discount_id" class="form-select">
                      <option value="0">No Discount</option>
                      @foreach($data['discounts'] as $discount )
                      <option value="{{ $discount->discount_id }}" {{ old('discount_id' ?? '') == $discount->discount_id ? 'selected' : '' }}>{{ $discount->name }} | {{ $discount->percent }}%</option>
                      @endforeach
                  </select>
              </div>



              <div class="card-footer bg-light text-end rounded-bottom-4">

                  <button type="submit" class="btn btn-success px-4 add-expense-item w-100">
                      <i class="fas fa-save me-1"></i> Update Expense Item
                  </button>
              </div>
          </div>
      </div>
  </form>


  <script>
      document.querySelector('.add-expense-item').addEventListener('click', function(e) {
          e.preventDefault();



          const form = document.getElementById('add-expense_item-form');
          const formData = new FormData(form);

          Swal.fire({
              title: "Updating...",
              text: "Please wait while we adding the expense item.",
              allowOutsideClick: false,
              didOpen: () => {
                  Swal.showLoading();
              }
          });

          $.ajax({
              url: form.action,
              method: "POST",
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              beforeSend: function() {
                  $('.error').remove();
                  $('.is-invalid').removeClass('is-invalid');
              },
              success: function(response) {
                  Swal.close();
                  if (response.error === 1) {
                      $.each(response.errors, function(field, messages) {
                          let inputField = $('[name="' + field + '"]');
                          if (inputField.length) {
                              inputField.addClass('is-invalid');
                              const errorHtml = `<div class="text-danger error">${messages[0]}</div>`;

                              if (inputField.closest('.input-group').length) {
                                  inputField.closest('.input-group').after(errorHtml);
                              } else if (inputField.hasClass('select2-hidden-accessible')) {
                                  inputField.next('.select2-container').after(errorHtml);
                              } else {
                                  inputField.after(errorHtml);
                              }
                          }
                      });
                      Swal.fire({
                          icon: "warning",
                          title: "Warning!",
                          text: "Please fix the errors.",
                          position: "center",
                          toast: true,
                          showConfirmButton: false,
                          timer: 3000
                      });
                  } else {
                      Swal.fire({
                          icon: "success",
                          title: "Expense Item Added Successfully!",
                          text: response.message,
                          position: "center",
                          toast: false,
                          showConfirmButton: false,
                          timer: 2000
                      }).then(function() {
                          window.location.href = "{{ route('expense.item.list') }}";
                      });
                  }
              },
              error: function(xhr) {
                  Swal.close();
                  console.error("Error:", xhr.responseText);
              }
          });
      });
  </script>