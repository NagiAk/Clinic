@extends('layout')

@section('content')
<style>
    .au{
        background: linear-gradient(110deg, #61806785 50%, #8ebbe286 50%);
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card au">
                    <div class="card-header">
                        <h1 class="card-title text-center">Se connecter</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('toLogin') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
