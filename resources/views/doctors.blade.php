@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Meet Our Doctors</h2>
    <div class="row">
        @foreach($doctors as $doctor)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $doctor->user->image) }}" class="card-img-top custom-img-size" alt="{{ $doctor->user->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->user->name }}</h5>
                        <p class="card-text">{{ $doctor->specialite->nom }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
