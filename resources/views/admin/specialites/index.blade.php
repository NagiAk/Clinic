@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Specialties</h2>
    <a href="{{ route('specialites.create') }}" class="btn btn-outline-success mb-4">Add New</a>
    <div class="row">
        @foreach ($specialites as $specialite)
            <div class="col-md-4 mb-5 sp">
                <a href="{{ route('specialites.show', $specialite->id) }}" class="card-link">
                    <div class="card border-custom">
                        <div class="card-body">
                            <h5 class="card-title" style="color:#8d4949;">{{ $specialite->nom }}</h5>
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
        background-color: #928d8d !important; /* Force background color to black */

    }
    
    .sp{
        height: 100%;
        width: 50px;
    }
</style>
