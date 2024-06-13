<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rendez-vous Confirmation</h1>
        <p>Bonjour {{$fullname}},</p>
        <p>Nous sommes heureux de vous informer que vous avez un rendez-vous demain. Veuillez trouver les détails ci-dessous :</p>
        <ul>
            <li><strong>Date du rendez-vous:</strong> {{ $date }}</li>
        </ul>
        <p>Merci de votre confiance et à bientôt !</p>
        <p>L'équipe de CHU</p>
    </div>
</body>
</html>
