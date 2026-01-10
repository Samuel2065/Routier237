<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routier+237 - Your Travel Platform in Cameroon</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"><link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Miniver&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,600&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<style>
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

        /* Fix navbar button alignment */
        .navbar .d-flex.align-items-center {
            gap: 10px;
            flex-wrap: nowrap;
        }

        /* .navbar .btn {
            margin-left: 0 !important;
            white-space: nowrap;
            vertical-align: middle;
            line-height: 1.5;
            height: auto;
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        } */

        /* .navbar .btn:focus,
        .navbar .btn:active,
        .navbar .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(0, 102, 255, 0.25);
            transform: none;
        } */

        /* .navbar .btn:active {
            transform: none;
            position: relative;
        } */
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
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('destinations') }}">Yaoundé</a></li>
                            <li><a class="dropdown-item" href="{{ route('destinations') }}">Douala</a></li>
                            <li><a class="dropdown-item" href="{{ route('destinations') }}">Bafoussam</a></li>
                            <li><a class="dropdown-item" href="{{ route('destinations') }}">Bamenda</a></li>
                            <li><a class="dropdown-item" href="{{ route('destinations') }}">Garoua</a></li>
                        </ul>
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
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Routier+237</h3>
                <p>Your trusted platform to book your travels across Cameroon. Discover our partner agencies and travel with complete peace of mind.</p>
            </div>
            
            <div class="footer-section">
                <h3>Useful Links</h3>
                <ul>
                    <li><a href="{{ route('/') }}">Home</a></li>
                    <li><a href="{{ route('agency') }}">Agencies</a></li>
                    <li><a href="#destinations">Contact Us</a></li>
                    <li><a href="#pricing">Destinations</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Our Services</h3>
                <ul>
                    <li><a href="#booking">Travel booking</a></li>
                    <li><a href="#transport">Urban transport</a></li>
                    <li><a href="#inter-urban">Inter-city travel</a></li>
                    <li><a href="#support">24/7 customer service</a></li>
                    <li><a href="#insurance">Travel insurance</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><strong>Address:</strong>  Bertoua<br>Koume, East<br>Cameroon</p>
                <p><strong>Phone:</strong> +237 691 43 27 64</p>
                <p><strong>Email:</strong> contact@yourtrip.cm</p>
                <p><strong>Hours:</strong> 24/7</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© 2025 Routier+237. All rights reserved.</p>
            <p>Developed with ❤️ in Cameroon</p>
        </div>
    </footer>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>