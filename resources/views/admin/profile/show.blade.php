@extends('dashboard')

@section('title', 'Profile')

@section('content')
<style>
    .card-header {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #01284b 0%, #b3e7b6 100%);
        color: #fff;
    }
    .card-header h4{
        background: linear-gradient(145deg, #053a3a 20%, #5e3143 80%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;    
    }

    .card-body {
        padding: 2rem;
    }

    .img-thumbnail {
        border: 4px solid #ddd;
        border-radius: 50%;     
        object-fit: cover;      
        width: 150px;           
        height: 130px; 
    }

    .btn-sm {
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
        margin: 0.5rem;
    }

    .row.mb-3 {
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .col-sm-3 {
            text-align: left;
            margin-bottom: 0.5rem;
        }
    }
</style>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header text-center">
                    <h4 class="mb-0">Your Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Current Image" class="img-fluid rounded-circle img-thumbnail">
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-right">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-right">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                            <a href="{{ route('profile.password') }}" class="btn btn-info btn-sm">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
