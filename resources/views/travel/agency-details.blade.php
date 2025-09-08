// resources/views/travel/agency-details.blade.php
@extends('layouts.app')

@section('title', $agency->name)

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" 
                                     alt="{{ $agency->name }}" 
                                     class="img-fluid mb-3" style="max-height: 100px;">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h2>{{ $agency->name }}</h2>
                            <div class="mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $agency->rating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                                <span class="ms-2">({{ $agency->rating }}/5)</span>
                            </div>
                            <p class="lead">{{ $agency->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-header">
                    <h4>Trajets disponibles</h4>
                </div>
                <div class="card-body">
                    @if($agency->routes->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Départ</th>
                                        <th>Arrivée</th>
                                        <th>Heure</th>
                                        <th>Prix</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agency->routes as $route)
                                    <tr>
                                        <td>{{ $route->departureDestination->city }}</td>
                                        <td>{{ $route->arrivalDestination->city }}</td>
                                        <td>{{ $route->departure_time->format('H:i') }} - {{ $route->arrival_time->format('H:i') }}</td>
                                        <td>{{ number_format($route->price, 0, ',', ' ') }} FCFA</td>
                                        <td><span class="badge bg-info">{{ $route->bus_type }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Aucun trajet disponible pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Informations de contact</h5>
                </div>
                <div class="card-body">
                    <p><i class="bi bi-telephone"></i> {{ $agency->phone }}</p>
                    <p><i class="bi bi-envelope"></i> {{ $agency->email }}</p>
                    <p><i class="bi bi-geo-alt"></i> {{ $agency->address }}, {{ $agency->city }}</p>
                    
                    <div class="d-grid gap-2 mt-3">
                        <a href="tel:{{ $agency->phone }}" class="btn btn-success">
                            <i class="bi bi-telephone"></i> Appeler maintenant
                        </a>
                        <a href="mailto:{{ $agency->email }}" class="btn btn-outline-primary">
                            <i class="bi bi-envelope"></i> Envoyer un email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection