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
        
        
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            border-color: #3498db;
            /* font-weight: 600; */
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
            border-color: blue;
        }
        
        /* Hero Section */
        .hero {
            max-height: 400px;
            padding: 120px 0 80px;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .hero-content {
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.2s forwards;
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.4s forwards;
        }
        
        .search-bar {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 60px;
            padding: 1rem ;
            display: flex;
            gap: 1rem;
            margin: 2rem auto;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.6s forwards;
        }
        
        .search-input {
            flex: 1;
            border: none;
            background: none;
            font-size: 1rem;
            padding: 0.5rem;
            outline: none;
            color: ;
        }
        
        .search-input::placeholder {
            color: ;
        }
        
        .search-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
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
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .filter-btn {
            padding: 5px 25px;
            background: white;
            color: #667eea;
            border: 2px solid #2563eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .filter-btn.active,
        .filter-btn:hover {
            background: #2563eb;
            color: white;
            border-color: transparent;
        }
        
        /* Trip Cards */
        .trips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .trip-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .trip-card:nth-child(2) { animation-delay: 0.1s; }
        .trip-card:nth-child(3) { animation-delay: 0.2s; }
        .trip-card:nth-child(4) { animation-delay: 0.3s; }
        .trip-card:nth-child(5) { animation-delay: 0.4s; }
        .trip-card:nth-child(6) { animation-delay: 0.5s; }
        
        .trip-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }
        
        .trip-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            position: relative;
            overflow: hidden;
        }
        
        .trip-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(102, 126, 234, 0.8), 
                rgba(118, 75, 162, 0.8));
        }
        
        .trip-image .destination {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
        }
        
        .agency-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #667eea;
        }
        
        .trip-info {
            padding: 1.5rem;
        }
        
        .trip-route {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: #000;
        }
        
        .route-arrow {
            color: #667eea;
            font-size: 1.2rem;
        }
        
        .trip-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #000;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #000;
        }
        
        .price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
        }
        
        .book-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
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
    <!-- Hero Section -->
    <section class="hero" style="max-height: 500px;">
        <div class="hero-content" style="justify-content: center; text-align: center;">
            <h1>Discover Amazing Road Trips</h1>
            <p style="margin-left: 50px;">Find affordable journeys from trusted road agencies across the country</p>
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Enter your destination">
                <button class="search-btn" onclick="searchTrips()">Search Trips</button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h2 class="section-title">Available Trips</h2>
            
            <!-- Filters -->
            <div class="filters">
                <button class="filter-btn active" onclick="filterTrips('all')">All Trips</button>
                <button class="filter-btn" onclick="filterTrips('budget')">Budget Friendly</button>
                <button class="filter-btn" onclick="filterTrips('luxury')">Luxury</button>
                <button class="filter-btn" onclick="filterTrips('express')">Express</button>
                <button class="filter-btn" onclick="filterTrips('overnight')">Overnight</button>
            </div>

            <!-- Trips Grid -->
            <div class="trips-grid" id="tripsGrid">
                <!-- Trip Card 1 -->
                <div class="trip-card" data-category="budget">
                    <div class="trip-image">
                        <div class="destination">Yaounde</div>
                        <div class="agency-badge">SafeTravel Co</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                            Bertoua
                            <span class="route-arrow">→</span>
                        Yaounde
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">4h 30m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">32 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">Daily</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.8/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">5.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Yaounde', 45)">Book Now</button>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 2 -->
                <div class="trip-card" data-category="luxury">
                    <div class="trip-image">
                        <div class="destination">Douala</div>
                        <div class="agency-badge">LuxuryLine</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                            Bertoua
                            <span class="route-arrow">→</span>
                            Douala
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">6h 15m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">24 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">3x Daily</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.9/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">7.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Douala', 89)">Book Now</button>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 3 -->
                <div class="trip-card" data-category="express">
                    <div class="trip-image">
                        <div class="destination">Garoua</div>
                        <div class="agency-badge">RapidRide</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                        Bertoua
                            <span class="route-arrow">→</span>
                        Garoua
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">3h 45m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">28 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">Hourly</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.7/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">20.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Garoua', 38)">Book Now</button>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 4 -->
                <div class="trip-card" data-category="overnight">
                    <div class="trip-image">
                        <div class="destination">Bafoussam</div>
                        <div class="agency-badge">NightExpress</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                        Bertoua
                            <span class="route-arrow">→</span>
                        Bafoussam
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">8h 20m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">20 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">Nightly</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.6/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">10.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Bafoussam', 72)">Book Now</button>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 5 -->
                <div class="trip-card" data-category="budget">
                    <div class="trip-image">
                        <div class="destination">Kribi</div>
                        <div class="agency-badge">BudgetBus</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                        Bertoua
                            <span class="route-arrow">→</span>
                        Kribi
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">3h 15m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">40 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">Every 2h</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.5/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">15.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Kribi', 28)">Book Now</button>
                        </div>
                    </div>
                </div>

                <!-- Trip Card 6 -->
                <div class="trip-card" data-category="luxury">
                    <div class="trip-image">
                        <div class="destination">Bamenda</div>
                        <div class="agency-badge">PremiumTravel</div>
                    </div>
                    <div class="trip-info">
                        <div class="trip-route">
                        Bertoua
                            <span class="route-arrow">→</span>
                        Bamenda
                        </div>
                        <div class="trip-details">
                            <div class="detail-item">
                                <span style="color: black;">🕐</span>
                                <span style="color: black;">5h 30m</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">🎫</span>
                                <span style="color: black;">16 seats</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">📅</span>
                                <span style="color: black;">2x Daily</span>
                            </div>
                            <div class="detail-item">
                                <span style="color: black;">⭐</span>
                                <span style="color: black;">4.9/5</span>
                            </div>
                        </div>
                        <div class="price-section">
                            <div class="price">25.000 XAF</div>
                            <button class="book-btn" onclick="bookTrip('Bertoua to Bamenda', 95)">Book Now</button>
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
            alert('Redirecting to signup page...');
            // In a real app: window.location.href = '/signup';
            closeModal('signupModal');
        }

        function redirectToLogin() {
            alert('Redirecting to login page...');
            // In a real app: window.location.href = '/login';
            closeModal('loginModal');
        }

        function redirectToSignupForBooking() {
            alert(`Redirecting to signup page with booking: ${currentBooking.route} - $${currentBooking.price}`);
            // In a real app: window.location.href = `/signup?booking=${encodeURIComponent(JSON.stringify(currentBooking))}`;
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
