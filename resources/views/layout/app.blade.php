<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="@yield('meta-description', config('app.description'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary:{{ App\Setting::get('primary_color', '#4361ee') }} !important;
            --primary-dark:{{ App\Setting::get('primary_color', '#4361ee') }} !important;
            --secondary:{{ App\Setting::get('primary_color', '#4361ee') }} !important;
            --dark: #212529;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .bg-primary {
            background-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
        }

        .btn-primary {
            background-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
            border-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
        }

        .btn-outline-primary {
            border-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
            color:{{ App\Setting::get('primary_color', '#4361ee') }} !important;
        }

        .btn-outline-primary:hover {
            background-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
            border-color: {{ App\Setting::get('primary_color', '#4361ee') }} !important;
            color: #ffffff !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .modern-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            background: white;
        }

        .search-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1000px;
            position: relative;
            z-index: 100;
        }

        /* Select2 customization */
        .select2-container {
            width: 100% !important;
            z-index: 1060 !important;
        }

        .select2-container--default .select2-selection--single {
            height: 56px;
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
            padding: 12px 16px;
            background-color: #f8f9fa !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 56px !important;
            top: 0 !important;
            right: 10px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057 !important;
            font-size: 1rem !important;
            line-height: 32px !important;
        }

        #city-loading {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: none;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .search-container {
                padding: 1.5rem;
                margin: 1rem auto;
            }

            .select2-container--default .select2-selection--single {
                height: 48px;
                padding: 10px 14px;
            }
        }

        .card-header {
            background-color: var(--primary);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            background-color: #f9f9f9;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .form-control {
            border-radius: 8px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 5px rgba(67, 97, 238, 0.5);
        }

        .btn-lg {
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn-lg:hover {
            background-color: #3a56d4;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .form-control, .btn-lg {
                font-size: 1rem;
            }
        }
    </style>
    
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>@yield('title', config('app.name'))</title>
</head>
<body class="bg-light">
    <!-- Header -->
    @include('partials.header')

    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    @stack('scripts')
</body>
</html>
