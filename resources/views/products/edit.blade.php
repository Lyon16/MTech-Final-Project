@extends('layouts.app')

@section('title', 'Edit Product - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title">Edit Product</h2>
    <p class="text-muted">
        Update the product information below.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('products.update', $product) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">
                    Product Name <span class="text-danger">*</span>
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}"
                       maxlength="100"
                       required>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">
                    Price (₱) <span class="text-danger">*</span>
                </label>

                <input type="number"
                       id="price"
                       name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}"
                       min="0"
                       step="0.01"
                       required>

                @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock_quantity" class="form-label">
                    Stock Quantity <span class="text-danger">*</span>
                </label>

                <input type="number"
                       id="stock_quantity"
                       name="stock_quantity"
                       class="form-control @error('stock_quantity') is-invalid @enderror"
                       value="{{ old('stock_quantity', $product->stock_quantity) }}"
                       min="0"
                       step="1"
                       required>

                @error('stock_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Current Product Image</label>

                <div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             width="120"
                             height="120"
                             class="rounded border"
                             style="object-fit: cover;">
                    @else
                        <p class="text-muted">No image uploaded.</p>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">
                    Replace Product Image (Optional)
                </label>

                <input type="file"
                       id="image"
                       name="image"
                       class="form-control @error('image') is-invalid @enderror"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Leave blank to keep the current image.
                    JPG or PNG only, maximum 2 MB.
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Update Product
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
