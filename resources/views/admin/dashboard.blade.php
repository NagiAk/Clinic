@extends('dashboard')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container mt-5">
    <h2 class="text-center">Welcome {{ Auth::user()->name }} to the Admin Dashboard</h2>
    <p>This is the main content area for the admin dashboard.</p>

    <div class="row">
        <div class="col-md-6">
            <canvas id="patientsChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="rdvsChart"></canvas>
        </div>
        <div class="col-md-6 mt-4">
            <canvas id="medecinsChart"></canvas>
        </div>
        <div class="col-md-6 mt-4">
            <canvas id="rdvStatusChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const patientsCount = @json($patientsCount);
        const rdvsCount = @json($rdvsCount);
        const medecinsCount = @json($medecinsCount);
        const rdvStatus = @json($rdvStatus); // Assuming rdvStatus is an array like [realiserCount, annulerCount, encourCount]

        const ctx1 = document.getElementById('patientsChart').getContext('2d');
        const ctx2 = document.getElementById('rdvsChart').getContext('2d');
        const ctx3 = document.getElementById('medecinsChart').getContext('2d');
        const ctx4 = document.getElementById('rdvStatusChart').getContext('2d');

        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Patients'],
                datasets: [{
                    label: 'Patient Count',
                    data: [patientsCount],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['RDVs'],
                datasets: [{
                    label: 'RDV Count',
                    data: [rdvsCount],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Medecins'],
                datasets: [{
                    label: 'Medecin Count',
                    data: [medecinsCount],
                    backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: ['Realiser', 'Annuler', 'Encour'],
                datasets: [{
                    label: 'RDV Status',
                    data: rdvStatus,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(66, 59, 39, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>

@endsection
