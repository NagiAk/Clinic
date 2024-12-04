<div class="modal fade blr" id="editRdvModal" tabindex="-1" role="dialog" aria-labelledby="editRdvModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-style-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRdvModalLabel">Modifier Rdv</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                                <option value="{{ $specialite->id }}" {{ $rdv->medecin->specialite->id == $specialite->id ? "selected" : "" }}>
                                    {{ $specialite->nom }}
                                </option>
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
                    <button type="submit" class="btn btn-style-modal custom-button">Update</button>
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
            
            console.log("d ID",specialiteId);
            medecinSelect.innerHTML = '<option value="">Select Medecin</option>';

            // Filter medecins based on the selected specialty
            const filteredMedecins = medecins.filter(med => med.specialites_id == specialiteId);
            
            filteredMedecins.forEach(med => {
                const option = document.createElement('option');
                option.value = med.id;
                option.textContent = med.user.name;
                medecinSelect.appendChild(option);
            });

            // Reset schedule and input fields when changing specialty
            scheduleInput.value = '';
            datetimeInput.value = '';
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const patientId = this.dataset.patient;
                const specialiteId = this.dataset.specialite;
                const medecinId = this.dataset.medecin;
                const scheduleDateTime = this.dataset.schedule;

                // Set form action URL
                document.getElementById('editRdvForm').action = `/admin/rdvs/${id}`;

                // Set form values
                document.getElementById('edit_patient_id').value = patientId;



                console.log('data',this.dataset)
                specialiteSelect.value = specialiteId;
                medecinSelect.innerHTML = '<option value="">Select Medecin</option>';

                // Populate medecins dropdown for selected specialty
                const filteredMedecins = medecins.filter(med => med.specialites_id == specialiteId);
                filteredMedecins.forEach(med => {
                    const option = document.createElement('option');
                    option.value = med.id;
                    option.textContent = med.user.name;
                    if (med.id == medecinId) {
                        option.selected = true;
                    }
                    medecinSelect.appendChild(option);
                });

                // Set the medecin dropdown to the current one
                medecinSelect.value = medecinId;

                // Populate the schedule for selected medecin
                if (scheduleDateTime) {
                    const parsedDate = new Date(scheduleDateTime);
                    
                    const options = { 
                        year: 'numeric', 
                        month: '2-digit', 
                        day: '2-digit', 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        hour12: false,
                        timeZoneName: 'short' 
                    };

                    const formattedDateTime = parsedDate.toLocaleString('sv-SE', options).replace(' ', 'T').slice(0, 16);
                    console.log(parsedDate);
                    console.log(formattedDateTime);
                    
                    

                    flatpickr(datetimeInput, {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        minuteIncrement: 30,
                        defaultDate: formattedDateTime,
                        onChange: function(selectedDates, dateStr) {
                            handleEditScheduleSelection(medecinSelect.value, dateStr); // Use selected medecin value
                        }
                    });
                }

                // Function to fetch and handle schedules for selected medecin and date
                function handleEditScheduleSelection(medecinId, dateStr) {
                    fetchSchedules(medecinId).then((schedules) => {
                        const selectedSchedule = schedules.find(schedule => {
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
                        console.error('Error fetching schedules:', error);
                    });
                }

                // Function to fetch schedules for the selected medecin
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
            });
        });

        // Update form submission to ensure correct medecin and schedule are set
        document.getElementById('editRdvForm').addEventListener('submit', function (event) {
            const selectedMedecinId = medecinSelect.value;
            const selectedScheduleId = scheduleInput.value;

            if (!selectedMedecinId || !selectedScheduleId) {
                event.preventDefault(); // Prevent form submission if medecin or schedule is missing
                noScheduleFoundDiv.innerHTML = 'Please select a valid medecin and schedule.';
                noScheduleFoundDiv.className = 'alert alert-danger mt-2';
            }   
        });
    });
</script>
        