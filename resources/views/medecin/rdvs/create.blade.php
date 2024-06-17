@extends('Mlayout')

@section('content')
<style>
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);
    }
    .hidden {
        display: none;
    }
</style>
<div class="container mt-5">
    <h2>Create Appointment</h2>
    <form action="{{ route('medecin.rdvs.store') }}" method="POST">
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
            <label for="datetime">Available Date and Time:</label>
            <input type="text" id="datetime" class="form-control @error('schedule_id') is-invalid @enderror" required>
            <input type="hidden" name="schedule_id" id="schedule_id" required>
            @error('schedule_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <div id="no-schedule-found" class="alert alert-warning mt-2 hidden">No matching schedule found for the selected date and time pls go ask the admin to create the schedule for you or the time is already taken.</div>
        </div>
        <button type="submit" class="btn btn-success">Book Appointment</button>
        <a href="{{ route('medecin.rdvs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const schedules = @json($schedules);

        flatpickr('#datetime', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            minuteIncrement: 30,
            onChange: function(selectedDates, dateStr, instance) {

                const selectedSchedule = schedules.find(schedule => {
                    const scheduleDateTime = `${schedule.date} ${schedule.time}`;
                    const formattedDateTime = `${schedule.date} ${schedule.time.substr(0, 5)}`;  
                    return formattedDateTime === dateStr;
                });

                if (selectedSchedule) {
                    document.getElementById('schedule_id').value = selectedSchedule.id;
                    document.getElementById('no-schedule-found').classList.add('hidden');
                } else {
                    document.getElementById('schedule_id').value = '';
                    document.getElementById('no-schedule-found').classList.remove('hidden');
                }
            }
        });
    });
</script>
@endsection
