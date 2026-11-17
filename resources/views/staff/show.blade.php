@extends('layouts.app')

@section('title', 'Staff Details - POS System')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-1">Staff Details</h2>
        <p class="text-muted mb-0">
            View staff account information.
        </p>
    </div>

    <a href="{{ route('staff.index') }}"
       class="btn btn-secondary">
        Back to Staff
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <div class="row g-4">

            <div class="col-md-4 text-center">
                @if($staff->avatar)
                    <img src="{{ asset('storage/' . $staff->avatar) }}"
                         alt="{{ $staff->full_name }}"
                         width="200"
                         height="200"
                         class="rounded-circle border"
                         style="object-fit: cover;">
                @else
                    <div class="bg-secondary text-white rounded-circle
                                d-flex align-items-center justify-content-center mx-auto"
                         style="width:200px; height:200px; font-size:64px;">
                        {{ strtoupper(substr($staff->full_name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                <h4 class="fw-bold mb-4">
                    {{ $staff->full_name }}
                </h4>

                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th width="35%">Staff ID</th>
                            <td>{{ $staff->id }}</td>
                        </tr>

                        <tr>
                            <th>Username</th>
                            <td>{{ $staff->username }}</td>
                        </tr>

                        <tr>
                            <th>Full Name</th>
                            <td>{{ $staff->full_name }}</td>
                        </tr>

                        <tr>
                            <th>Date Created</th>
                            <td>
                                {{ $staff->created_at?->format('F d, Y h:i A') ?? 'N/A' }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('staff.edit', $staff) }}"
                       class="btn btn-warning">
                        Edit Staff
                    </a>

                    <a href="{{ route('staff.index') }}"
                       class="btn btn-secondary">
                        Back
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
