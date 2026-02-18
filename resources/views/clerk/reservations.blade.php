<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clerk Reservations - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Reservations</h2>
            <a href="{{ route('counter_clerk.reservations.create') }}" class="btn btn-primary">New Reservation</a>
        </div>

        <div class="card">
            <div class="card-body">
                <p class="mb-0 text-muted">Agency: {{ $agency->name }}</p>
            </div>
        </div>
    </div>
</body>
</html>
