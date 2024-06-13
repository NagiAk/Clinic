@extends('Mlayout')

@section('content')
<div class="container mt-5">
    <h2>Edit Schedule</h2>
    <form action="{{ route('medecin.schedule.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $schedule->date }}" required>
        </div>
        <div class="form-group">
            <label for="time">Time</label>
            <select class="form-control" id="time" name="time" required>
                @foreach ($timeSlots as $day => $slots)
                    <optgroup label="{{ $day }}">
                        @foreach ($slots as $slot)
                            <option value="{{ $slot }}" {{ $schedule->time == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="available" {{ $schedule->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ $schedule->status == 'booked' ? 'selected' : '' }}>Booked</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('medecin.schedule.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
