@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Specialties</h2>
    <a href="{{ route('specialites.create') }}" class="btn btn-outline-success mb-2">Add New</a>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr class="text-center">
                <th style="color:#8d4949;">ID</th>
                <th style="color:#8d4949;">Name</th>
                <th style="color:#8d4949;">Actions</th>
            </tr>
        </thead>
        <tbody class="table-info">
            @foreach ($specialites as $specialite)
            <tr class="text-center">
                <td>{{ $specialite->id }}</td>
                <td>{{ $specialite->nom }}</td>
                <td>
                    <a href="{{ route('specialites.show', $specialite->id) }}" class="btn btn-outline-primary">Show Medecins</a>
                    <a href="{{ route('specialites.edit', $specialite->id) }}" class="btn btn-outline-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
