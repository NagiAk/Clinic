@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
</style>
<div class="container mt-5">
    <h2>Edit Patient</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('medecin.patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $patient->nom }}" required>
        </div>
        <div class="form-group">
            <label for="prenom">First Name</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $patient->prenom }}" required>
        </div>
        <div class="form-group">
            <label for="cin">CIN</label>
            <input type="text" class="form-control" id="cin" name="cin" value="{{ $patient->cin }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $patient->email }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $patient->phone }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('medecin.patients.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
