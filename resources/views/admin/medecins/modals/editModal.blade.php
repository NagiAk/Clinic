<!-- Edit Medecin Modal -->
<div class="modal fade blr" id="editMedecinModal" tabindex="-1" aria-labelledby="editMedecinLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-style-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMedecinLabel">Edit Medecin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMedecinForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input to store medecin ID -->
                    <input type="hidden" id="editMedecinId" name="medecin_id">

                    <!-- Name Field -->
                    <div class="form-group row">
                        <label for="editName" class="col-md-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input id="editName" type="text" class="form-control" name="name" required autofocus>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group row">
                        <label for="editEmail" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input id="editEmail" type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group row">
                        <label for="editPassword" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input id="editPassword" type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="form-group row">
                        <label for="editPasswordConfirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="editPasswordConfirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <!-- Specialites Dropdown -->
                    <div class="form-group row">
                        <label for="editSpecialite" class="col-md-4 col-form-label text-md-right">Specialites</label>
                        <div class="col-md-6">
                            <select id="editSpecialite" class="form-control" name="specialite_id" required>
                                <!-- Loop through all specialites to populate dropdown -->
                                @foreach($specialites as $specialite)
                                    <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-style-modal">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script for Modal Behavior -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Reset form when the modal is hidden
        $('#editMedecinModal').on('hidden.bs.modal', function () {
            var form = $(this).find('form');
            form[0].reset();
            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
        });

        // Populate modal fields with current medecin data
        $('#editMedecinModal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget);
            var medecinId = button.data('id');
            var actionUrl = button.data('url');
            var name = button.data('name');
            var email = button.data('email');
            var specialite_id = button.data('specialite_id');

            // Set form action and field values
            $('#editMedecinForm').attr('action', actionUrl);
            $('#editMedecinId').val(medecinId);
            $('#editName').val(name);
            $('#editEmail').val(email);

            // Set the current selected specialite
            $('#editSpecialite').val(specialite_id);
        });

        // Submit form via AJAX
        $('#editMedecinForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editMedecinModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');

                    $.each(errors, function(key, error) {
                        var input = form.find('[name=' + key + ']');
                        input.addClass('is-invalid');
                        input.after('<span class="invalid-feedback"><strong>' + error[0] + '</strong></span>');
                    });
                }
            });
        });
    });
</script>
