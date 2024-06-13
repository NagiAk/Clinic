@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Add New Specialty</h2>
    <form action="{{ route('specialites.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('specialites.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
