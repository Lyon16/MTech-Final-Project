@extends('layouts.app')

@section('title', 'Sales History - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Sales History</h2>
        <p class="text-muted mb-0">
            View recorded POS transactions.
        </p>
    </div>

    <a href="{{ route('sales.create') }}"
       class="btn btn-primary">
        + Record New Sale
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h5 class="mb-4">Transaction Records</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Sale ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Sold By</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>

                            <td>
                                {{ $sale->product?->name ?? 'Deleted Product' }}
                            </td>

                            <td>
                                {{ $sale->customer?->full_name ?? 'Walk-in Customer' }}
                            </td>

                            <td>
                                {{ $sale->staff?->full_name ?? 'Unavailable Staff' }}
                            </td>

                            <td>{{ $sale->quantity }}</td>

                            <td class="fw-semibold">
                                ₱{{ number_format($sale->total_price, 2) }}
                            </td>

                            <td>
                                {{ $sale->created_at?->format('M d, Y h:i A') ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-4">
                                No sales transactions recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $sales->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
