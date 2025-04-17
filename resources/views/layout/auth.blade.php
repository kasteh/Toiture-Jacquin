<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('STARTUP_NAME') }} | Connexion</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        /* Fond de la page */
        body {
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Style de la carte de connexion */
        .card {
            width: 100%;
            max-width: 400px; /* Limiter la largeur à 400px pour les petits écrans */
            margin: 20px;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            color: #fff;
        }

        .btn-dark {
            background-color: #34495e;
            color: #fff;
            font-size: 1.1rem;
        }

        .btn-dark:hover {
            background-color: #2c3e50;
        }

        .card-title {
            font-size: 1.75rem;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="card shadow-lg">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">{{ env('STARTUP_NAME') }}</h3>
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
