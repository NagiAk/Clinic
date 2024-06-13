@extends('Mlayout')

@section('content')
<style>
    .pr{
        background: linear-gradient(135deg, #b3e7b6 60%, #01284b 40%);
    }
    .d{
        background: linear-gradient(135deg, #01284b 50%, #b3e7b6 50%);
    }
    body{
        background: linear-gradient(110deg, #8ebbe2 50%, #edf8ef 50%);

    }
</style>
<div class="container mt-5">
    <h2>Schedule</h2>
    
    <form method="Post" action="{{ route('medecin.schedule.index') }}" class="mb-4">
        @csrf
        @method('get')
        <div class="input-group">
            <input type="date" name="date_filter" class="form-control" value="{{ $dateFilter }}">
            <button type="submit" class="btn btn-secondary">Filter by Date</button>
        </div>
    </form>
    
    <div class="row">
        @foreach($schedules as $schedule)
            <div class="col-md-4 mb-3">
                <div class="card d">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title">{{ \Carbon\Carbon::parse($schedule->date)->format('l, F j, Y') }}</h5>
                    </div>
                    <div class="card-body pr">
                        <h6 class="card-subtitle mb-2" style="color: rgba(22, 5, 59)">{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</h6>
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
</div>
@endsection
