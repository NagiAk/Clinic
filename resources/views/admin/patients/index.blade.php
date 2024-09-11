@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Liste des Patients</h2>
    <a href="{{ route('patients.create') }}" class="btn btnt btn-primary mb-2">Add New Patient</a>
    <div class="row">
        @foreach ($patients as $patient)
            <div class="col-md-4 mb-5 sp">
                <a href="{{ route('patients.edit', $patient->id) }}" class="card-link">
                    <div class="card border-custom">
                        <div class="card-body">
                            <h5 class="card-title mb" style="color:#8d4949; ">
                                <span class="left">{{ $patient->nom }} {{ $patient->prenom }}</span>
                            </h5>
                            <p class="card-text mb">
                                <span lass="left">{{ $patient->email }}</span>
                            </p>
                            <p class="card-text mb">
                                <span lass="left">0{{ $patient->phone }}</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link:hover .card {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
    }

    .border-custom {
        border: 2px solid #8d4949;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
        background-color: #928d8d !important; /* Background color set to #928d8d */
    }

    .mb{
        margin-bottom: 16px !important;
    }

    .sp {
        height: 100%;
        width: 50px;
    }
</style>
