<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>@yield('title', 'POS Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #1e293b;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .page-title {
            font-weight: bold;
            color: #1e293b;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .table thead th {
            background-color: #1e293b;
            color: white;
        }
    </style>

    @stack('styles')
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a class="navbar-brand" href="/">
            POS Management System
        </a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/">Dashboard</a>
            <a class="nav-link" href="/products">Products</a>
            <a class="nav-link" href="/customers">Customers</a>
            <a class="nav-link" href="/staff">Staff</a>
            <a class="nav-link" href="/sales/create">Record Sale</a>
            
@auth
    <span class="navbar-text text-light me-3">
        {{ auth()->user()->full_name }}
    </span>
@endauth

@auth
    <form action="{{ route('logout') }}"
          method="POST"
          class="d-flex align-items-center ms-lg-3">
        @csrf

        <button type="submit"
                class="btn btn-outline-light btn-sm">
            Logout
        </button>
    </form>
@endauth

        </div>

    </div>
</nav>

<main class="container py-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
