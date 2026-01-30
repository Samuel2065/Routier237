@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h2 class="fw-bold mb-3">
        Résultats pour {{ $city->name }}
    </h2>

    <p class="text-muted mb-4">
        Trajet : {{ request('from') }} → {{ request('to') }}
        @if(request('date'))
            | {{ request('date') }}
        @endif
    </p>

    <hr>

    {{-- ICI plus tard : cards des agences --}}
    <div class="text-center text-muted">
        Résultats des agences ici...
    </div>

</div>

@endsection
