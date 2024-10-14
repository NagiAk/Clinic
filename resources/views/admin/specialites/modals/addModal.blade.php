<div class="modal fade" id="createSpecialiteModal" tabindex="-1" role="dialog" aria-labelledby="createPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSpecialiteModalLabel">Nouveau Specialite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createSpecialiteForm" action="{{ route('specialites.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Specialite Name</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>