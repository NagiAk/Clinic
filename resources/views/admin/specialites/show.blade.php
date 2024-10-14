@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>{{ $specialite->nom }}</h2>
    <button type="button" class="addbtn mb-2 p-2" data-toggle="modal" data-target="#createMedecinModal" data-specialite="{{ $specialite }}" >Add Medecin</button>
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
                            <a href="{{ route('medecins.show', $medecin->id) }}" class="btn btn-outline-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                            {{-- <a href="{{ route('medecins.edit', $medecin->id) }}" class="btn btn-warning"></a> --}}
                            <!-- Edit Button -->
                            <button 
                            type="button" 
                            class="btn btn-outline-warning" 
                            data-toggle="modal" 
                            data-target="#editMedecinModal"
                            data-id="{{ $medecin->id }}"
                            data-name="{{ $medecin->user->name }}"
                            data-email="{{ $medecin->user->email }}"
                            data-specialite="{{ $medecin->specialite->nom }}"
                            data-specialite_id="{{ $medecin->specialite->id }}"
                            data-url="{{ route('medecins.update', $medecin->id) }}"
                            >
                            <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <form action="{{ route('medecins.destroy', $medecin->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this medecin?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@include('admin.rdvs.styles.style')

@include('admin.medecins.modals.addModal')

@include('admin.medecins.modals.editModal')