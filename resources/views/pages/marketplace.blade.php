@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')


    <section style="background: #2563eb; padding: 100px 0; color: white;">
        <div class="container">
            <h1 class="text-center mb-2" style="font-size: 2.5rem; font-weight: bold;">Trouvez votre trajet idéal</h1>
            <p class="text-center mb-5">Recherchez parmi toutes les agences et destinations du Cameroun</p>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow" style="border-radius: 20px; background: white; padding: 32px;">
                        <form>
                            <div class="row g-3 mb-2">
                                <div class="col-lg-3 col-md-6">
                                    <label class="mb-1" style="font-weight: 500; color: #222;">Ville de départ</label>
                                    <select class="form-select" style="border-radius: 8px;">
                                        <option>Yaoundé</option>
                                        <option>Bertoua</option>
                                        <option>Douala</option>
                                        <option value="">Bamenda</option>
                                        <option value="">Beau</option>
                                        <option value="">Maroua</option>
                                        <option value="">Garoua</option>
                                        <option value="">Ngaoundere</option>
                                        <option value="">Ebolowa</option>
                                        <option value="">Bafoussam</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                <label class="mb-1" style="font-weight: 500; color: #222;">Destinations</label>
                                    <select class="form-select" style="border-radius: 8px;">
                                        <option value="Bertoua">Bertoua</option>
                                        <option value="Yaoundé">Yaoundé</option>
                                        <option value="Douala">Douala</option>
                                        <option value="Bamenda">Bamenda</option>
                                        <option value="Beau">Beau</option>
                                        <option value="Maroua">Maroua</option>
                                        <option value="Garoua">Garoua</option>
                                        <option value="Ngaoundere">Ngaoundere</option>
                                        <option value="Ebolowa">Ebolowa</option>
                                        <option value="Bafoussam">Bafoussam</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="mb-1" style="font-weight: 500; color: #222;">Date de voyage</label>
                                    <div class="input-group position-relative">
                                        <input type="date" class="form-control" placeholder="mm/dd/yyyy" style="border-radius: 8px;">
                                        <span class="position-absolute" style="right: 65px; top: 50%; transform: translateY(-50%);">
                                            <i class="fas fa-calendar text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="mb-1" style="font-weight: 500; color: #222;">Classe de transport</label>
                                    <div class="input-group position-relative">
                                        <select class="form-select" style="border-radius: 8px;">
                                            <option>Toutes les classes</option>
                                            <option>VIP</option>
                                            <option>Classique</option>
                                        </select>
                                        <span class="position-absolute" style="right: 30px; top: 50%; transform: translateY(-50%);">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="text-primary small" style="font-weight: 500;"><i class="fas fa-plus-circle"></i> Recherche avancée</a>
                            </div>
                            <div class="mb-4">
                                <button type="submit" formaction="{{ route('agency') }}" class="btn w-100" style="background: #2563eb; color: white; font-weight: 500; height: 48px; border-radius: 10px; font-size: 1.1rem;">
                                    <i class="fas fa-search me-2"></i> Rechercher des trajets
                                </button>
                            </div>
                            <hr>
                            <div class="mt-4">
                                <h6 class="mb-3" style="font-weight: 600; color: #222;">Trajets populaires</h6>
                                <div class="row g-3">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card" style="border-radius: 12px;">
                                            <div class="card-body text-center">
                                                <h6 style="font-weight: 600;">Yaoundé → Douala</h6>
                                                <small class="text-muted">Route populaire</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card" style="border-radius: 12px;">
                                            <div class="card-body text-center">
                                                <h6 style="font-weight: 600;">Douala → Bafoussam</h6>
                                                <small class="text-muted">Route populaire</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card" style="border-radius: 12px;">
                                            <div class="card-body text-center">
                                                <h6 style="font-weight: 600;">Bertoua → Yaoundé</h6>
                                                <small class="text-muted">Route populaire</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card" style="border-radius: 12px;">
                                            <div class="card-body text-center">
                                                <h6 style="font-weight: 600;">Garoua → Maroua</h6>
                                                <small class="text-muted">Route populaire</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="container"style="margin-top: 100px;">
        <h1>Choisissez votre ville</h1>
        <p>Découvrez les agences et destinations du Cameroun</p>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">

                    <!-- Top section (map / image placeholder) -->
                    <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                        <!-- Overlay for better text visibility -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                        <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                            Garoua<br>
                            <small class="text-white-50">Nord</small>
                        </h6>
                    </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>30</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>12</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <!-- Top section (map / image placeholder) -->
                    <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                        <!-- Overlay for better text visibility -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                        <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                            Beau<br>
                            <small class="text-white-50">South-West</small>
                        </h6>
                    </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>30</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>45</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                        <!-- Top section (map / image placeholder) -->
                        <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                            <!-- Overlay for better text visibility -->
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                            <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                                Ngaoundere<br>
                                <small class="text-white-50">Adamawa</small>
                            </h6>
                        </div>
    
                        <!-- Bottom section -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-hotel"></i>
                                    <span><strong>10</strong> agences</span>
                                </div>
    
                                <div>
                                <i class="fas fa-route"></i>
                                    <strong>12</strong> targets
                                </div>
                            </div>
                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                                <span>Voir les agences</span>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <!-- Top section (map / image placeholder) -->
                <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                    <!-- Overlay for better text visibility -->
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                    <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                        Maroua<br>
                        <small class="text-white-50">Estreme-Nord</small>
                    </h6>
                </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>35</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>52</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">

                    <!-- Top section (map / image placeholder) -->
                    <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                        <!-- Overlay for better text visibility -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                        <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                            Bamenda<br>
                            <small class="text-white-50">Nord-West</small>
                        </h6>
                    </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>20</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>20</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <!-- Top section (map / image placeholder) -->
                    <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                        <!-- Overlay for better text visibility -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                        <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                            Bafoussam<br>
                            <small class="text-white-50">West</small>
                        </h6>
                    </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>10</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>15</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                        <!-- Top section (map / image placeholder) -->
                        <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                            <!-- Overlay for better text visibility -->
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                            <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                                Douala<br>
                                <small class="text-white-50">Littoral</small>
                            </h6>
                        </div>
    
                        <!-- Bottom section -->
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-hotel"></i>
                                    <span><strong>38</strong> agences</span>
                                </div>
    
                                <div>
                                <i class="fas fa-route"></i>
                                    <strong>50</strong> targets
                                </div>
                            </div>
                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                                <span>Voir les agences</span>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow-sm rounded-4 overflow-hidden">
                    <!-- Top section (map / image placeholder) -->
                <div class="position-relative d-flex align-items-end p-3" style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                    <!-- Overlay for better text visibility -->
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                    <h6 class="fw-bold mb-0 position-relative text-white" style="z-index: 1;">
                        Bertoua<br>
                        <small class="text-white-50">East</small>
                    </h6>
                </div>

                    <!-- Bottom section -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-hotel"></i>
                                <span><strong>15</strong> agences</span>
                            </div>

                            <div>
                            <i class="fas fa-route"></i>
                                <strong>30</strong> targets
                            </div>
                        </div>
                        <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none fw-semibold">
                            <span>Voir les agences</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


@endsection