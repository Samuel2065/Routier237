@extends('layouts.app')

@section('title', 'Recherche de Voyages')

@section('content')
<div class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-4">Trouvez votre voyage idéal</h1>
                <p class="lead">Comparez les prix et services de plusieurs agences de voyage</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Rechercher un trajet</h3>
                    
                    <form action="{{ route('travel.search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="departure" class="form-label">Ville de départ</label>
                                <select class="form-select" id="departure" name="departure" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}">{{ $destination->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="arrival" class="form-label">Ville d'arrivée</label>
                                <select class="form-select" id="arrival" name="arrival" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}">{{ $destination->city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date de voyage</label>
                                <input type="date" class="form-control" id="date" name="date" 
                                       value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section des agences populaires -->
<div class="container my-5">
    <h2 class="text-center mb-4">Nos Agences Partenaires</h2>
    <div class="row">
        @foreach($agencies->take(6) as $agency)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    @if($agency->logo)
                        <img src="{{ asset('storage/' . $agency->logo) }}" 
                             alt="{{ $agency->name }}" class="img-fluid mb-3" style="max-height: 80px;">
                    @endif
                    <h5 class="card-title">{{ $agency->name }}</h5>
                    <p class="card-text">{{ Str::limit($agency->description, 100) }}</p>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $agency->rating ? '-fill' : '' }} text-warning"></i>
                        @endfor
                        <small class="text-muted">({{ $agency->rating }}/5)</small>
                    </div>
                    <a href="{{ route('agency.details', $agency->id) }}" class="btn btn-outline-primary">
                        Voir les détails
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection