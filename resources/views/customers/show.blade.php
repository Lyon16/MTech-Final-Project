@extends('layouts.app')

@section('title', 'Customer Details - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Customer Details</h2>
        <p class="text-muted mb-0">
            View customer account information.
        </p>
    </div>

    <a href="{{ route('customers.index') }}"
       class="btn btn-secondary">
        Back to Customers
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h5 class="mb-4">Account Information</h5>

        <table class="table table-bordered align-middle">
            <tbody>
                <tr>
                    <th width="30%">Customer ID</th>
                    <td>{{ $customer->id }}</td>
                </tr>

                <tr>
                    <th>Full Name</th>
                    <td>{{ $customer->full_name }}</td>
                </tr>

                <tr>
                    <th>Email Address</th>
                    <td>{{ $customer->email }}</td>
                </tr>

                <tr>
                    <th>Phone Number</th>
                    <td>{{ $customer->phone ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Date Created</th>
                    <td>
                        {{ $customer->created_at?->format('F d, Y h:i A') ?? 'N/A' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('customers.edit', $customer) }}"
               class="btn btn-warning">
                Edit Customer
            </a>

            <a href="{{ route('customers.index') }}"
               class="btn btn-secondary">
                Back
            </a>
        </div>

    </div>
</div>

@endsection
