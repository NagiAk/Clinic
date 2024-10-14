@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Specialties</h2>
    {{-- <a href="{{ route('specialites.create') }}" class="btn btn-outline-success mb-4">Add New</a> --}}
    <button type="button" class="addbtn custom-btn mb-2" data-toggle="modal" data-target="#createSpecialiteModal">Add New</button>
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
    <div class="d-flex justify-content-center">
        {{ $specialites->links() }}
    </div>
</div>
@endsection


@include('admin.specialites.style.style')

{{-- Add Modal Specialite--}}
@include('admin.specialites.modals.addModal')

