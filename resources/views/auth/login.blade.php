<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Login - POS Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .login-card {
            max-width: 420px;
            width: 100%;
            border: none;
            border-radius: 14px;
        }

        .login-header {
            color: #1e293b;
        }

        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

<div class="card login-card shadow-sm">
    <div class="card-body p-4 p-md-5">

        <h3 class="login-header fw-bold text-center">
            POS Management System
        </h3>

        <p class="text-muted text-center mb-4">
            Sign in to your staff account
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="{{ old('username') }}"
                       autocomplete="username"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       autocomplete="current-password"
                       required>
            </div>

            <button type="submit"
                    class="btn btn-primary w-100">
                Sign In
            </button>
        </form>

    </div>
</div>

</body>
</html>
