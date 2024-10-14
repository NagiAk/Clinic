@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Liste des Patients</h2>
    {{-- <a href="{{ route('patients.create') }}" class="btn btnt btn-primary mb-2">Add New Patient</a> --}}
    <button type="button" class="addbtn custom-btn mb-2" data-toggle="modal" data-target="#createPatientModal">Add New</button>
    <div class="row">
        @foreach ($patients as $patient)
            <div class="col-md-4 mb-5 sp">
                <button type="button" class="card-link edit-btn" 
                    data-toggle="modal" data-target="#editPatientModal"
                    data-id="{{ $patient->id }}" 
                    data-nom="{{ $patient->nom }}"
                    data-prenom="{{ $patient->prenom }}"
                    data-gender="{{ $patient->gender }}"
                    data-email="{{ $patient->email }}"
                    data-phone="{{ $patient->phone }}"
                    data-address="{{ $patient->address }}"
                    data-cin="{{ $patient->cin }}"
                    >
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
                </button>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $patients->links() }}
    </div>
</div>
@endsection

@include('admin.patients.style.style')

{{-- Add Modal --}}
@include('admin.patients.modals.addModal')

{{-- Edit Modal --}}
@include('admin.patients.modals.editModal')