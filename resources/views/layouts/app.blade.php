<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routier+237 - Your Road Travel Platform in Cameroon</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Miniver&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,600&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<style>

    /* ===== MEGA DROPDOWN ===== */

    .mega-dropdown {
        position: static;
    }

    .mega-dropdown:hover .mega-menu {
        display: block;
    }

    /* Menu box */
    .mega-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 250px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: none;
        z-index: 1000;
    }

    /* Title */
    .mega-title {
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
    }

    /* Items */
    .mega-item {
        display: block;
        padding: 8px 2px;
        font-size: 14px;
        color: #212529;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.2s ease;
    }

    .mega-item:hover {
        background-color: #f1f4f8;
        color: #0d6efd;
    }

    .button {
        padding: 16px 32px;
        border-radius: 15px;
        border: none;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        min-width: 180px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        /* .button:active {
            transform: translateY(0);
        } */

        .button-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .button-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Dropdown hover effect */
        .nav-item.dropdown .dropdown-menu {
            display: none !important;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            margin-top: 0;
        }

        .nav-item.dropdown:hover .dropdown-menu,
        .nav-item.dropdown .dropdown-menu:hover {
            display: block !important;
            opacity: 1;
            visibility: visible;
        }

        /* Align navbar icons with text */
        .navbar .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Fix navbar button alignment */
        .navbar .d-flex.align-items-center {
            gap: 10px;
            flex-wrap: nowrap;
        }

        @media (max-width: 720px;) {
            .navbar-expand .navbar-brand .navbar-nav .nav-link .nav-item{
                justify-content: left;
                margin-left: 0;
                text-align: left;
                align-items: left;
            }
        }

        
</style>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <!-- <img src="" alt="logo"> -->
        <div class="container poppins-regular">
            <a class="navbar-brand" href="{{ route('/') }}">
                <span class="brand-text poppins-semibold">Routier+237</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('/') }}">
                            <i class="fas fa-home"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('marketplace') }}">
                            <i class="fas fa-store"></i>
                            Marketplace
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agency') }}">
                            <i class="fas fa-bus"></i>
                            Agencies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('destinations') }}">
                            <i class="fas fa-map-marker-alt"></i>
                            Destinations
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                            <i class="fas fa-map"></i>
                            Cities
                        </a>
                        <div class="dropdown-menu mega-menu p-4">
                            <h6 class="mega-title mb-3">Major Cities</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('destinations') }}" class="mega-item">Douala</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Yaoundé</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Bafoussam</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Garoua</a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('destinations') }}" class="mega-item">Bamenda</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Maroua</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Ngaoundéré</a>
                                    <a href="{{ route('destinations') }}" class="mega-item">Buea</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <a href="{{ route('sign_in') }}" class="btn btn-outline-primary">Login</a>
                    <a href="{{ route('sign_up') }}" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background:#0b2a55;" class="text-light pt-5 pb-3">
        <div class="container">
            <div class="row gy-4">

                <!-- Logo + description -->
                <div class="col-md-3">
                    <h4 class="fw-bold text-white">Routier+237</h4>
                    <p class="small">
                        Cameroon's road transport platform. 
                        Travel safely with verified agencies.
                    </p>

                    <!-- Social icons -->
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                            <i class="fas fa-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                            <i class="fas fa-whatsapp"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                            <i class="fas fa-telegram"></i>
                        </a>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-md-3">
                    <h6 class="fw-bold text-uppercase mb-3">Services</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none">Bus schedules</a></li>
                        <li class="mb-2"><a href="{{ route('agency') }}" class="text-light text-decoration-none">Partner agencies</a></li>
                        <li class="mb-2"><a href="{{ route('destinations') }}" class="text-light text-decoration-none">Destinations</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Bookings</a></li>
                    </ul>
                </div>

                <!-- Popular cities -->
                <div class="col-md-3">
                    <h6 class="fw-bold text-uppercase mb-3">Popular cities</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">Douala</li>
                        <li class="mb-2">Yaoundé</li>
                        <li class="mb-2">Bafoussam</li>
                        <li>Bamenda</li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h6 class="fw-bold text-uppercase mb-3">Contact</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i> +237 699 999 999
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i> +237 675 555 555
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i> contact@routier.cm
                        </li>
                        <li>
                            <i class="bi bi-whatsapp me-2"></i> WhatsApp Support
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom bar -->
            <hr class="border-secondary my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between small">
                <span style="color: white;"> &copy;2026 Routier+237 - All rights reserved.</span>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light text-decoration-none">Privacy</a>
                    <a href="#" class="text-light text-decoration-none">Terms of Use</a>
                    <a href="#" class="text-light text-decoration-none">Support</a>
                </div>
            </div>
        </div>
    </footer>


    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>