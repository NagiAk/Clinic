@extends('dashboard')

@section('content')
<style>
    .p{
        background: linear-gradient(145deg, #8cbebe9f 30%, #8a6d7950 70%);
        padding: 20px;
    }
</style>
<div class="container mt-5 p">
    <h2>Medecin Details</h2>
    <div >
        <div class="card-header">
            <h3>Dr {{ $medecin->user->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $medecin->user->email }}</p>
            <p><strong>Specialite:</strong> {{ $medecin->specialite->nom }}</p>
        </div>
        <div class="card-body">
            <h4>Appointments</h4>
            @if($medecin->rdvs->isEmpty())
                <p>No appointments found for this medecin.</p>
            @else
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Patient Name</th>
                            <th>Patient Email</th>
                            <th>Appointment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        @foreach ($medecin->rdvs as $rdv)
                            <tr class="text-center">
                                <td>{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</td>
                                <td>{{ $rdv->patient->email }}</td>
                                <td>{{ $rdv->schedule->date }} {{ $rdv->schedule->time }}</td>
                                <td>
                                    <div class="p-0 rounded {{ $rdv->etat_de_rdv === 'realise' ? 'bg-success text-white' : ($rdv->etat_de_rdv === 'annuler' ? 'bg-danger text-white' : '') }}">
                                        {{ $rdv->etat_de_rdv }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('medecins.edit', $medecin->id) }}" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></a>
            <form action="{{ route('medecins.destroy', $medecin->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this medecin?')"><i class="fa-solid fa-trash"></i></button>
            </form>
            <a href="{{ route('specialites.show',$medecin->specialite->id) }}" class="btn btn-outline-secondary"><i class="fa-solid fa-backward"></i></a>
        </div>
    </div>
</div>
@endsection

{{-- style --}}
@include('admin.medecins.styles.style')
