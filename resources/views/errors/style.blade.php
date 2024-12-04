<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(110deg, #edf8ef 30%, #c2d0d070 60%);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
    }
    .error-container {
        text-align: center;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(232, 214, 214, 0.1);
        animation: fadeIn 1s ease-out;
        background: linear-gradient(110deg, #c2d0d070 30%, #edf8ef 60%);
        
    }
    h1 {
        font-size: 4rem;
        font-weight: 600;
        color: #e74c3c;
    }
    p {
        font-size: 1.55rem;
        color: #77424f;
        font-style: italic;

    }
    a.btn-custom {
        font-size: 1.1rem;
        padding: 10px 20px;
        border-radius: 30px;
        background-color: #8f4185d1;
        color: #fff;
        transition: background-color 0.3s ease;
    }
    a.btn-custom:hover {
        background-color: #5c2372;
        color: white
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>