@extends('dashboard')

@section('content')
<style>
    .container {
        padding: 20px;
    }

    .btnt {
        font-size: 14px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
        border-collapse: collapse;
    }

</style>
<div class="container mt-5">
    <h2 class="mb-3">Patients List</h2>
    <a href="{{ route('patients.create') }}" class="btn btnt btn-primary mb-2">Add New Patient</a>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark" >
                <tr class="text-center ">
                    <th style="color:#8d4949;">ID</th>
                    <th style="color:#8d4949;">Name</th>
                    <th style="color:#8d4949;">Email</th>
                    <th style="color:#8d4949;">Actions</th>
                </tr>
            </thead>
            <tbody class="table-info">
                @foreach ($patients as $patient)
                    <tr class="text-center">
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->nom }} {{ $patient->prenom }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btnt btn-outline-info btn-sm btn-action">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
