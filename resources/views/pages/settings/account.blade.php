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


</form>

</x-default-layout>