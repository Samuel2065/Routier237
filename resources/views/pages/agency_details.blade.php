@extends('layouts.app')

@section('title', 'Agency Details')

@section('content')

<div class="container my-5" style="margin-top: 200px;">

    <!-- AGENCY HEADER -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold">
                Overline Voyage
                <span class="badge bg-primary ms-2">Verified Agency</span>
            </h2>

            <p class="text-muted mt-2">
                Overline Voyage is a leading transport agency in Cameroon,
                providing reliable intercity transport services since 2015.
                We serve major cities across the country with modern buses
                and professional staff.
            </p>

            <div class="d-flex gap-2 mt-3">
                <a href="#" class="btn btn-primary btn-sm">
                    📞 Call Now
                </a>
                <a href="#" class="btn btn-success btn-sm">
                    💬 WhatsApp
                </a>
                <a href="#" class="btn btn-secondary btn-sm">
                    ✉ Email
                </a>
            </div>
        </div>

        <div class="col-md-4 text-end">
            <h4 class="fw-bold text-warning">⭐ 4.8</h4>
            <small class="text-muted">512 reviews</small>
        </div>
    </div>

    <!-- NAV TABS -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="#">Schedules & Fares</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Our Branches</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Customer Reviews</a>
        </li>
    </ul>

    <!-- TRIPS LIST -->

    <!-- TRIP 1 -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-3">
                    <strong>Douala → Bafoussam</strong>
                    <p class="text-muted mb-1">Departure Times</p>
                    <span class="badge bg-light text-dark">08:00</span>
                    <span class="badge bg-light text-dark">14:30</span>
                    <span class="badge bg-light text-dark">18:00</span>
                </div>

                <div class="col-md-3">
                    <p class="mb-1 text-muted">Service Class</p>
                    <strong>Classic Bus</strong>
                </div>

                <div class="col-md-2">
                    <strong>4,200 XAF</strong>
                </div>

                <div class="col-md-4 text-end">
                    <a href="#" class="btn btn-success btn-sm mb-1">Book via WhatsApp</a>
                    <a href="#" class="btn btn-primary btn-sm mb-1">Book Classic</a>
                    <a href="#" class="btn btn-dark btn-sm mb-1">Set Price Alert</a>
                </div>

            </div>
        </div>
    </div>

    <!-- TRIP 2 -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-3">
                    <strong>Yaoundé → Garoua</strong>
                    <p class="text-muted mb-1">Departure Times</p>
                    <span class="badge bg-light text-dark">20:00</span>
                </div>

                <div class="col-md-3">
                    <p class="mb-1 text-muted">Service Class</p>
                    <strong>VIP Bus</strong>
                </div>

                <div class="col-md-2">
                    <strong>8,500 XAF</strong>
                </div>

                <div class="col-md-4 text-end">
                    <a href="#" class="btn btn-success btn-sm mb-1">Book via WhatsApp</a>
                    <a href="#" class="btn btn-primary btn-sm mb-1">Book VIP</a>
                    <a href="#" class="btn btn-dark btn-sm mb-1">Set Price Alert</a>
                </div>

            </div>
        </div>
    </div>

    <!-- TRIP 3 -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-3">
                    <strong>Bertoua → Yaoundé</strong>
                    <p class="text-muted mb-1">Departure Times</p>
                    <span class="badge bg-light text-dark">06:00</span>
                    <span class="badge bg-light text-dark">12:30</span>
                    <span class="badge bg-light text-dark">18:30</span>
                </div>

                <div class="col-md-3">
                    <p class="mb-1 text-muted">Service Class</p>
                    <strong>Classic Bus</strong>
                </div>

                <div class="col-md-2">
                    <strong>3,500 XAF</strong>
                </div>

                <div class="col-md-4 text-end">
                    <a href="#" class="btn btn-success btn-sm mb-1">Book via WhatsApp</a>
                    <a href="#" class="btn btn-primary btn-sm mb-1">Book Classic</a>
                    <a href="#" class="btn btn-warning btn-sm mb-1">Book VIP</a>
                    <a href="#" class="btn btn-dark btn-sm mb-1">Set Price Alert</a>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
