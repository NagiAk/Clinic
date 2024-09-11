@extends('dashboard')

@section('content')
    <div class="container mt-5">
        <h1 class="mt-5 mb-4">Emails List</h1>
        <div class="form-group col-md-6">
            <form action="{{ route('emails.filter') }}" method="POST" class="mb-3">
                @csrf
                @method('get')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="date_filter">Filter by Date:</label>
                        <input type="date" class="form-control" id="date_filter" name="date_filter" value="{{ request('date_filter') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('emails.index') }}" method="POST" class="mb-3">
                @csrf
                @method('get')
                <div class="form-group col-md-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block ">Refresh</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <form action="{{ route('validation.process') }}" method="POST">
                @csrf
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th scope="col" style="color:#8d4949;">From</th>
                            <th scope="col" style="color:#8d4949;">Subject</th>
                            <th scope="col" style="color:#8d4949;">Info</th>
                            <th scope="col" style="color:#8d4949;">rec date</th>
                            <th scope="col" style="color:#8d4949;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-info">
                        @foreach($emails as $email)
                            @if ($email['subject'] === "Demande de Rendez-vous")
                                @php
                                    
                                    $sender = preg_match('/<(.*?)>/', $email['sender'], $matches) ? $matches[1] : $email['sender'];
                                    preg_match_all('/\[(.*?)\]/', $email['body'], $matches);
                                    $info = implode(', ', $matches[1]); 
                                    $infoArray = explode(', ', $info);
                                    $namePattern = '/^[A-Za-zÀ-ÖØ-öø-ÿ\-\' ]+$/u'; // Matches letters, spaces, and certain special characters in names
                                    $emailPattern = '/^\S+@\S+\.\S+$/'; // Matches a valid email address
                                    $cinPattern = '/^[A-Za-z](?=.{7}$)\d{7}|[A-Za-z]{2}(?=.{6}$)\d{6}$/';
                                    $datePattern = '/^\d{4}-\d{2}-\d{2}$/'; // Matches a date in YYYY-MM-DD format
                                    $phonePattern = '/^\d{10}$/'; // Matches a 10-digit phone number
                                    if (count($infoArray) == 6 &&
                                    preg_match($namePattern, $infoArray[0]) &&
                                    preg_match($emailPattern, $infoArray[4]) &&
                                    preg_match($cinPattern, $infoArray[3]) &&
                                    preg_match($datePattern, $infoArray[2]) &&
                                    preg_match($phonePattern, $infoArray[5])){
                                        $rowClass = 'table-success';
                                    }
                                    else{
                                        $rowClass = 'table-danger';
                                    }
                                @endphp
                                <tr class="{{ $rowClass }} text-center">
                                    <td>{{ $sender }}</td>
                                    <td>{{ $email['subject'] }}</td>
                                    <td>{{ $info }}</td>
                                    <td>{{ $email['received_date'] }}</td>
                                    <td>
                                        <input type="checkbox" name="validated_emails[]" value="{{$sender .', '. $email->id .', '. $info}}" {{ $email['validated'] ? 'disabled' : '' }}>
                                    </td>
                                    
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-outline-primary">Valider la sélection</button>
            </form>
            <div class="d-flex justify-content-center mt-4">
                {{ $emails->links() }}
            </div>
        </div>
    </div>
@endsection

