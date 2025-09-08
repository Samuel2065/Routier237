// resources/views/travel/results.blade.php
@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h2>Résultats de recherche</h2>
            <p class="text-muted">
                Trajets disponibles le {{ $searchParams['date']->format('d/m/Y') }}
            </p>
        </div>
    </div>

    @if($routes->count() > 0)
        <div class="row">
            @foreach($routes as $route)
                @php
                    $schedule = $route->schedules->first();
                @endphp
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    @if($route->agency->logo)
                                        <img src="{{ asset('storage/' . $route->agency->logo) }}" 
                                             alt="{{ $route->agency->name }}" 
                                             class="img-fluid" style="max-height: 50px;">
                                    @endif
                                    <h6 class="mt-2 mb-0">{{ $route->agency->name }}</h6>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ $route->departure_time->format('H:i') }}</h5>
                                        <p class="mb-0 text-muted">{{ $route->departureDestination->city }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <i class="bi bi-arrow-right fs-4 text-primary"></i>
                                    <p class="mb-0 small text-muted">{{ $route->bus_type }}</p>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h5 class="mb-1">{{ $route->arrival_time->format('H:i') }}</h5>
                                        <p class="mb-0 text-muted">{{ $route->arrivalDestination->city }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <h4 class="text-success mb-1">{{ number_format($schedule->current_price, 0, ',', ' ') }} FCFA</h4>
                                    <p class="mb-2 small text-muted">{{ $schedule->available_seats }} places</p>
                                    <a href="{{ route('agency.details', $route->agency->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        Réserver
                                    </a>
                                </div>
                            </div>
                            
                            @if($route->amenities)
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <small class="text-muted">
                                            Services: 
                                            @foreach($route->amenities as $amenity)
                                                <span class="badge bg-light text-dark me-1">{{ $amenity }}</span>
                                            @endforeach
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4>Aucun trajet trouvé</h4>
                    <p>Essayez de modifier vos critères de recherche.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Nouvelle recherche</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection