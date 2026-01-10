<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
    <h1>Search Results</h1>

    @foreach ($trips as  $trip)
        <div class="card">
            <h2>{{ $trip->agence->name }}</h2>
            <p>Departure Town: {{ $trip->departure_town}}</p>
            <p>Arrival Town: {{ $trip->arrival_town}}</p>
            <p>Departure Time: {{ $trip->departure_time}}</p>
            <p>Price: {{ $trip->price}} FCFA</p>
            <button type="submit">Book</button>
        </div>
    @endforeach
</body>
</html>

