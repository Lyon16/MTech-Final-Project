@extends('layouts.app')

@section('title', 'Products - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Product Management</h2>
        <p class="text-muted mb-0">
            View and manage product inventory.
        </p>
    </div>

    <a href="{{ route('products.create') }}"
       class="btn btn-primary">
        + Add New Product
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h5 class="mb-4">Product List</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         width="60"
                                         height="60"
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="bg-light border rounded d-flex
                                                align-items-center justify-content-center"
                                         style="width:60px; height:60px;">
                                        <span class="text-muted small">No Image</span>
                                    </div>
                                @endif
                            </td>

                            <td>{{ $product->id }}</td>

                            <td class="fw-semibold">
                                {{ $product->name }}
                            </td>

                            <td>
                                ₱{{ number_format($product->price, 2) }}
                            </td>

                            <td>
                                @if($product->stock_quantity <= 0)
                                    <span class="badge bg-danger">
                                        Out of Stock
                                    </span>
                                @elseif($product->stock_quantity <= 5)
                                    <span class="badge bg-warning text-dark">
                                        Low: {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        {{ $product->stock_quantity }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('products.show', $product) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>

                                <a href="{{ route('products.edit', $product) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-4">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
