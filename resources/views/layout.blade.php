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
    @include('layoutStyle.style')
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <div class="header-bar">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('akira_logo.png') }}" alt="Logo">
                </a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-right text-lg-right">
                    @guest
                        <div class="flex">
                            <li class="nav-item">
                                <a class="btn btn-outline-info mr-2 mt-2" href="{{ url('/') }}">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-info mr-2 mt-2" href="{{ url('/form') }}">Formulaire</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-info mr-2 mt-2" href="{{ route('login') }}">Login</a>
                            </li>
                        </div>
                    @endguest
                    @auth
                            {{-- admin role --}}
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="btn btn-outline-info my-2 mt-sm-0" href="{{ url('/admin/dashboard ') }}">Admin</a>
                                </li>
                            @endif
                            {{-- medecin role --}}
                            @if(Auth::user()->role == 'medecin')
                                <li class="nav-item">
                                    <a class="btn btn-outline-info my-2 mt-sm-0" href="{{ url('/medecin/profile') }}">Medecin</a>
                                </li>
                            @endif
                    @endauth
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
