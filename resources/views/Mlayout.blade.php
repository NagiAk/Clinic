<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-image: url('{{ asset('background.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .navbar {
            padding: 10px;
            background: linear-gradient(155deg, #3a3434 0%, #222131 100%);
            opacity: 0.9;
        }
        .nav-item {
            font-size: 18px;
        }
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 5px 10px;
            color: #ffffff;
        }
        .nav-link:hover {
            background-color: rgba(94, 12, 12, 0.2);
            border: 1px solid rgba(94, 12, 12, 0.5);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dropdown-menu {
            background-color: rgb(68, 107, 226);
        }
        .dropdown-item {
            color: #ffffff;
        }
        .dropdown-item:hover {
            background-color: #020a16;
            color: #092ed1;
        }
        .main-content {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        footer {
            background: linear-gradient(110deg, #093030 40%, #062036 60%);
            color: white;
            text-align: center;
            padding: 15px 0;
        }
        @media (max-width: 768px) {
            .nav-item {
                font-size: 16px;
                margin-right: 0;
            }
            .navbar-nav {
                text-align: center;
            }
            .navbar-nav.ml-auto {
                margin-left: 0;
            }
            .navbar-nav .nav-link {
                display: inline-block;
                margin: 5px 0;
            }
            .main-content {
                padding-top: 10px;
            }
        }
        @media (max-width: 576px) {
            .nav-item {
                font-size: 14px;
            }
            .nav-link {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mr-auto">
                    @auth
                        @if(Auth::user()->role === 'medecin')
                            <li class="nav-item">
                                <a class="nav-link" style="color: #883a3a;" href="{{ url('medecin/patients') }}">Liste des patients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #883a3a;" href="{{ url('medecin/rdvs') }}">Liste des RDVs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" style="color: #883a3a;" href="{{ url('medecin/schedule') }}">Schedule</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: #883a3a;" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('medecin.profile.show') }}">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </header>
    <main class="container main-content">
        <h1>@yield('titre')</h1>
        @yield('content')
    </main>
    <footer>
        &copy; {{ date('Y') }} Stage
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
