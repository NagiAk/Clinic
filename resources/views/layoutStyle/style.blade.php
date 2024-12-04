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

    .header-bar{
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center
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
        text-align: right

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
        margin-top: auto;
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
    .flex{
        display: flex;
        justify-content: space-between
    }

    @media (max-width: 1024px) {
        .btn {
            width: 100px;
        }
        .flex{
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }
    }


</style>