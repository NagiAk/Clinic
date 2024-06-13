@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
    .btn {
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .form-row .col {
            margin-bottom: 10px;
        }

        .table {
            font-size: 14px;
        }
        
        .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .table {
            font-size: 12px;
        }

        .btn {
            padding: 3px 6px;
            font-size: 12px;
        }
    }
</style>
<div class="container mt-5">
    <h2>My Patients</h2>
    <form method="post" action="{{ route('medecin.patients.index') }}" class="mb-3">
        @csrf
        @method('get')
        <div class="form-row">
            <div class="col-12 col-md-8 mb-2 mb-md-0">
                <input type="text" name="search" class="form-control" placeholder="Search patients" value="{{ request('search') }}">
            </div>
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Name</th>
                    <th>Email</th>
                    <th>CIN</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-info">
                @forelse ($patients as $patient)
                    <tr class="text-center">
                        <td>{{ $patient->nom }} {{ $patient->prenom }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->cin }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td class="d-flex justify-content-center align-items-center">
                            <form action="{{ route('medecin.patients.show', $patient->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-info btn-sm mr-2">View</button>
                            </form>
                            {{-- <a href="{{ route('medecin.patients.show', $patient->id) }}" class="btn btn-info btn-sm">View</a> --}}
                            <a href="{{ route('medecin.patients.edit', $patient->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                            <form action="{{ route('medecin.patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
