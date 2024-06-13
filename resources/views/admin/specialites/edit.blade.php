@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Edit Specialty</h2>
    <form action="{{ route('specialites.update', $specialite->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $specialite->nom }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('specialites.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
