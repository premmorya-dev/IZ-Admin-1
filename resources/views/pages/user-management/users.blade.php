<x-default-layout>

    @section('title')
    User Management
    @endsection

    @section('breadcrumbs')
    {{ Breadcrumbs::render('user.list') }}
    @endsection

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ isset($editUser) ? 'Edit User' : 'Add New User' }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($editUser) ? route('user.update', $editUser->user_id) : route('user.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $editUser->first_name ?? '') }}" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter first name">
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $editUser->last_name ?? '') }}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter last name">
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $editUser->email ?? '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="user_name" value="{{ old('user_name', $editUser->user_name ?? '') }}" class="form-control @error('user_name') is-invalid @enderror" placeholder="Enter username">
                                @error('user_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">Select a role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role', $editUser->roles->first()->name ?? '') === $role->name ? 'selected' : '' }}>{{ ucwords($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            @if(isset($editUser))
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status', $editUser->status) === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $editUser->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary w-100">{{ isset($editUser) ? 'Update User' : 'Create User' }}</button>
                        </form>

                        @if(isset($editUser))
                            <a href="{{ route('user.list') }}" class="btn btn-link mt-3">Cancel edit</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Team Members</h5>
                        <a href="{{ route('user.add') }}" class="btn btn-outline-primary btn-sm">Add User</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->user_id }}</td>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->user_name }}</td>
                                            <td>{{ $user->roles->first()->name ?? '—' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }} text-capitalize">{{ $user->status }}</span>
                                            </td>
                                            <td>{{ optional($user->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->user_id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <form action="{{ route('user.delete', $user->user_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
