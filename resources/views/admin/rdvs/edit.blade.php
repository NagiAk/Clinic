@extends('dashboard')

@section('content')
<style>
    .form-control {
        background-color: rgb(238, 180, 180);
        color: rgb(84, 83, 172);
    }
    .hidden {
        display: none;
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
            <input type="text" class="form-control" id="patient_np" name="patient_np" value="{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}" required readonly>
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
            <select name="medecin_id" id="medecin_id" class="form-control" required>
                <option value="">Select Medecin</option>
            </select>
            @error('medecin_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="datetime">Available Date and Time:</label>
            <input type="text" id="datetime" class="form-control" required>
            <input type="hidden" id="schedule_id" name="schedule_id">
            <div id="no-schedule-found" class=""></div>
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const specialiteSelect = document.getElementById('specialite_id');
        const medecinSelect = document.getElementById('medecin_id');
        const scheduleSelect = document.getElementById('schedule_id');
        const noScheduleFoundDiv = document.getElementById('no-schedule-found');
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
    
        medecinSelect.addEventListener('change', function () {
            const medecinId = 1; 
    
            // Function to fetch schedules and return the array of schedules
            async function fetchSchedules(medecinId) {
                try {
                    const response = await fetch(`/admin/${medecinId}/schedules`);
                    if (!response.ok) {
                        throw new Error('Failed to fetch schedules');
                    }
    
                    const schedules = await response.json();
                    return schedules; 
                } catch (error) {
                    console.error('Error fetching schedules:', error);
                    return []; 
                }
            }
    
            // Fetch schedules and handle the resolved result
            fetchSchedules(medecinId).then((schedules) => {
                
    
                
                if (schedules.length > 0) {
                    initializeFlatpickr(schedules); 
                } else {
                    
                    console.log("No schedules found");
                }
            }).catch((error) => {
                console.error('Error in Promise chain:', error);
            });
    
            /**
             * Function to initialize flatpickr with fetched schedules
             * @param {Array} schedules 
             */
            function initializeFlatpickr(schedules) {
    
                flatpickr('#datetime', {
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i',
                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        handleScheduleSelection(schedules, dateStr);
                    }
                });
            }
    
            /**
             * Function to handle schedule selection logic
             * @param {Array} schedules - 
             * @param {string} dateStr - 
             */
            function handleScheduleSelection(schedules, dateStr) {
                const selectedSchedule = schedules.find(schedule => {
                    const scheduleDateTime = `${schedule.date} ${schedule.time}`;
                    const formattedDateTime = `${schedule.date} ${schedule.time.substr(0, 5)}`;
                    return formattedDateTime === dateStr;
                });
                console.log(selectedSchedule);
                if (selectedSchedule) {
                    document.getElementById('schedule_id').value = selectedSchedule.id;
                    noScheduleFoundDiv.innerHTML = 'Date and Time are valid.';
                    noScheduleFoundDiv.className = 'alert alert-success mt-2';
                } else {
                    document.getElementById('schedule_id').value = '';
                    noScheduleFoundDiv.className = 'alert alert-warning mt-2';
                    noScheduleFoundDiv.innerHTML = 'Date And Time are unvalid.';
                }
            }
    
                
        });
    
    });
    </script>
@endsection
