@extends('layouts.app')

@section('content')

<style>
.marketplace-hero {
    height: 100vh;
    background-color: #1f6eff;
    display: flex;
    align-items: center;
    overflow: hidden;
    padding-top: 90px;
    margin-bottom: 40px;
}

.popular-box {
    border: 1px solid #dee2e6;
    padding: 16px;
    border-radius: 10px;
    text-align: center;
    font-size: 15px;
    background: #f8f9fa;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ================= CITY CARDS ================= */

.city-hover {
    transition: all .35s ease;
}

.city-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(0,0,0,.15);
}

.city-image-wrapper {
    height: 180px;
    overflow: hidden;
    position: relative;
}

.city-image {
    height: 100%;
    background-size: cover;
    background-position: center;
    transition: transform .45s ease;
}

/* zoom image */
.city-hover:hover .city-image {
    transform: scale(1.08);
}

/* voile animation */
.city-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,.65) 0%,
        rgba(0,0,0,.35) 40%,
        transparent 100%
    );
    transform: translateY(0);
    transition: transform .45s ease;
}

.city-hover:hover .city-overlay {
    transform: translateY(-25px);
}

h6{
    font-size: 20px;
}
</style>

{{-- ================= HERO / FORMULAIRE ================= --}}
<section class="marketplace-hero">
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-12 col-lg-10">

                <div class="text-center text-white mb-5">
                    <h1 class="fw-bold display-5 mb-3">
                        Trouvez votre trajet idéal
                    </h1>
                    <p class="lead mb-0">
                        Rechercher parmi toutes les agences et destinations du Cameroun
                    </p>
                </div>

                <div class="card shadow-lg border-0" style="border-radius:24px;">
                    <div class="card-body p-3 p-md-5">

                    <form method="GET" action="{{ route('marketplace.city', strtolower($request->from ?? 'yaounde')) }}">

                            <div class="row g-3">

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Ville de départ</label>
                                    <select name="from" class="form-select" required>
                                        <option value="">Choisir</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Destination</label>
                                    <select name="to" class="form-select" required>
                                        <option value="">Choisir</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Date</label>
                                    <input type="date" name="date" class="form-control">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Classe</label>
                                    <select name="service_type" class="form-select">
                                        <option value="">Toutes</option>
                                        <option value="Normal">Classique</option>
                                        <option value="Express">Express</option>
                                        <option value="VIP">VIP</option>
                                    </select>
                                </div>

                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary w-100 py-2 fw-semibold d-flex justify-content-center align-items-center gap-2">
                                        <i class="fas fa-search"></i> Rechercher
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top">
                                <h6 class="fw-semibold mb-3 text-start" style="color:#0d6efd;">
                                    Trajets populaires
                                </h6>

                                <div class="row g-3">
                                    <div class="col-6 col-md-3"><div class="popular-box">Yaoundé → Douala</div></div>
                                    <div class="col-6 col-md-3"><div class="popular-box">Douala → Bafoussam</div></div>
                                    <div class="col-6 col-md-3"><div class="popular-box">Yaoundé → Garoua</div></div>
                                    <div class="col-6 col-md-3"><div class="popular-box">Buea → Douala</div></div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ================= CHOISIR VOTRE VILLE ================= --}}
<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Choisissez votre ville</h2>
            <p class="text-muted">
                Sélectionnez une ville pour voir toutes les agences de transport disponibles
            </p>
        </div>

        <div class="row g-4">

            @php
                $cities = [
                    ['name'=>'Bertoua','region'=>'Est','agencies'=>15,'routes'=>120, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Yaoundé','region'=>'Centre','agencies'=>42,'routes'=>310, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Douala','region'=>'Littoral','agencies'=>55,'routes'=>420, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Bafoussam','region'=>'Ouest','agencies'=>21,'routes'=>180, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Garoua','region'=>'Nord','agencies'=>14,'routes'=>95, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Maroua','region'=>'Extrême-Nord','agencies'=>11,'routes'=>70, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Bamenda','region'=>'Nord-Ouest','agencies'=>18,'routes'=>130, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                    ['name'=>'Buea','region'=>'Sud-Ouest','agencies'=>16,'routes'=>110, 'images'=> 'assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png'],
                ];
            @endphp

            @foreach($cities as $city)
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="card border-0 rounded-4 overflow-hidden h-100 city-hover">

                        <div class="city-image-wrapper">
                            <div class="city-image"
                                 style="background-image:url('{{ asset($city['images']) }}');">
                            </div>

                            <div class="city-overlay p-3 d-flex text-start" style="margin-top: 110px;">
                                <div class="w-100">
                                    <h6 class="fw-bold text-white mb-0">{{ $city['name'] }}</h6>
                                    <small class="text-white-50">{{ $city['region'] }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2 text-dark">
                                <span class="text-dark"><i class="fas fa-building"></i> {{ $city['agencies'] }} agences</span>
                                <span class="text-dark"><i class="fas fa-route"></i> {{ $city['routes'] }} trajets</span>
                                
                            </div>

                            <a href="#"
                               class="fw-semibold text-primary text-decoration-none d-flex justify-content-between align-items-center">
                                <span style="color: #0d6efd;">Voir les agences <i class="fas fa-arrow-right" style="margin-left: 80px;"></i></span>
                            </a>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>

@endsection
