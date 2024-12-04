@extends('dashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mt-5">
    <h2>Appointments</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ol>
                @foreach ($errors->all() as $error)
                    <li type="N">{{ $error }}</li>
                @endforeach
            </ol>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('rdvs.index') }}" method="GET" class="mb-3">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="date_filter">Filter by Date:</label>
                <input type="date" class="form-control" id="date_filter" name="date_filter" value="{{ request('date_filter') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="status_filter">Filter by Status:</label>
                <select name="etat_de_rdv" id="status_filter" class="form-control">
                    <option value="">All</option>
                    <option value="encour" {{ request('etat_de_rdv') === 'encour' ? 'selected' : '' }}>Encour</option>
                    <option value="realise" {{ request('etat_de_rdv') === 'realise' ? 'selected' : '' }}>Realized</option>
                    <option value="annuler" {{ request('etat_de_rdv') === 'annuler' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="specialite_filter">Filter by Specialty:</label>
                <select name="specialite_filter" id="specialite_filter" class="form-control">
                    <option value="">All</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite->id }}" {{ request('specialite_filter') == $specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="medecin_filter">Filter by Medecin:</label>
                <select name="medecin_filter" id="medecin_filter" class="form-control">
                    <option value="">All</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <button type="submit" class="btn custom-btn filter">Filter</button>
            </div>
        </div>
    </form>
    
    <button type="button" class="btn addbtn custom-btn mb-2" data-toggle="modal" data-target="#createRdvModal">Add New</button>
    
    @empty($rdvs)
        <div>Empty</div>                
    @endempty
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th style="color:#8d4949;">ID</th>
                    <th style="color:#8d4949;">Patient</th>
                    <th style="color:#8d4949;">Medecin</th>
                    <th style="color:#8d4949;">Date</th>
                    <th style="color:#8d4949;">Time</th>
                    <th style="color:#8d4949;">Status</th>
                    <th style="color:#8d4949;">Actions</th>
                </tr>
            </thead>        
            <tbody class="table-info">
                @foreach ($rdvs as $rdv)
                    <tr class="text-center">
                        <td>{{ $rdv->id }}</td>
                        <td>{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</td>
                        <td>Dr. {{ $rdv->medecin->user->name }}</td>
                        <td>{{ $rdv->schedule->date }}</td>
                        <td>{{ $rdv->schedule->time }}</td>
                        <td>
                            <div class="p-0 rounded {{ $rdv->etat_de_rdv === 'realise' ? 'bg-success text-white' : ($rdv->etat_de_rdv === 'annuler' ? 'bg-danger text-white' : 'bg-orange text-white') }}">
                                {{ $rdv->etat_de_rdv }}
                            </div>
                        </td>
                        <td class="d-flex justify-content-center align-items-center">
                            @if ($rdv->etat_de_rdv === 'encour')
                                <form action="{{ route('rdvs.updateEtat', $rdv->id) }}" method="POST" class="button-form">
                                    @csrf
                                    <input type="hidden" name="etat_de_rdv" value="annuler">
                                    <button type="submit" class="btn btn-outline-danger btn-sm custom-button"><i class="fa-solid fa-x"></i></button>
                                </form>
                                <form action="{{ route('rdvs.updateEtat', $rdv->id) }}" method="POST" class="button-form">
                                    @csrf
                                    <input type="hidden" name="etat_de_rdv" value="realise">
                                    <button type="submit" class="btn btn-outline-success btn-sm custom-button"><i class="fa-solid fa-check"></i></button>
                                </form>
                                {{-- <a href="{{ route('rdvs.edit', $rdv->id ) }}" class="btn btn-outline-primary btn-sm custom-button">Edit</a> --}}
                                <button class="btn btn-outline-primary btn-sm custom-button edit-btn" data-toggle="modal" data-target="#editRdvModal" 
                                        data-id="{{ $rdv->id }}" 
                                        data-patient="{{ $rdv->patient_id }}" 
                                        data-specialite="{{ $rdv->medecin->specialite->id }}" 
                                        data-medecin="{{ $rdv->medecin_id }}" 
                                        data-schedule="{{ $rdv->schedule->date }} {{ $rdv->schedule->time }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            @endif
                        </td>                  
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $rdvs->links() }}
        </div>
    </div>
</div>
{{-- Style --}}
@include('admin.rdvs.styles.style')

<!-- Add Appointment Modal -->
@include('admin.rdvs.modals.addModal')


{{-- Edit Modal --}}
@if($rdvs->count()>0)
     @include('admin.rdvs.modals.editModal')
@endif()
   
    




@endsection
