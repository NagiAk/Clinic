@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Edit Medecin</h2>
    <form action="{{ route('medecins.update', $medecin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $medecin->user->name) }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $medecin->user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="form-group">
            <label for="specialite_id">Specialite</label>
            <select class="form-control" id="specialite_id" name="specialite_id" required>
                @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ $specialite->id == old('specialite_id', $medecin->specialite_id) ? 'selected' : '' }}>{{ $specialite->nom }}</option>
                @endforeach
            </select>
            @error('specialite_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('specialites.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
