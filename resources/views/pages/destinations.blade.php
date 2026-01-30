@extends('layouts.app')

@section('title', 'Find Your Perfect Journey')

@section('content')

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 1rem 0;
        }
        
        .nav {
            width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }  
        
        /* Hero Section */
        .hero-section {
            min-height: 70vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('{{ asset("assets/images/destination-image.png") }}') center/cover no-repeat;
        
        }

       
        
        /* Main Content */
        .main-content {
            background: #f8fafc;
            margin-top: -20px;
            position: relative;
            padding: 4rem 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 3rem;
        }
        
        .filters {
            display: flex;
            gap: .7rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .filter-btn {
            padding: 5px 15px;
            background: #f4faff;
            color: #667eea;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .filter-btn.active,
        .filter-btn:hover {
            background: #2563eb;
            color: white;
        }

        .city-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 22px rgba(0,0,0,0.12);
            transition: all 0.4s ease;
        }

        .city-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0,0,0,0.25);
        }

        /* IMAGE */
        .city-image-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .city-image-wrapper img,
        .city-image-wrapper > div {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        /* VOILE */
        .city-image-wrapper .overlay-veil {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.7) 0%,
                rgba(0,0,0,0.3) 50%,
                transparent 100%
            );
            transform: translateY(0);
            transition: transform 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        /* HOVER EFFECT - Only on image section */
        .city-image-wrapper:hover .overlay-veil {
            transform: translateY(-30px);
        }

        .city-image-wrapper:hover > div {
            transform: scale(0.99);
        }

        .city-image-wrapper .image-bg {
            transition: transform 0.4s ease;
        }

        /* Region badge */
        .region-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #2563eb;
            color: white;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
            z-index: 10;
        }

        /* Text inside image - left aligned */
        .city-image-text {
            position: absolute;
            bottom: 12px;
            left: 12px;
            text-align: left;
            z-index: 2;
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            opacity: 1;
        }
        
        .modal-content {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            text-align: center;
            max-width: 400px;
            transform: scale(0.8);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modal.show .modal-content {
            transform: scale(1);
        }
        
        .modal h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }
        
        .modal p {
            color: #64748b;
            margin-bottom: 2rem;
        }
        
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .search-bar {
                flex-direction: column;
                padding: 1.5rem;
            }
            
            .trips-grid {
                grid-template-columns: 1fr;
            }
            
            .nav {
                padding: 0 1rem;
            }
            
            .filters {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }
            
            .modal-content {
                margin: 1rem;
                padding: 2rem;
            }
            
            .modal-buttons {
                flex-direction: column;
            }
        }
</style>   


    {{-- Hero Section --}}
    <section class="hero-section d-flex align-items-center text-center text-white" style="height: 100%;">
        <div class="container position-relative">
            <h1 class="fw-bold display-5 mb-3">
                Explorez le Cameroun
            </h1>

            <p class="lead mb-4">
                Découvrez toutes les destinations desservies par nos agences partenaires.
                Du nord au sud, d’est en ouest, voyagez partout au Cameroun.
            </p>

            <!-- Stats -->
            <div class="d-flex justify-content-center gap-4 flex-wrap small">
                <span style="color: white;">
                    <i class="fas fa-bus me-1"></i>
                    10 régions
                </span>
                <span style="color: white;">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    150+ destinations
                </span>
                <span style="color: white;">
                    <i class="fas fa-building me-1"></i>
                    50+ agences
                </span>
            </div>
        </div>
    </section>


    {{-- Main Content --}}
    <main class="main-content">
        <div class="container">
            <h2 class="section-title">Our Destionations</h2>
            
            <!-- Filters -->
            <div class="filters">
                <button class="filter-btn active" onclick="filterTrips('all')">All regions</button>
                <button class="filter-btn" onclick="filterTrips('budget')">Center</button>
                <button class="filter-btn" onclick="filterTrips('luxury')">Littoral</button>
                <button class="filter-btn" onclick="filterTrips('express')">East</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">West</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">Nord</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">Estreme-Nord</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">Nord-West</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">South-West</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">South</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">Adamawa</button>
            </div>
            
            <!-- Trips Grid -->
             <div class="row g-3 py-1">
                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                            <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                                <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                                <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                                <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                                <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="city-card">

                        <!-- IMAGE -->
                        <div class="city-image-wrapper">
                                <div class="position-relative image-bg" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="overlay-veil"></div>
                                
                                <!-- Region badge -->
                                <span class="region-badge">Littoral</span>
                                
                                <!-- Text inside image - left aligned -->
                                <div class="city-image-text text-white">
                                    <h5 class="fw-bold mb-1">Douala</h5>
                                    <p class="mb-0 text-white-50 small">Economic Capital of Cameroon</p>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-3">

                            <div class="d-flex justify-content-between text-center">
                                <div>
                                    <strong>4M+</strong><br>
                                    <small class="text-muted">Population</small>
                                </div>

                                <div>
                                    <strong>25</strong><br>
                                    <small class="text-muted">Agences</small>
                                </div>

                                <div>
                                    <strong>52</strong><br>
                                    <small class="text-muted">Trajets</small>
                                </div>
                            </div>

                            <a href="#" class="mt-3 text-decoration-none fw-semibold d-inline-block">
                                Voir les trajets
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            


        </div>
    </main>

    <!-- Signup Modal -->
    <div class="modal" id="signupModal">
        <div class="modal-content">
            <h3>Join RoadTrip</h3>
            <p>Create an account to book amazing trips and get exclusive deals!</p>
            <div class="modal-buttons">
                <button class="btn btn-primary" onclick="redirectToSignup()">Sign Up Now</button>
                <button class="btn btn-outline" onclick="closeModal('signupModal')">Maybe Later</button>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <h3>Welcome Back</h3>
            <p>Login to access your bookings and continue your journey!</p>
            <div class="modal-buttons">
                <button class="btn btn-primary" onclick="redirectToLogin()">Login</button>
                <button class="btn btn-outline" onclick="closeModal('loginModal')">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal" id="bookingModal">
        <div class="modal-content">
            <h3>Ready to Book?</h3>
            <p id="bookingDetails">You need to sign up first to book this amazing trip!</p>
            <div class="modal-buttons">
                <button class="btn btn-primary" onclick="redirectToSignupForBooking()">Sign Up & Book</button>
                <button class="btn btn-outline" onclick="closeModal('bookingModal')">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // User state (simulating authentication)
        let isLoggedIn = false;
        let currentBooking = null;

        // Filter functionality
        function filterTrips(category) {
            const cards = document.querySelectorAll('.trip-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter cards
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        }

        // Search functionality
        function searchTrips() {
            const searchInput = document.querySelector('.search-input');
            const query = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.trip-card');
            
            if (!query) return;
            
            cards.forEach(card => {
                const destination = card.querySelector('.destination').textContent.toLowerCase();
                const route = card.querySelector('.trip-route').textContent.toLowerCase();
                
                if (destination.includes(query) || route.includes(query)) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
            
            // Reset active filter
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        }

        // Modal functions
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('show');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
        }

        function showSignupModal() {
            showModal('signupModal');
        }

        function showLoginModal() {
            showModal('loginModal');
        }

        // Booking functionality
        function bookTrip(route, price) {
            if (!isLoggedIn) {
                currentBooking = { route, price };
                document.getElementById('bookingDetails').textContent = 
                    `You want to book "${route}" for $${price}. Sign up first to complete your booking!`;
                showModal('bookingModal');
            } else {
                // If logged in, proceed with booking
                alert(`Booking confirmed for ${route} - $${price}!`);
            }
        }

        // Redirect functions
        function redirectToSignup() {
            
            window.location.href = '/sign_up';
            closeModal('signupModal');
        }

        function redirectToLogin() {
            window.location.href = '/sign_in';
            closeModal('loginModal');
        }

        function redirectToSignupForBooking() {
            // alert(`Redirecting to signup page with booking: ${currentBooking.route} - $${currentBooking.price}`);
            window.location.href = '/sign_up';
            closeModal('bookingModal');
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Smooth scrolling for search
        function scrollToTrips() {
            document.querySelector('.main-content').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Add loading animation to book buttons
        document.querySelectorAll('.book-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.textContent;
                this.textContent = 'Loading...';
                this.style.opacity = '0.7';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.opacity = '1';
                }, 1000);
            });
        });

        // Add hover effects to trip cards
        document.querySelectorAll('.trip-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Simulate real-time updates
        function updateAvailableSeats() {
            const seatElements = document.querySelectorAll('.detail-item span');
            seatElements.forEach(element => {
                if (element.textContent.includes('seats')) {
                    const currentSeats = parseInt(element.textContent.match(/\d+/)[0]);
                    if (Math.random() < 0.1) { // 10% chance to update
                        const newSeats = Math.max(0, currentSeats - Math.floor(Math.random() * 3));
                        element.textContent = `${newSeats} seats`;
                        
                        // Add visual feedback
                        element.style.color = newSeats < 5 ? '#ef4444' : '#64748b';
                        if (newSeats < 5) {
                            element.parentElement.style.animation = 'pulse 0.5s ease-in-out';
                        }
                    }
                }
            });
        }

        // Update seats every 30 seconds
        setInterval(updateAvailableSeats, 30000);

        // Add pulse animation for low seat availability
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
        document.head.appendChild(style);

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add entrance animations
            setTimeout(() => {
                document.querySelectorAll('.trip-card').forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }, 500);
            
            // Simulate user login for demo (uncomment to test logged-in state)
            // isLoggedIn = true;
        });

        // Add search suggestions
        const searchInput = document.querySelector('.search-input');
        const suggestions = ['New York', 'Los Angeles', 'Chicago', 'Miami', 'Seattle', 'Las Vegas', 'Boston', 'San Francisco'];
        
        searchInput.addEventListener('input', function() {
            const value = this.value.toLowerCase();
            if (value.length > 0) {
                const matches = suggestions.filter(s => s.toLowerCase().includes(value));
                // In a real app, you'd show these suggestions in a dropdown
                console.log('Suggestions:', matches);
            }
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open modals
                document.querySelectorAll('.modal.show').forEach(modal => {
                    closeModal(modal.id);
                });
            }
            
            if (e.key === 'Enter' && document.activeElement === searchInput) {
                searchTrips();
            }
        });

        // Add touch gestures for mobile
        let touchStartY = 0;
        document.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        });

        document.addEventListener('touchend', function(e) {
            const touchEndY = e.changedTouches[0].clientY;
            const diff = touchStartY - touchEndY;
            
            // Swipe up to refresh (simple implementation)
            if (diff > 50 && window.scrollY === 0) {
                location.reload();
            }
        });

        // Add performance monitoring
        window.addEventListener('load', function() {
            console.log('Page loaded in:', performance.now(), 'ms');
        });
    </script>

@endsection
