<x-default-layout>
      <h2 class="py-3">Account Settings</h2>
  
    <form action="{{ route('settings.account.update') }}" method="POST">
    @csrf

    <div class="page-header-fixed mb-3 d-flex justify-content-between align-items-center">
        <div><a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary btn-sm"> <i data-lucide="arrow-left"></i> Back </a></div>
        <button type="submit" class="btn btn-primary btn-sm "><i data-lucide="save"></i> Save Settings</button>
    </div>

    <fieldset class="border p-3 rounded mt-4">
        <legend class="w-auto mb-5">Account Details</legend>
        <div class="row">
            <div class="col-md-4 mt-4">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name"
                       class="form-control @error('first_name') is-invalid @enderror"
                       value="{{ old('first_name', Auth::user()->first_name ?? '') }}">
                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 mt-4">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name"
                       class="form-control @error('last_name') is-invalid @enderror"
                       value="{{ old('last_name', Auth::user()->last_name ?? '') }}">
                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 mt-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" readonly id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', Auth::user()->email ?? '') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 mt-4">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                       class="form-control @error('current_password') is-invalid @enderror"
                       placeholder="********">
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 mt-4">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password"
                       class="form-control @error('new_password') is-invalid @enderror"
                       placeholder="********">
                @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4 mt-4">
                <label for="confirm_password" class="form-label">New Password (confirm)</label>
                <input type="password" name="confirm_password" id="confirm_password"
                       class="form-control @error('confirm_password') is-invalid @enderror"
                       placeholder="********">
                @error('confirm_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="border p-3 rounded mt-4">
        <legend class="w-auto mb-5">Address & Company Details</legend>
        <div class="row">
            <div class="col-md-6 mt-4">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" name="company_name" id="company_name"
                       class="form-control @error('company_name') is-invalid @enderror"
                       value="{{ old('company_name', $data['setting']->company_name ?? '') }}">
                @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mt-4">
                <label for="is_company" class="form-label">Business Type</label>
                <select name="is_company" id="is_company"
                        class="form-select @error('is_company') is-invalid @enderror">
                    <option value="Y" {{ old('is_company', $data['setting']->is_company ?? '') == 'Y' ? 'selected' : '' }}>Organisation</option>
                    <option value="N" {{ old('is_company', $data['setting']->is_company ?? '') == 'N' ? 'selected' : '' }}>Individual</option>
                </select>
                @error('is_company')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mt-4">
                <label for="address_1" class="form-label">Address Line 1</label>
                <input type="text" name="address_1" id="address_1" class="form-control"
                       value="{{ old('address_1', $data['setting']->address_1 ?? '') }}">
            </div>

            <div class="col-md-6 mt-4">
                <label for="address_2" class="form-label">Address Line 2</label>
                <input type="text" name="address_2" id="address_2" class="form-control"
                       value="{{ old('address_2', $data['setting']->address_2 ?? '') }}">
            </div>

            <div class="col-md-6 mt-4">
                <label for="country_id" class="form-label">Country</label>
                <select name="country_id" id="country_id"
                        class="form-select @error('country_id') is-invalid @enderror">
                    <option value="">-- Select Country --</option>
                    @foreach($data['countries'] as $country)
                        <option value="{{ $country->country_id }}"
                                {{ old('country_id', $data['setting']->country_id ?? '') == $country->country_id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mt-4">
                <label for="state_id" class="form-label">State</label>
                <select name="state_id" id="state_id"
                        class="form-select @error('state_id') is-invalid @enderror">
                    <option value="">-- Select State --</option>
                    @foreach($data['states']->where('country_id', $data['setting']->country_id) as $state)
                        <option value="{{ $state->state_id }}"
                                {{ old('state_id', $data['setting']->state_id ?? '') == $state->state_id ? 'selected' : '' }}>
                            {{ $state->state_name }}
                        </option>
                    @endforeach
                </select>
                @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6 mt-4">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" name="pincode" id="pincode"
                       class="form-control @error('pincode') is-invalid @enderror"
                       value="{{ old('pincode', $data['setting']->pincode ?? '') }}">
                @error('pincode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>
</form>




    <script>
        $(document).ready(function() {
            $('#country_id').on('change', function() {
                var countryID = $(this).val();
                $('#state_id').html('<option value="">Loading...</option>');
                if (countryID) {
                    $.ajax({
                        url: "{{ route('get.states.by.country') }}",
                        type: "GET",
                        data: {
                            country_id: countryID
                        },
                        success: function(res) {
                            $('#state_id').empty().append('<option value="">-- Select State --</option>');
                            $.each(res.states, function(key, state) {
                                $('#state_id').append('<option value="' + state.state_id + '">' + state.state_name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state_id').html('<option value="">-- Select State --</option>');
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {
          
            $('#country_id').select2({
                placeholder: "Choose Country",
                allowClear: true
            });


            $('#state_id').select2({
                placeholder: "Choose State",
                allowClear: true
            });

            $('#default_currency').select2({
                placeholder: "Choose Default Currency",
                allowClear: true
            });

          
        });
    </script>

</x-default-layout>