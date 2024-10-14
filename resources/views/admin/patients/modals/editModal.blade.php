<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Modifier Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPatientForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit_patient_id" name="patient_id">

                    <div class="form-group">
                        <label for="edit_nom">Last Name</label>
                        <input type="text" class="form-control" id="edit_nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_prenom">First Name</label>
                        <input type="text" class="form-control" id="edit_prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_gender">Gender</label>
                        <select class="form-control" id="edit_gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="edit_cin">CIN</label>
                        <input type="text" class="form-control" id="edit_cin" name="cin" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const patientId = this.getAttribute('data-id');
                const nom = this.getAttribute('data-nom');
                const prenom = this.getAttribute('data-prenom');
                const gender = this.getAttribute('data-gender');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const address = this.getAttribute('data-address');
                const cin = this.getAttribute('data-cin');

                // Populate the form fields in the modal
                document.getElementById('edit_patient_id').value = patientId;
                document.getElementById('edit_nom').value = nom;
                document.getElementById('edit_prenom').value = prenom;
                document.getElementById('edit_gender').value = gender;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value ="0"+phone;
                document.getElementById('edit_address').value = address;
                document.getElementById('edit_cin').value = cin;

                // Update form action with the patient's update route
                document.getElementById('editPatientForm').action = `/admin/patients/${patientId}`;
            });
        });
    });
</script>