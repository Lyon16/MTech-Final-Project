@extends('layouts.app')

@section('title', 'Record Sale - POS System')

@section('content')

<div class="mb-4">
    <h2 class="page-title">Record Sale</h2>
    <p class="text-muted">
        Record a new transaction and automatically update inventory.
    </p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Unable to record sale.</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="product_id" class="form-label">
                    Product <span class="text-danger">*</span>
                </label>

                <select name="product_id"
                        id="product_id"
                        class="form-select @error('product_id') is-invalid @enderror"
                        required>
                    <option value="">Select a product</option>

                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                                data-price="{{ $product->price }}"
                                data-stock="{{ $product->stock_quantity }}"
                                @selected(old('product_id') == $product->id)>
                            {{ $product->name }}
                            — ₱{{ number_format($product->price, 2) }}
                            ({{ $product->stock_quantity }} available)
                        </option>
                    @endforeach
                </select>

                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="customer_id" class="form-label">
                    Customer (Optional)
                </label>

                <select name="customer_id"
                        id="customer_id"
                        class="form-select @error('customer_id') is-invalid @enderror">
                    <option value="">Walk-in Customer</option>

                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                                @selected(old('customer_id') == $customer->id)>
                            {{ $customer->full_name }}
                        </option>
                    @endforeach
                </select>

                @error('customer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">
                    Quantity <span class="text-danger">*</span>
                </label>

                <input type="number"
                       name="quantity"
                       id="quantity"
                       class="form-control @error('quantity') is-invalid @enderror"
                       value="{{ old('quantity', 1) }}"
                       min="1"
                       step="1"
                       required>

                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="bg-light border rounded p-3 mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Available Stock</span>
                    <strong id="available-stock">—</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Estimated Total</span>
                    <strong id="estimated-total">₱0.00</strong>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit"
                        class="btn btn-primary"
                        @if($products->isEmpty()) disabled @endif>
                    Record Sale
                </button>

                <a href="{{ route('sales.index') }}"
                   class="btn btn-secondary">
                    Sales History
                </a>
            </div>

        </form>

        @if($products->isEmpty())
            <div class="alert alert-warning mt-3 mb-0">
                No products with available stock.
                Add or restock a product before recording a sale.
            </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const stockDisplay = document.getElementById('available-stock');
    const totalDisplay = document.getElementById('estimated-total');

    function updateEstimate() {
        const option = productSelect.selectedOptions[0];

        if (!option || !option.value) {
            stockDisplay.textContent = '—';
            totalDisplay.textContent = '₱0.00';
            return;
        }

        const price = Number(option.dataset.price || 0);
        const stock = Number(option.dataset.stock || 0);
        const quantity = Number(quantityInput.value || 0);

        stockDisplay.textContent = stock;

        const total = price * Math.max(0, quantity);

        totalDisplay.textContent = '₱' + total.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    productSelect.addEventListener('change', updateEstimate);
    quantityInput.addEventListener('input', updateEstimate);

    updateEstimate();
});
</script>
@endpush
