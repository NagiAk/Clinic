@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
</style>
<div class="container mt-5">
    <h2>Edit Profile</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('medecin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
        </div>
        <div class="form-group">
            <label for="image">Profile Picture</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if(Auth::user()->image)
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Current Profile Picture" style="max-width: 200px; margin-top: 10px;">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('medecin.profile.show') }}" class="btn btn-secondary">Back</a>
    </form>
    
</div>
@endsection
