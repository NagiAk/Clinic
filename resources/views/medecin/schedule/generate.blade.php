@extends('Mlayout')

@section('content')
<div class="container mt-5">
    <h2>Create Schedule</h2>
    <form action="{{ route('medecin.schedule.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Generate Schedule</button>
        <a href="{{ route('medecin.schedule.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
