@extends('layouts.app')

@section('title', 'Add Customer - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title">Add New Customer</h2>
    <p class="text-muted">
        Enter the customer's information below.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

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
                <label for="email" class="form-label">
                    Email Address <span class="text-danger">*</span>
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       maxlength="100"
                       required>

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="form-label">
                    Phone Number
                </label>

                <input type="text"
                       id="phone"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}"
                       maxlength="20">

                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Save Customer
                </button>

                <a href="{{ route('customers.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
