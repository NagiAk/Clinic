@extends('dashboard')

@section('content')
<style>
    .form-control {
        background-color: rgb(238, 180, 180);
        color: rgb(84, 83, 172);
    }
</style>
<div class="container mt-5">
    <h2>Edit Appointment</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('rdvs.update', $rdv->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <input type="text" class="form-control" style="background-color: rgb(238, 180, 180);" id="patient_np" name="patient_np" value="{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}" required readonly>
            <input type="hidden" class="form-control" name="patient_id" value="{{ $rdv->patient->id }}">
            @error('patient_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="specialite_id">Specialty</label>
            <select class="form-control" id="specialite_id" name="specialite_id" required>
                <option value="">Select Specialty</option>
                @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ $specialite->id == $rdv->medecin->specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}</option>
                @endforeach
            </select>
            @error('specialite_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="medecin_id">Medecin</label>
            <select class="form-control" id="medecin_id" name="medecin_id" required>
                @foreach($specialites as $specialite)
                    <optgroup label="{{ $specialite->nom }}">
                        @foreach($specialite->medecins as $medecin)
                            <option value="{{ $medecin->id }}" {{ $medecin->id == $rdv->medecin_id ? 'selected' : '' }}>{{ $medecin->user->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('medecin_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="schedule_id">Available Date and Time:</label>
            <select name="schedule_id" id="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror" required>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ $rdv->schedule_id == $schedule->id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($schedule->date)->format('l, F j, Y') }} at {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}
                    </option>
                @endforeach
            </select>
            @error('schedule_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('rdvs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
