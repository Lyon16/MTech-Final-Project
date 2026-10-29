@extends('layouts.app')

@section('title', 'Dashboard - POS System')

@section('content')

<h2 class="page-title mb-2">Dashboard</h2>
<p class="text-muted mb-4">
    Welcome to the POS Management System.
</p>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h6 class="text-muted">Products</h6>
                <h2 class="fw-bold">0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h6 class="text-muted">Customers</h6>
                <h2 class="fw-bold">0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h6 class="text-muted">Sales</h6>
                <h2 class="fw-bold">0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h6 class="text-muted">Revenue</h6>
                <h2 class="fw-bold">₱0.00</h2>
            </div>
        </div>
    </div>

</div>

@endsection
