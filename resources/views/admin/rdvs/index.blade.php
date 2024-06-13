@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2>Appointments</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>

    <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal" data-target="#createRdvModal">Add New</button>
    
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
                            <a href="{{ route('rdvs.edit', $rdv->id ) }}" class="btn btn-outline-primary">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const specialiteSelect = document.getElementById('specialite_filter');
        const medecinSelect = document.getElementById('medecin_filter');
        const allMedecins = @json($specialites->flatMap->medecins);
    
        function updateMedecinSelect() {
            const specialiteId = specialiteSelect.value;
            medecinSelect.innerHTML = '<option value="">All</option>';
    
            const filteredMedecins = allMedecins.filter(med => med.specialite_id == specialiteId);
            filteredMedecins.forEach(med => {
                const option = document.createElement('option');
                option.value = med.id;
                option.textContent = med.user.name;
                medecinSelect.appendChild(option);
            });
    
            if (medecinSelect.dataset.value) {
                medecinSelect.value = medecinSelect.dataset.value;
                medecinSelect.dataset.value = '';
            }
        }
    
        specialiteSelect.addEventListener('change', updateMedecinSelect);
    
        if (specialiteSelect.value) {
            specialiteSelect.dispatchEvent(new Event('change'));
        }
    
        medecinSelect.dataset.value = '{{ request('medecin_filter') }}';
    
        // Similar logic for the modal form
        const modalSpecialiteSelect = document.getElementById('specialite_id');
        const modalMedecinSelect = document.getElementById('medecin_id');
        modalSpecialiteSelect.addEventListener('change', function () {
            const specialiteId = modalSpecialiteSelect.value;
            modalMedecinSelect.innerHTML = '<option value="">Select Medecin</option>';
    
            const filteredMedecins = allMedecins.filter(med => med.specialite_id == specialiteId);
            filteredMedecins.forEach(med => {
                const option = document.createElement('option');
                option.value = med.id;
                option.textContent = med.user.name;
                modalMedecinSelect.appendChild(option);
            });
        });
    });
    </script>

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
                        <select name="schedule_id" id="schedule_id" class="form-control" required>
                            <option value="">Select Date and Time</option>
                        </select>
                        @error('schedule_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->

{{-- <div class="modal fade" id="editRdvModal" tabindex="-1" role="dialog" aria-labelledby="editRdvModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRdvModalLabel">Edit Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRdvForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_patient_id">Patient</label>
                        <input type="text" class="form-control" id="edit_patient_id" name="patient_id" autocomplete="off" list="patientsList" value="{{ $rdv->patient->nom }} {{ $rdv->patient->prenom }}" required>
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
                        <label for="edit_specialite_id">Specialty</label>
                        <select name="specialite_id" id="edit_specialite_id" class="form-control" required>
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
                        <select name="schedule_id" id="edit_schedule_id" class="form-control" required>
                            <option value="">Select Date and Time</option>
                        </select>
                        @error('schedule_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const specialiteSelect = document.getElementById('specialite_id');
    const medecinSelect = document.getElementById('medecin_id');
    const scheduleSelect = document.getElementById('schedule_id');
    const editSpecialiteSelect = document.getElementById('edit_specialite_id');
    const editMedecinSelect = document.getElementById('edit_medecin_id');
    const editScheduleSelect = document.getElementById('edit_schedule_id');
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
        const medecinId = this.value;
        fetch(`/admin/${medecinId}/schedules`)
            .then(response => response.json())
            .then(schedules => {
                scheduleSelect.innerHTML = '<option value="">Select Date and Time</option>';
                
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);

                schedules.forEach(schedule => {
                    const scheduleDate = new Date(schedule.date);
                    if (scheduleDate >= tomorrow) {
                        const option = document.createElement('option');
                        option.value = schedule.id;
                        option.textContent = `${schedule.date} at ${schedule.time}`;
                        scheduleSelect.appendChild(option);
                    }
                });
            });
    });

    editSpecialiteSelect.addEventListener('change', function () {
        const specialiteId = this.value;
        editMedecinSelect.innerHTML = '<option value="">Select Medecin</option>'; 

        medecins.filter(med => med.specialite_id == specialiteId).forEach(med => {
            const option = document.createElement('option');
            option.value = med.id;
            option.textContent = med.user.name;
            editMedecinSelect.appendChild(option);
        });
    });

    editMedecinSelect.addEventListener('change', function () {
        const medecinId = this.value;
        fetch(`/admin/${medecinId}/schedules`)
            .then(response => response.json())
            .then(schedules => {
                editScheduleSelect.innerHTML = '<option value="">Select Date and Time</option>';
                schedules.forEach(schedule => {
                    const option = document.createElement('option');
                    option.value = schedule.id;
                    option.textContent = `${schedule.date} at ${schedule.time}`;
                    editScheduleSelect.appendChild(option);
                });
            });
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const appointment = JSON.parse(this.getAttribute('data-appointment'));
            const form = document.getElementById('editRdvForm');
            form.action = `/rdvs/${appointment.id}`;

            document.getElementById('edit_patient_id').value = appointment.patient_id;
            document.getElementById('edit_specialite_id').value = appointment.medecin.specialite_id;
            document.getElementById('edit_medecin_id').value = appointment.medecin_id;

            // Trigger change events to populate medecin and schedule select elements
            editSpecialiteSelect.dispatchEvent(new Event('change'));
            setTimeout(() => {
                editMedecinSelect.dispatchEvent(new Event('change'));
                setTimeout(() => {
                    document.getElementById('edit_schedule_id').value = appointment.schedule_id;
                }, 300);
            }, 300);

            $('#editRdvModal').modal('show');
        });
    });
});
</script>
@endsection
