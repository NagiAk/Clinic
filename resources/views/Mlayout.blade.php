<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-image: url('{{ asset('') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .navbar {
            padding: 10px;
        }

        .nav-item {
            font-size: 18px;
        }

        .nav-link {
            transition: all 0.3s ease;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .nav-link:hover {
            background-color: rgba(94, 12, 12, 0.2); 
            border: 1px solid rgba(94, 12, 12, 0.5);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            opacity: 0.9;
            background: linear-gradient(155deg, #030303 0%, #222131 100%);
        }

        .navbar-nav.ml-auto .nav-item .dropdown-menu {
            right: 0;
            left: auto;
        }

        .dropdown-menu {
            background-color: rgb(68, 107, 226);
        }

        .dropdown-item {
            color: #5c1d1d;
        }

        .dropdown-item:hover {
            background-color: #020a16;
            color: #092ed1;
        }

        .main-content {
            padding-top: 20px;
        }

        footer {
            background: linear-gradient(110deg, #093030 30%, #062036 70%);
            color: white;
            text-align: center;
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

            .content {
                margin-left: 0;
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .nav-item {
                font-size: 14px;
            }

            .nav-link {
                padding: 5px;
            }

            .main-content {
                padding-top: 10px;
            }

            footer {
                padding: 15px 0;
            }
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-light">
        <div class="container">
                {{-- <img class="navbar-brand" src="{{ asset('logo.png') }}" alt="Logo" style="max-height: 50px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> --}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex w-100">
                    <ul class="navbar-nav">
                        @auth
                            @if(Auth::user()->role === 'medecin')
                                <li class="nav-item mr-5">
                                    <a class="nav-link" href="{{ url('medecin/patients') }}" style="color: #a04242;">Liste des patients</a>
                                </li>
                                <li class="nav-item mr-5">
                                    <a class="nav-link" href="{{ url('medecin/rdvs') }}" style="color: #a04242;">Liste des RDVs</a>
                                </li>
                                <li class="nav-item mr-5">
                                    <a class="nav-link" href="{{ url('medecin/schedule') }}" style="color: #a04242;">Schedule</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @auth
                            @if(Auth::user()->role === 'medecin')
                                <li class="nav-item dropdown">
                                    <button class="btn btn-link nav-link btn-outline-secondary my-2 my-sm-0 dropdown-toggle" style="color: #883a3a;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('medecin.profile.show') }}">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            @method('delete')
                                            <button class="dropdown-item" type="submit">Logout</button>
                                        </form>
                                    </div>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main class="container main-content mt-4">
        <h1>@yield('titre')</h1>
        @yield('content')
    </main>
    <footer class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    &copy; {{ date('Y') }} Stage
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>
</html>
