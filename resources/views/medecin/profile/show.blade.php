@extends('Mlayout')

@section('title', 'Profile')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
    .card{
        margin-top: 13px;
    }
    .card-header {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #1d2d3b 0%, #263f27 100%);
        color: #fff;
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
    .prof{
        background: linear-gradient(125deg, #8fb9dd 30%, #a6b3a6 70%);

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
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded prof">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Your Profile</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{$medecin->user->image ? asset('storage/' . $medecin->user->image) : asset('profile1.jpg')}}" alt="Current Image" class="img-fluid rounded-circle img-thumbnail" style="max-width: 140px;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 ">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $medecin->user->name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $medecin->user->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <a href="{{ route('medecin.profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                            <a href="{{ route('medecin.profile.password') }}" class="btn btn-info btn-sm">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
