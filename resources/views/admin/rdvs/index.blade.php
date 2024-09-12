@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Appointments</h2>
    

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('rdvs.index') }}" method="GET" class="mb-3">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="date_filter">Filter by Date:</label>
                <input type="date" class="form-control" id="date_filter" name="date_filter" value="{{ request('date_filter') }}">
            </div>
            <div class="form-group col-md-3">
                <label for="status_filter">Filter by Status:</label>
                <select name="etat_de_rdv" id="status_filter" class="form-control">
                    <option value="">All</option>
                    <option value="encour" {{ request('etat_de_rdv') === 'encour' ? 'selected' : '' }}>Encour</option>
                    <option value="realise" {{ request('etat_de_rdv') === 'realise' ? 'selected' : '' }}>Realized</option>
                    <option value="annuler" {{ request('etat_de_rdv') === 'annuler' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="specialite_filter">Filter by Specialty:</label>
                <select name="specialite_filter" id="specialite_filter" class="form-control">
                    <option value="">All</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite->id }}" {{ request('specialite_filter') == $specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="medecin_filter">Filter by Medecin:</label>
                <select name="medecin_filter" id="medecin_filter" class="form-control">
                    <option value="">All</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group "style='width:100px'>
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>

    <button type="button" style='width:100px' class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#createRdvModal">Add New</button>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th style="color:#8d4949;">ID</th>
                    <th style="color:#8d4949;">Patient</th>
                    <th style="color:#8d4949;">Medecin</th>
                    <th style="color:#8d4949;">Date</th>
                    <th style="color:#8d4949;">Time</th>
                    <th style="color:#8d4949;">Status</th>
                    <th style="color:#8d4949;">Actions</th>
                </tr>
            </thead>        
            <tbody class="table-info">
                @foreach ($rdvs as $rdv)
                <tr class="text-center">
                    <td>{{ $rdv->id }}</td>
                    <td>{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}</td>
                    <td>Dr. {{ $rdv->medecin->user->name }}</td>
                    <td>{{ $rdv->schedule->date }}</td>
                    <td>{{ $rdv->schedule->time }}</td>
                    <td>
                        <div class="p-0 rounded {{ $rdv->etat_de_rdv === 'realise' ? 'bg-success text-white' : ($rdv->etat_de_rdv === 'annuler' ? 'bg-danger text-white' : '') }}">
                            {{ $rdv->etat_de_rdv }}
                        </div>
                    </td>
                    <td>
                        @if ($rdv->etat_de_rdv === 'encour')
                            <form action="{{ route('rdvs.updateEtat', $rdv->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="etat_de_rdv" value="annuler">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Cancel</button>
                            </form>
                            <form action="{{ route('rdvs.updateEtat', $rdv->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="etat_de_rdv" value="realise">
                                <button type="submit" class="btn btn-outline-success btn-sm">Realize</button>
                            </form>
                            {{-- <a href="{{ route('rdvs.edit', $rdv->id ) }}" class="btn btn-outline-primary btn-sm">Edit</a> --}}
                            <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editRdvModal" 
                                    data-id="{{ $rdv->id }}" 
                                    data-patient="{{ $rdv->patient_id }}" 
                                    data-specialite="{{ $rdv->specialite_id }}" 
                                    data-medecin="{{ $rdv->medecin_id }}" 
                                    data-schedule="{{ $rdv->schedule->date }} {{ $rdv->schedule->time }}">
                                Edit
                            </button>
                        @endif
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Appointment Modal -->
<div class="modal fade" id="createRdvModal" tabindex="-1" role="dialog" aria-labelledby="createRdvModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRdvModalLabel">Schedule New Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createRdvForm" action="{{ route('rdvs.store') }}" method="POST">
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
                        <label for="schedule_id">Available Date and Time</label>
                        <input type="text" id="datetime" class="form-control @error('schedule_id') is-invalid @enderror" required>
                        <input type="hidden" name="schedule_id" id="schedule_id" required>
                        @error('schedule_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="no-schedule-found" class="" ></div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

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

            medecins.filter(med => med.specialites_id == specialiteId).forEach(med => {
                const option = document.createElement('option');
                option.value = med.id;
                option.textContent = med.user.name;
                medecinSelect.appendChild(option);
            });
        });

        medecinSelect.addEventListener('change', function () {
            const medecinId = 1; 

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

            fetchSchedules(medecinId).then((schedules) => {
                console.log(schedules); 

                if (schedules.length > 0) {
                    initializeFlatpickr(schedules); 
                } else {
                    console.log("No schedules found");
                }
            }).catch((error) => {
                console.error('Error in Promise chain:', error);
            });

            /**
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
             * @param {Array} schedules 
             * @param {string} dateStr 
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


{{-- Edit Modal --}}
<div class="modal fade" id="editRdvModal" tabindex="-1" role="dialog" aria-labelledby="editRdvModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRdvModalLabel">Edit Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRdvForm" action="{{ route('rdvs.update', $rdv->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_rdv_id">
                    <div class="form-group">
                        <label for="edit_patient_id">Patient</label>
                        <input type="text" class="form-control" id="edit_patient_id" name="patient_id" autocomplete="off" list="edit_patientsList" required>
                        <datalist id="edit_patientsList">
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
                            @endforeach
                        </datalist>
                        @error('patient_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_specialite_id">Specialty</label>
                        <select name="specialite_id" id="edit_specialite_id" class="form-control" required>
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
                        <label for="edit_medecin_id">Medecin</label>
                        <select name="medecin_id" id="edit_medecin_id" class="form-control" required>
                            <option value="">Select Medecin</option>
                        </select>
                        @error('medecin_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_schedule_id">Available Date and Time</label>
                        <input type="text" id="edit_datetime" class="form-control @error('schedule_id') is-invalid @enderror" required>
                        <input type="hidden" name="schedule_id" id="edit_schedule_id" required>
                        @error('schedule_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="edit_no-schedule-found" class=""></div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const specialiteSelect = document.getElementById('edit_specialite_id');
        const medecinSelect = document.getElementById('edit_medecin_id');
        const scheduleInput = document.getElementById('edit_schedule_id');
        const datetimeInput = document.getElementById('edit_datetime');
        const noScheduleFoundDiv = document.getElementById('edit_no-schedule-found');
    
        const medecins = @json($specialites->flatMap->medecins);
    
        specialiteSelect.addEventListener('change', function () {
            const specialiteId = this.value;
            medecinSelect.innerHTML = '<option value="">Select Medecin</option>';
    
            const filteredMedecins = medecins.filter(med => med.specialites_id == specialiteId);
    
            filteredMedecins.forEach(med => {
                const option = document.createElement('option');
                option.value = med.id;
                option.textContent = med.user.name;
                medecinSelect.appendChild(option);
            });
        });
    
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const patientId = this.dataset.patient;
                const specialiteId = this.dataset.specialite;
                const medecinId = this.dataset.medecin;
                const scheduleDateTime = this.dataset.schedule; 
    
                document.getElementById('editRdvForm').action = `/admin/rdvs/${id}`;
    
                document.getElementById('edit_patient_id').value = patientId;
                specialiteSelect.value = specialiteId;
                medecinSelect.innerHTML = '<option value="">Select Medecin</option>'; 
    
                const filteredMedecins = medecins.filter(med => med.specialites_id == specialiteId);
                filteredMedecins.forEach(med => {
                    const option = document.createElement('option');
                    option.value = med.id;
                    option.textContent = med.user.name;
                    medecinSelect.appendChild(option);
                });
    
                medecinSelect.value = medecinId;
    
                if (scheduleDateTime) {
                    
                    const parsedDate = new Date(scheduleDateTime);
                    const formattedDateTime = parsedDate.toISOString().slice(0, 16);
                    
                    console.log('Formatted DateTime:', formattedDateTime); 
    
                    flatpickr(datetimeInput, {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        minuteIncrement: 30,
                        defaultDate: formattedDateTime,
                        onChange: function(selectedDates, dateStr, instance) {
                            handleEditScheduleSelection(medecinId, dateStr);
                        }
                    });
                } else {
                    console.error('Invalid or missing scheduleDateTime:', scheduleDateTime);
                }
    
                function handleEditScheduleSelection(medecinId, dateStr) {
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
    
                    fetchSchedules(medecinId).then((schedules) => {
                        const selectedSchedule = schedules.find(schedule => {
                            const scheduleDateTime = `${schedule.date} ${schedule.time}`;
                            const formattedDateTime = `${schedule.date} ${schedule.time.substr(0, 5)}`;
                            return formattedDateTime === dateStr;
                        });
    
                        if (selectedSchedule) {
                            scheduleInput.value = selectedSchedule.id;
                            noScheduleFoundDiv.innerHTML = 'Date and Time are valid.';
                            noScheduleFoundDiv.className = 'alert alert-success mt-2';
                        } else {
                            scheduleInput.value = '';
                            noScheduleFoundDiv.className = 'alert alert-warning mt-2';
                            noScheduleFoundDiv.innerHTML = 'Date And Time are invalid.';
                        }
                    }).catch((error) => {
                        console.error('Error in Promise chain:', error);
                    });
                }
            });
        });
    });
</script>
    
    
    
    
    

@endsection
