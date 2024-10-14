@extends('dashboard')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Your Profile</div>

                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
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

                            <button type="submit" class="btn btn-outline-primary"><i class="fa-regular fa-circle-check"></i> Update</button>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Return</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
