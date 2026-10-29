@extends('layouts.app')

@section('title', 'Product Details - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Product Details</h2>
        <p class="text-muted mb-0">
            View product information and inventory details.
        </p>
    </div>

    <a href="{{ route('products.index') }}"
       class="btn btn-secondary">
        Back to Products
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <div class="row g-4">

            <div class="col-md-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid rounded border w-100"
                         style="max-height: 300px; object-fit: contain;">
                @else
                    <div class="bg-light border rounded d-flex
                                align-items-center justify-content-center"
                         style="height: 250px;">
                        <span class="text-muted">No Image Available</span>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <h4 class="fw-bold mb-4">{{ $product->name }}</h4>

                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="35%">Product ID</th>
                            <td>{{ $product->id }}</td>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Stock Quantity</th>
                            <td>
                                @if($product->stock_quantity <= 0)
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                @elseif($product->stock_quantity <= 5)
                                    <span class="badge bg-warning text-dark">
                                        Low Stock: {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        {{ $product->stock_quantity }} Available
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Date Created</th>
                            <td>
                                {{ $product->created_at?->format('F d, Y h:i A') ?? 'N/A' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('products.edit', $product) }}"
                       class="btn btn-warning">
                        Edit Product
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="btn btn-secondary">
                        Back
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
