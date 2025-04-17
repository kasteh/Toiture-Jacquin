<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta-description', config('app.description'))">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --dark: #212529;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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

        .sidebar {
            min-width: 220px;
            max-width: 220px;
            transition: width 0.3s ease-in-out;
        }

        .sidebar.collapsed {
            width: 80px;  /* Réduit la sidebar à 80px */
        }

        .sidebar .nav-link {
            font-size: 1rem;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-item.active {
            background-color: var(--primary);
        }

        /* Bouton pour réduire/agrandir la sidebar */
        .toggle-sidebar-btn {
            position: absolute;
            top: 10px;
            right: -25px;
            background-color: var(--primary);
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 999;
        }

        .toggle-sidebar-btn i {
            font-size: 1.2rem;
        }

        /* Styles pour le menu de personnalisation */
        .config-menu {
            padding: 1rem;
            border-top: 1px solid #ddd;
        }

        .config-menu select, .config-menu input {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                top: 0;
                bottom: 0;
                left: -100%;
                transition: all 0.3s ease;
            }

            .sidebar.collapsed {
                left: 0;
                width: 100%;
            }
        }
    </style>    
    
    @stack('styles')
    <title>@yield('title', config('app.name'))</title>
</head>
<body class="bg-light">

    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark text-white p-3 sidebar d-lg-block d-flex flex-column">
            <!-- Bouton pour réduire/agrandir la sidebar -->
            <button id="toggle-sidebar" class="toggle-sidebar-btn">
                <i class="fas fa-chevron-left"></i>  <!-- Flèche à gauche pour réduire -->
            </button>

            <div class="mb-4 border-bottom pb-3">
                <h5 class="mb-0">{{ env('STARTUP_NAME') }}</h5>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-1">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.chatgpt') }}" class="nav-link {{ request()->routeIs('admin.chatgpt') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-robot me-2"></i> ChatGPT
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-folder me-2"></i> Catégories
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contents.index') }}" class="nav-link {{ request()->routeIs('admin.contents.*') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-file-alt me-2"></i> Textes
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.departements.index') }}" class="nav-link {{ request()->routeIs('admin.departements.*') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-globe me-2"></i> Départements
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-map me-2"></i> Villes
                    </a>
                </li>
                @if(auth()->user()->is_admin)
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active bg-primary text-white' : 'text-white' }}">
                            <i class="fas fa-users me-2"></i> Utilisateurs
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active bg-primary text-white' : 'text-white' }}">
                        <i class="fas fa-cog me-2"></i> Paramètres
                    </a>
                </li>
            </ul>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('admin.logout') }}" class="nav-link text-danger">
                    <i class="fas fa-power-off me-2"></i> Déconnexion
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-fill p-4 bg-light">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    @stack('scripts')
</body>
</html>
