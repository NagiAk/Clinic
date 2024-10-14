<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.9s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero, .services, .doctors {
            background-color: rgba(153, 224, 197, 0.336);
            color: black;
        }

        .inf {
            background: linear-gradient(110deg, #8bbbbb70 50%, #edf8ef 50%);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            background-image: url('{{ asset('test.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .navbar-brand img {
            max-height: 85px;
            width: auto;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            position: fixed;
            height: 100%;
            padding-top: 20px;
            transition: width 0.3s;
        }

        .sidebar a {
            color: #fff;
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(73, 80, 87, 0.8); /* Dark grey with opacity */
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
        }

        .sidebar .dropdown-menu {
            background-color: #343a40;
            border: none;
        }

        .sidebar .dropdown-menu a {
            color: #fff;
        }

        .content {
            margin-left: 250px;
            flex-grow: 1;
            padding: 20px;
        }

        .navbar {
            padding: 10px;
        }

        .nav-link:hover {
            background-color: rgba(24, 86, 107, 0.2); 
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: auto; /* Push the footer to the bottom */
        }

        .footer nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .footer a {
            color: white;
            margin: 5px;
        }

        .footer a:hover {
            background-color: rgba(26, 127, 209, 0.1); 
        }
    </style>
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('akira_logo.png') }}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}" style="color: #18566b;">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/form') }}" style="color: #18566b;">Formulaire</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-info my-2 my-sm-0" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </header>

    <main class="container mt-4">
        <h1>@yield('titre')</h1>
        @yield('content')
    </main>
    
    <div class="footer">
        <p>Projet Clinic © 2024</p>
        <nav>
            <a href="{{route('about.index')}}" class="text-white navbar-brand">About us</a>
            <a href="{{ route('login') }}" class="text-white navbar-brand">Log in</a>
            <a href="{{route('terms.index')}}" class="text-white navbar-brand">Terms & Conditions</a>
            <a href="{{route('health.index')}}" class="text-white navbar-brand">Health Information Policy</a>
        </nav>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(el => {
            observer.observe(el);
        });
    });
    </script>
</body>
</html>
