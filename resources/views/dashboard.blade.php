<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(145deg, #0a0a0a 20%, #0c0709 80%);
            height: 100%;
            padding-top: 20px;
            position: fixed;
            overflow-y: auto;
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
            background-color: #6494c4;
        }
        .sidebar .nav-link.active {
            background-color: #0977ec;
        }
        .sidebar .dropdown-menu {
            background-color: #343a40;
            border: none;
        }
        .sidebar .dropdown-menu a {
            color: #fff;
        }
        .main-content {
            flex-grow: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            height: 130px;
            background: linear-gradient(155deg, #93b8db 30%, #beafae9c 70%);
        }
        
        .prof {
            color: #4e28b6;
            padding: 10px;
            text-decoration: none;
            font-size: 20px;
            display: block;
            transition: background 0.3s;
        }
        .prof:hover {
            background-color: #3d50da;
            border: none;
        }
        
        .na {
            color: #050c49;
            padding: 10px;
            text-decoration: none;
            font-size: 20px;
            display: block;
            transition: background 0.3s;
        }
        .item {
            color: #4f44e7;
            text-decoration: none;
            display: block;
        }
        .content {
            flex-grow: 1;
            background: linear-gradient(135deg, #d5d9db 0%, #d8d8e9 100%);
            padding: 20px;
            overflow-y: auto;
        }
        .dropdown-menu {
            background-color: rgb(68, 107, 226);
        }

        .dropdown-item {
            color: #092ed1;
        }

        .dropdown-item:hover {
            background-color: #08295e88;
            color: #092ed1;
        }
        

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {
                float: left;
                padding: 10px;
                text-align: center;
                width: 100%;
            }
            .main-content {
                margin-left: 0;
            }
            .navbar {
                flex-direction: column;
            }
            .navbar .nav-link, .navbar .dropdown-toggle {
                width: 100%;
                text-align: center;
            }
            .dropdown-menu {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    @auth
    <div class="sidebar">
        @if(Auth::user()->role === 'admin')
            <a class="nav-link" href="{{ route('emails.index') }}">
                <i class="fas fa-envelope"></i> Liste des Emails
            </a>
            <a class="nav-link" href="{{ url('admin/patients') }}">
                <i class="fas fa-user-injured"></i> Liste des patients
            </a>
            <a class="nav-link" href="{{ url('admin/rdvs') }}">
                <i class="fas fa-calendar-alt"></i> Liste des RDVs
            </a>
            <a class="nav-link" href="{{ url('admin/specialites') }}">
                <i class="fas fa-stethoscope"></i> Liste des Specialites
            </a>
            <a class="nav-link" href="{{ url('admin/schedule') }}">
                <i class="fas fa-clock"></i> Schedule
            </a>
        @endif
    </div>
    <div class="main-content">
        <nav class="navbar nt">
            <h1><a class="na nav-link" href="{{url('admin/dashboard')}}">Dashboard</a></h1>
            <div>
                <div class="dropdown">
                    <a class="btn btn-outline-secondary dropdown-toggle prof" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item item" href="{{ route('profile.show') }}">Profile</a>
                        <a class="dropdown-item item" href="{{ route('medecins.create') }}">Add Medecin</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @method('delete')
                            <button class="dropdown-item item" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </div>
    @endauth
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>
</html>
