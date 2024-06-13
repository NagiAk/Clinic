@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
</style>
<div class="container mt-5">
    <h2>Edit Appointment</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('medecin.rdvs.update', $rdv->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <input type="text" class="form-control" id="patient_np" name="patient_np" value="{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}" required readonly>
            <input type="hidden" name="patient_id" value="{{ $rdv->patient->id }}">
            @error('patient_id')
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
        <a href="{{ route('medecin.rdvs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
