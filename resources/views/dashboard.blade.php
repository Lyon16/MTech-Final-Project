@extends('layouts.app')

@section('title', 'Dashboard - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title mb-1">Dashboard</h2>
    <p class="text-muted">
        Welcome back, {{ auth()->user()->full_name }}!
        Here's an overview of your POS system.
    </p>
</div>

<div class="row g-4">

    <!-- Total Products -->
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="text-muted">Total Products</h6>

                <h2 class="fw-bold text-primary">
                    {{ number_format($totalProducts) }}
                </h2>

                <small class="text-muted">
                    Products in inventory
                </small>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="text-muted">Total Customers</h6>

                <h2 class="fw-bold text-success">
                    {{ number_format($totalCustomers) }}
                </h2>

                <small class="text-muted">
                    Registered customers
                </small>
            </div>
        </div>
    </div>

    <!-- Total Sales -->
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="text-muted">Total Sales</h6>

                <h2 class="fw-bold text-warning">
                    {{ number_format($totalSales) }}
                </h2>

                <small class="text-muted">
                    Recorded transactions
                </small>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h6 class="text-muted">Total Revenue</h6>

                <h2 class="fw-bold text-info">
                    ₱{{ number_format($totalRevenue, 2) }}
                </h2>

                <small class="text-muted">
                    Revenue from recorded sales
                </small>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm mt-4">
    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">Quick Actions</h5>

        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('products.index') }}"
               class="btn btn-outline-primary">
                Manage Products
            </a>

            <a href="{{ route('customers.index') }}"
               class="btn btn-outline-primary">
                Manage Customers
            </a>

            <a href="{{ route('staff.index') }}"
               class="btn btn-outline-primary">
                Manage Staff
            </a>

            <a href="{{ route('sales.create') }}"
               class="btn btn-primary">
                Record Sale
            </a>

            <a href="{{ route('sales.index') }}"
               class="btn btn-outline-secondary">
                Sales History
            </a>

        </div>

    </div>
</div>

@endsection
