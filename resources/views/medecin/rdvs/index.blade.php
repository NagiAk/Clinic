@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
</style>
<div class="container mt-5">
    <h2>{{ Auth::user()->name }} Appointments</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="post" action="{{ route('medecin.rdvs.index') }}" class="mb-3">
        @csrf
        @method('get')
        <div class="form-row align-items-center">
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label class="sr-only" for="date_filter">Date</label>
                <input type="date" class="form-control" id="date_filter" name="date_filter" value="{{ request('date_filter') }}">
            </div>
            <div class="col-12 col-md-3 mb-2 mb-md-0">
                <label class="sr-only" for="etat_de_rdv">Status</label>
                <select class="form-control" id="etat_de_rdv" name="etat_de_rdv">
                    <option value="">All Statuses</option>
                    <option value="encour" {{ request('etat_de_rdv') == 'encour' ? 'selected' : '' }}>En cours</option>
                    <option value="annuler" {{ request('etat_de_rdv') == 'annuler' ? 'selected' : '' }}>Annulé</option>
                    <option value="realise" {{ request('etat_de_rdv') == 'realise' ? 'selected' : '' }}>Réalisé</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>
    <a href="{{ route('medecin.rdvs.create') }}" class="btn btn-outline-success mb-3">Add New</a>

    @if($rdvs->isEmpty())
        <p>No appointments found.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark" >
                    <tr class="text-center">
                        <th>Patient Name</th>
                        <th>Patient Email</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Actions</th> 
                    </tr>
                </thead>
                <tbody class="table-info">
                    @foreach ($rdvs as $rdv)
                        <tr class="text-center">
                            <td>{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</td>
                            <td>{{ $rdv->patient->email }}</td>
                            <td>{{ $rdv->schedule->date }} {{ $rdv->schedule->time }}</td>
                            <td>
                                <div class="p-1 rounded {{ $rdv->etat_de_rdv === 'realise' ? 'bg-success text-white' : ($rdv->etat_de_rdv === 'annuler' ? 'bg-danger text-white' : '') }}">
                                    {{ $rdv->etat_de_rdv }}
                                </div>
                            </td>
                            <td>
                                @if ($rdv->etat_de_rdv === 'encour')
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <form action="{{ route('medecin.rdvs.updateEtat', $rdv->id) }}" method="POST" class="mr-1 mb-1">
                                            @csrf
                                            <input type="hidden" name="etat_de_rdv" value="annuler">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Cancel</button>
                                        </form>
                                        <form action="{{ route('medecin.rdvs.updateEtat', $rdv->id) }}" method="POST" class="mr-1 mb-1">
                                            @csrf
                                            <input type="hidden" name="etat_de_rdv" value="realise">
                                            <button type="submit" class="btn btn-outline-success btn-sm">Realize</button>
                                        </form>
                                        <form action="{{ route('medecin.rdvs.edit', $rdv->id) }}" method="get" class="mr-1 mb-1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Edit</button>
                                        </form>
                                        <a href="{{ route('medecin.rdvs.downloadPdf', $rdv->id) }}" class="btn btn-outline-info btn-sm mr-1 mb-1">Download PDF</a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
