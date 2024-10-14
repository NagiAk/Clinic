<div class="modal fade" id="createMedecinModal" tabindex="-1" aria-labelledby="createMedecinLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMedecinLabel">Create Medecin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('medecins.store') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Specialite Select -->
                    <div class="form-group row">
                        <label for="specialite_id" class="col-md-4 col-form-label text-md-right">Specialite</label>
                        <div class="col-md-6">
                            <select id="specialite_id" class="form-control @error('specialite_id') is-invalid @enderror" name="specialite_id" required>
                                <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>{{ $specialite->nom }}</option>
                            </select>
                            @error('specialite_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#createMedecinModal').on('hidden.bs.modal', function () {
            var form = $(this).find('form');
            form[0].reset();
            form.find('.invalid-feedback').remove(); 
            form.find('.form-control').removeClass('is-invalid'); 
        });

        $('#createMedecinModal form').on('submit', function(e) {
            e.preventDefault(); 

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    window.location.href = response.redirectUrl; 
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

