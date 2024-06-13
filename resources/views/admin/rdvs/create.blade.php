@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Schedule New Appointment</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('rdvs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <input type="text" class="form-control" id="patient_id" name="patient_id" autocomplete="off" list="patientsList" required>
            <datalist id="patientsList">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
                @endforeach
            </datalist>
            @error('patient_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="specialite_id">Specialty</label>
            <select name="specialite_id" id="specialite_id" class="form-control" required>
                <option value="">Select Specialty</option>
                @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
                @endforeach
            </select>
            @error('specialite_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="medecin_id">Medecin</label>
            <select name="medecin_id" id="medecin_id" class="form-control" required>
                <option value="">Select Medecin</option>
            </select>
            @error('medecin_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
            @error('date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('rdvs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const specialiteSelect = document.getElementById('specialite_id');
    const medecinSelect = document.getElementById('medecin_id');
    const medecins = @json($specialites->flatMap->medecins);

    specialiteSelect.addEventListener('change', function () {
        const specialiteId = this.value;
        medecinSelect.innerHTML = '<option value="">Select Medecin</option>'; 

        medecins.filter(med => med.specialite_id == specialiteId).forEach(med => {
            const option = document.createElement('option');
            option.value = med.id;
            option.textContent = med.user.name;
            medecinSelect.appendChild(option);
        });
    });
});
</script>
@endsection
