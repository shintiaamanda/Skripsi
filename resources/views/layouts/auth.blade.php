<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — SIBk SMKN 3 Padang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem;
        }

        .auth-logo {
            width: 56px;
            height: 56px;
            background: #1e40af;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .auth-logo i {
            font-size: 1.6rem;
            color: #fff;
        }

        .auth-title {
            font-weight: 700;
            color: #0f172a;
            text-align: center;
            font-size: 1.4rem;
            margin-bottom: 0.25rem;
        }

        .auth-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1.5px solid #e2e8f0;
            padding: 0.6rem 0.85rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30,64,175,0.1);
        }

        .btn-auth {
            background: #1e40af;
            border: none;
            border-radius: 0.5rem;
            padding: 0.7rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #fff;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-auth:hover {
            background: #1e3a8a;
            color: #fff;
        }

        .is-invalid {
            border-color: #ef4444 !important;
        }

        .invalid-feedback {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-heart-pulse"></i>
        </div>
        <h1 class="auth-title">SIBk</h1>
        <p class="auth-subtitle">Sistem Informasi Bimbingan Konseling<br>SMKN 3 Padang</p>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
