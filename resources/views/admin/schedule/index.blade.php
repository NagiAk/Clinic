@extends('dashboard')

@section('content')
<style>
    
    .pr{
        background: linear-gradient(135deg, #01284b 0%, #b3e7b6 100%);
    }
</style>
    <div class="container">
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
        <h1>Schedule</h1>
        <a href="{{ route('schedule.generate') }}" class="btn btn-primary mb-3">Creer Schedule</a>
        <form action="{{ route('schedule.index') }}" method="Post">
            @csrf
            @method('get')
            <div class="form-group">
                <label for="medecin_id">Select Medecin:</label>
                <select name="medecin_id" id="medecin_id" class="form-control">
                    <option value="">Select Medecin</option>
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}" {{ isset($selectedMedecin) && $medecin->id == $selectedMedecin->id ? 'selected' : '' }}>{{ $medecin->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date_filter">Select Date:</label>
                <input type="date" name="date_filter" id="date_filter" class="form-control" value="{{ $dateFilter }}">
            </div>
            <button type="submit" class="btn btn-primary">Chercher</button>
        </form>

        @if(isset($schedules))
            <h2>Schedule for {{ $selectedMedecin->name }}:</h2>
            <div class="row">
                @foreach($schedules as $schedule)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title">{{ \Carbon\Carbon::parse($schedule->date)->format('l, F j, Y') }}</h5>
                            </div>
                            <div class="card-body pr">
                                <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</h6>
                                <p class="card-text">
                                    Status: 
                                    @if($schedule->status == 'available')
                                        <span class="badge bg-success">{{ ucfirst($schedule->status) }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($schedule->status) }}</span>
                                    @endif
                                </p>
                                {{-- <div class="d-flex justify-content-between">
                                    <a href="{{ route('medecin.schedule.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('medecin.schedule.destroy', $schedule->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                                    </form>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                
        @endif
    </div>
@endsection