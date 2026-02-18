<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4">Create Reservation</h2>

        <form method="POST" action="{{ route('counter_clerk.reservations.store') }}" class="card card-body">
            @csrf
            <div class="mb-3">
                <label class="form-label">Customer Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Customer Phone</label>
                <input type="text" name="customer_phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Route ID</label>
                <input type="number" name="route_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Departure Date</label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Seat Number</label>
                <input type="text" name="seat_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>
