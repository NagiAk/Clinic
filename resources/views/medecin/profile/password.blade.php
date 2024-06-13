@extends('Mlayout')

@section('title', 'Change Password')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
    .ps{
        background: linear-gradient(110deg, #c3dadd 45%, #84bef1 55%);
    }
    </style>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8 ps">
                <div class="card ps">
                    <div class="card-header">Change Password</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('medecin.Pwupdate') }}">
                            @csrf

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
                            <a href="{{ route('medecin.profile.show') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
