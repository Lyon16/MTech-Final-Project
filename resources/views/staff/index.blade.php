@extends('layouts.app')

@section('title', 'Staff Accounts - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Staff Accounts</h2>
        <p class="text-muted mb-0">
            View and manage staff accounts.
        </p>
    </div>

    <a href="{{ route('staff.create') }}"
       class="btn btn-primary">
        + Add New Staff
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <h5 class="mb-4">Staff List</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Avatar</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($staff as $member)
                        <tr>
                            <td>
                                @if($member->avatar)
                                    <img
                                        src="{{ asset('storage/' . $member->avatar) }}"
                                        alt="{{ $member->full_name }}"
                                        width="55"
                                        height="55"
                                        class="rounded-circle border"
                                        style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle
                                                d-flex align-items-center justify-content-center"
                                         style="width:55px; height:55px;">
                                        {{ strtoupper(substr($member->full_name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            <td>{{ $member->id }}</td>

                            <td>{{ $member->username }}</td>

                            <td class="fw-semibold">
                                {{ $member->full_name }}

                                @if(auth()->id() === $member->id)
                                    <span class="badge bg-primary ms-1">
                                        You
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $member->created_at?->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <a href="{{ route('staff.show', $member) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>

                                <a href="{{ route('staff.edit', $member) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                @if(auth()->id() !== $member->id)
                                    <form action="{{ route('staff.destroy', $member) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this staff account?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-4">
                                No staff accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $staff->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>

@endsection
