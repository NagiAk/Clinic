<div class="modal fade" id="createRdvModal" tabindex="-1" role="dialog" aria-labelledby="createRdvModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRdvModalLabel">Nouveau Rdv</h5>
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
                    <button type="submit" class="btn btn-success">Add</button>
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