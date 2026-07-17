<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WSPTC College Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: var(--wsptc-light);">
    <div class="w-100" style="max-width: 420px;">
        <div class="text-center mb-4">
            <a href="/" class="d-inline-flex align-items-center text-decoration-none">
                <i class="bi bi-mortarboard-fill fs-2 me-2" style="color: var(--wsptc-primary);"></i>
                <span class="fs-4 fw-bold" style="color: var(--wsptc-primary);">WSPTC CMS</span>
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>

        <p class="text-center text-muted small mt-3 mb-0">
            &copy; {{ date('Y') }} Wolaita Sodo Polytechnic College
        </p>
    </div>
</body>
</html>
