<style>
    body {
        display: flex;
        flex-direction: column;
        margin: 0;
        font-family: Arial, sans-serif;
        height: 100vh;
        overflow-x: hidden;
    }
    .sidebar {
        width: 250px;
        background: linear-gradient(145deg, #0a0a0a 20%, #0c0709 80%);
        height: 100%;
        padding-top: 20px;
        position: fixed;
        overflow-y: auto;
        transition: transform 0.3s ease-in-out;
        transform: translateX(0);
    }
    .sidebar a {
        color: #fff;
        padding: 15px;
        text-decoration: none;
        font-size: 18px;
        display: block;
        transition: background 0.3s;
    }
    .sidebar a img {
        max-height: 85px;
        width: auto;
        padding-left: 50px
    }
    .sidebar a:hover {
        background-color: #687b8f;
    }
    .sidebar .dropdown-menu {
        background-color: #343a40;
        border: none;
    }
    .sidebar .dropdown-menu a {
        color: #fff;
    }
    .sidebar .nav-link.active {
        position: relative;
        color: #000;
        padding-left: 20px; 
    }

    .sidebar .nav-link.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 10px;
        bottom: 0;
        width: 100%;
        background-color: #fff; 
        border-radius: 25px 0 0 25px; 
        z-index: -1; 
    }
    
    .main-content {
        flex-grow: 1;
        margin-left: 250px;
        display: flex;
        flex-direction: column;
        transition: margin-left 0.3s ease-in-out;
    }
    .navbar {
        height: 130px;
        background: linear-gradient(155deg, #93b8db 30%, #beafae9c 70%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        transition: padding 0.3s ease-in-out;
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
    .toggle-sidebar-btn {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
        background-color: #000;
        color: #fff;
        padding: 10px;
        border: none;
        cursor: pointer;
        z-index: 1000;
    }
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 500;
    }
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            z-index: 1000;
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .main-content {
            margin-left: 0;
        }
        .navbar {
            flex-direction: column;
            height: auto;
            padding: 10px;
        }
        .navbar h1 {
            margin-bottom: 10px;
        }
        .toggle-sidebar-btn {
            display: block;
        }
        .overlay.show {
            display: block;
        }
    }
    @media (max-width: 480px) {
        .sidebar {
            padding-top: 120px;
        }
        .sidebar a {
            font-size: 16px;
            padding: 10px;
        }
        .navbar h1 {
            font-size: 24px;
        }
        .prof, .na {
            font-size: 18px;
        }
    }
</style>