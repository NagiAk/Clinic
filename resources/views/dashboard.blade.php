<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @include('dashboardStyle')
</head>
<body>
    
    <button class="toggle-sidebar-btn">
        <i class="fas fa-bars"></i>
    </button>
    <div class="overlay"></div>
    @auth
    <div class="sidebar">
        <a href="{{ url('/admin/dashboard') }}">
            <img src="{{ asset('logo2.jpg') }}" alt="Logo">
        </a>
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
                        {{-- <a class="dropdown-item item" href="{{ route('medecins.create') }}">Add Medecin</a> --}}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebarBtn = document.querySelector('.toggle-sidebar-btn');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');

            toggleSidebarBtn.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });
            const currentUrl = window.location.href;
            const links = document.querySelectorAll('.sidebar .nav-link');
            links.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>

