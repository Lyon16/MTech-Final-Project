@extends('layouts.app')

@section('title', 'Customer Accounts - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Customer Accounts</h2>
        <p class="text-muted mb-0">
            View and manage customer information.
        </p>
    </div>

    <a href="{{ route('customers.create') }}"
       class="btn btn-primary">
        + Add New Customer
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h5 class="mb-4">Customer List</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->full_name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>

                            <td>
                                <a href="{{ route('customers.show', $customer) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>

                                <a href="{{ route('customers.edit', $customer) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('customers.destroy', $customer) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this customer?');">
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
                            <td colspan="5"
                                class="text-center text-muted py-4">
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
