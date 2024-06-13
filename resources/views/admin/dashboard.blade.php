@extends('dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Welcome {{Auth::user()->name}} to the Admin Dashboard</h2>
    <p>This is the main content area for the admin dashboard.</p>
    <!-- Add your dashboard content here -->
</div>
@endsection
