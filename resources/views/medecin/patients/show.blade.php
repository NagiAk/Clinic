@extends('Mlayout')

@section('content')
<div class="container mt-5">
    <h2>Patient Details</h2>
    <div class="card">
        <div class="card-header">
            <h3>{{ $patient->nom }} {{ $patient->prenom }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            <p><strong>CIN:</strong> {{ $patient->cin }}</p>
            <p><strong>Phone:</strong> {{ $patient->phone }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('medecin.patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('medecin.patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
            </form>
            <a href="{{ route('medecin.patients.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
