@extends('dashboard')

@section('title', 'Change Password')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Change Password</h3></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('Pwupdate') }}">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Change Password</button>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Return</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
