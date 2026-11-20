@extends('layouts.app')

@section('title', 'Add Staff - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title">Add New Staff</h2>
    <p class="text-muted">
        Create a new staff account for the POS system.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('staff.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">
                    Username <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="username"
                       name="username"
                       class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username') }}"
                       maxlength="50"
                       autocomplete="off"
                       required>

                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">
                    Full Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="full_name"
                       name="full_name"
                       class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name') }}"
                       maxlength="100"
                       required>

                @error('full_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    Password <span class="text-danger">*</span>
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       minlength="12"
                       autocomplete="new-password"
                       required>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Use at least 12 characters.
                </small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    Confirm Password <span class="text-danger">*</span>
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control"
                       minlength="12"
                       autocomplete="new-password"
                       required>
            </div>

            <div class="mb-4">
                <label for="avatar" class="form-label">
                    Staff Avatar (Optional)
                </label>

                <input type="file"
                       id="avatar"
                       name="avatar"
                       class="form-control @error('avatar') is-invalid @enderror"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                @error('avatar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    JPG or PNG only. Maximum file size: 2 MB.
                    The image will be prepared as a 300 × 300 avatar.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Save Staff
                </button>

                <a href="{{ route('staff.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
