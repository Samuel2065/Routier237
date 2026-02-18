<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Register - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4">Cash Register</h2>
        <p class="text-muted">Agency: {{ $agency->name }}</p>

        <div class="row g-3">
            <div class="col-md-6">
                <form method="POST" action="{{ route('counter_clerk.cash_register.open') }}" class="card card-body">
                    @csrf
                    <h5>Open Register</h5>
                    <div class="mb-3">
                        <label class="form-label">Opening Balance</label>
                        <input type="number" name="opening_balance" min="0" class="form-control" required>
                    </div>
                    <button class="btn btn-success" type="submit">Open</button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('counter_clerk.cash_register.close') }}" class="card card-body">
                    @csrf
                    <h5>Close Register</h5>
                    <div class="mb-3">
                        <label class="form-label">Closing Balance</label>
                        <input type="number" name="closing_balance" min="0" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <button class="btn btn-danger" type="submit">Close</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
