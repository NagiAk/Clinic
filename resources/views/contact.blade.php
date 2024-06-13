@extends('layout')

@section('content')
<div class="container mt-5">
    <h2>Contact Us</h2>
    <p>If you have any questions or need to schedule an appointment, please contact us using the form below or give us a call.</p>
    
    <a class="nav-link" href="{{ url('/form') }}" style="color: #18566b;">check our Form</a>
    
</div>
@endsection
