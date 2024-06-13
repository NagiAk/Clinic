@extends('dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Edit Patient
                </div>
                <div class="card-body">
                    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nom">Last Name</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $patient->nom }}" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">First Name</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $patient->prenom }}" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $patient->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $patient->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $patient->address }}">
                        </div>
                        <div class="form-group">
                            <label for="cin">CIN</label>
                            <input type="text" class="form-control" id="cin" name="cin" value="{{ $patient->cin }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
