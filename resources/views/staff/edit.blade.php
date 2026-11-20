@extends('layouts.app')

@section('title', 'Edit Staff - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title">Edit Staff Account</h2>
    <p class="text-muted">
        Update staff information, password, or avatar.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('staff.update', $staff) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">
                    Username <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="username"
                       name="username"
                       class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username', $staff->username) }}"
                       maxlength="50"
                       required>

                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="full_name" class="form-label">
                    Full Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="full_name"
                       name="full_name"
                       class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name', $staff->full_name) }}"
                       maxlength="100"
                       required>

                @error('full_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">
                    New Password (Optional)
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       minlength="12"
                       autocomplete="new-password">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Leave blank to keep the current password.
                    Minimum 12 characters.
                </small>
            </div>

            <!-- Confirm New Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    Confirm New Password
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="form-control"
                       autocomplete="new-password">
            </div>

            <!-- Current Avatar -->
            <div class="mb-3">
                <label class="form-label">
                    Current Avatar
                </label>

                <div>
                    @if($staff->avatar)
                        <img
                            src="{{ asset('storage/' . $staff->avatar) }}"
                            alt="{{ $staff->full_name }}"
                            width="120"
                            height="120"
                            class="rounded-circle border"
                            style="object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle
                                    d-flex align-items-center justify-content-center"
                             style="width:120px; height:120px; font-size:36px;">
                            {{ strtoupper(substr($staff->full_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Replace Avatar -->
            <div class="mb-4">
                <label for="avatar" class="form-label">
                    Replace Avatar (Optional)
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
                    Leave blank to keep the current avatar.
                    JPG or PNG only, maximum 2 MB.
                    Uploaded avatars are prepared as 300 × 300 JPG images.
                </small>
            </div>

            <!-- Form Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Update Staff
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
