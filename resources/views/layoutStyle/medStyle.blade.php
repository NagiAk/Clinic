<style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: Arial, sans-serif;
        /* background-image: url('{{ asset('background.jpg') }}'); */
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
        background-color: rgba(96, 111, 156, 0.597);
        margin-top: 10px;
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
    .navbar-toggler-icon {
        filter: brightness(0) invert(1); 
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