@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Specialite: {{ $specialite->nom }}</h2>
    
    @if($specialite->medecins->isEmpty())
        <p>No medecins found for this specialite.</p>
    @else
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th style="color:#8d4949;">ID</th>
                    <th style="color:#8d4949;">Name</th>
                    <th style="color:#8d4949;">Email</th>
                    <th style="color:#8d4949;">Actions</th>
                </tr>
            </thead>
            <tbody class="table-info">
                @foreach($specialite->medecins as $medecin)
                    <tr class="text-center">
                        <td>{{ $medecin->id }}</td>
                        <td>{{ $medecin->user->name }}</td>
                        <td>{{ $medecin->user->email }}</td>
                        <td>
                            <a href="{{ route('medecins.show', $medecin->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('medecins.edit', $medecin->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('medecins.destroy', $medecin->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this medecin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
