<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen List SOP') - CRUD Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
            color: #1f2937;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }
        .navbar-brand {
            letter-spacing: 0.02em;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }
        .nav-link:hover,
        .nav-link.active {
            color: #ffffff;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            color: #1f2937;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0;
            background: #f8f9fa;
            color: #1f2937;
        }
        .btn {
            border-radius: 0.9rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .btn-primary,
        .btn-success,
        .btn-warning,
        .btn-info,
        .btn-secondary,
        .btn-danger {
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }
        .table thead th {
            border-bottom: 2px solid rgba(15, 23, 42, 0.08);
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control,
        .form-select,
        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff;
            color: #1f2937;
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: none;
        }
        .form-control::placeholder {
            color: rgba(148, 163, 184, 0.8);
        }
        .form-control.is-invalid,
        .form-select.is-invalid {
            background-color: #f8fafc;
        }
        .alert ul {
            margin-bottom: 0;
        }
        .alert a {
            color: #2563eb;
        }
        footer {
            color: rgba(107, 114, 128, 0.9);
        }
        .hero-card {
            background: #ffffff;
            border-radius: 1.35rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }
    </style>
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-lg">
            <a class="navbar-brand fw-bold" href="{{ route('list_sop.index') }}">📋 Manajemen List SOP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list_sop.index') }}">Daftar SOP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('list_sop.create') }}">Buat Baru</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>⚠️ Errors Found:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="mt-5 py-4 bg-light border-top">
        <div class="container-lg text-center text-muted">
            <p class="mb-0">&copy; 2025 Sistem List SOP. Dibangun dengan Laravel & Bootstrap.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>
