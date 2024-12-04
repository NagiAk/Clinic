{{-- resources/views/errors/error.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Error page">
    <title>Error</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @include('errors.style')
</head>
<body>
    <div class="error-container">
        <h1 class="display-1">Error 505</h1>
        <p class="lead">{{ $error ?? 'An unexpected error occurred. Please try again later.' }}</p>
        <a href="/" class="btn btn-custom mt-4">Go Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
