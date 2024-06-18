<!DOCTYPE html>
<html>
<head>
    <title>Appointment Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .details {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            padding: 10px;
            border-bottom: 1px solid #ecf0f1;
        }
        .details th {
            text-align: left;
            background: #ecf0f1;
            color: #2c3e50;
        }
        .details td {
            color: #34495e;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $clinic_logo }}" alt="Clinic Logo">
            <h1>{{ $clinic_name }}</h1>
            <p>{{ $clinic_address }}</p>
            <p>Phone: {{ $clinic_phone }} | Email: {{ $clinic_email }} | Website: {{ $clinic_website }}</p>
        </div>
        <div class="details">
            <h2>Appointment Details</h2>
            <table>
                <tr>
                    <th>Patient Name</th>
                    <td>{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</td>
                </tr>
                <tr>
                    <th>Patient Email</th>
                    <td>{{ $rdv->patient->email }}</td>
                </tr>
                <tr>
                    <th>Appointment Date</th>
                    <td>{{ \Carbon\Carbon::parse($rdv->schedule->date)->format('l, F j, Y') }} at {{ \Carbon\Carbon::parse($rdv->schedule->time)->format('h:i A') }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Thank you for choosing {{ $clinic_name }}. We look forward to serving you.</p>
        </div>
    </div>
</body>
</html>
