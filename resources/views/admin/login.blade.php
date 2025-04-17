<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>

    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lien vers Font Awesome (pour les icônes) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f4f6f9; /* Fond de page clair */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .form-label {
            font-size: 1rem;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <!-- Carte de connexion -->
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Connexion</h3>

            <!-- Formulaire de connexion -->
            <form action="/admin/connexion" method="POST">
                <!-- CSRF Token -->
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
                </div>

                <!-- Mot de Passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="btn btn-primary w-100 py-2">Se Connecter</button>
            </form>

            <!-- Lien Retour au site -->
            <div class="text-center mt-3">
                <a href="/" class="text-muted"><i class="fas fa-arrow-left"></i> Retour au site</a>
            </div>
        </div>
    </div>

    <!-- Lien vers les scripts JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
