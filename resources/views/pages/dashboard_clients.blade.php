<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourTrip - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Miniver&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4a5c6a;
            --secondary-color: #6c757d;
            --accent-color: #007bff;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: #3498db;
            /* border-bottom: 3px solid #d4691a; */
        }

        .sidebar {
            background-color: white;
            min-height: calc(100vh - 76px);
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: var(--primary-color);
            padding: 15px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #e3f2fd;
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
        }

        .main-content {
            padding: 20px;
        }

        .welcome-section {
            background: #3498db;
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #d4691a, #ff8c42);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            color: #fff;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }

        .icon-trips { background-color: #e3f2fd; color: #1976d2; }
        .icon-countries { background-color: #e8f5e8; color: #388e3c; }
        .icon-upcoming { background-color: #fff3e0; color: #f57c00; }
        .icon-points { background-color: #f3e5f5; color: #7b1fa2; }

        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .content-card .card-header {
            background: #3498db;
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px 25px;
        }

        .content-card .card-body {
            padding: 25px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
        }

        .activity-booking { background-color: #e3f2fd; color: #1976d2; }
        .activity-payment { background-color: #e8f5e8; color: #388e3c; }
        .activity-review { background-color: #fff3e0; color: #f57c00; }

        .quick-action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
        }

        .quick-action {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 20px 10px;
            text-align: center;
            text-decoration: none;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .quick-action:hover {
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            color: var(--accent-color);
            text-decoration: none;
        }

        .quick-action i {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .trip-row {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .trip-row:last-child {
            border-bottom: none;
        }

        .trip-destination {
            flex: 1;
            font-weight: 600;
            color: var(--primary-color);
        }

        .trip-date {
            flex: 1;
            color: var(--secondary-color);
            font-size: 14px;
        }

        .trip-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-completed {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .status-upcoming {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin-right: 15px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                padding: 15px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
    
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-3" href="#" style="font-style: Poppins;">
                Routier+237
            </a>
            
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-lg-2 col-md-3 sidebar p-0">
                <!-- User Profile Section -->
                <div class="user-profile">
                    <div class="user-avatar">🏚</div>
                    <div>
                        <small class="text-muted">Premium Member</small>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                    <a class="nav-link" href="#trips">
                        <i class="fas fa-suitcase-rolling me-2"></i>
                        My Trips
                    </a>
                    <a class="nav-link" href="#bookings">
                        <i class="fas fa-calendar-check me-2"></i>
                        Bookings
                    </a>
                    <a class="nav-link" href="#favorites">
                        <i class="fas fa-heart me-2"></i>
                        Favorites
                    </a>
                    <a class="nav-link" href="#rewards">
                        <i class="fas fa-star me-2"></i>
                        Rewards
                    </a>
                    <a class="nav-link" href="#support">
                        <i class="fas fa-headset me-2"></i>
                        Support
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 main-content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="container mt-5">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                        <div class="card p-4 shadow-sm">
                            <h2 class="mb-4">Welcome, {{ Auth::user()->name }} 👋</h2>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Joined:</strong> {{ Auth::user()->created_at->format('M d, Y \a\t H:i') }}</p>

                            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                                </button>
                            </form>
                        </div>
                </div>

                <div class="col-md-4 text-end d-none d-md-block">
                </div>
                </div>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon icon-trips">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h3 class="fw-bold text-primary">{{ $totalTrips }}</h3>
                        <p class="text-muted mb-0">Total Trips</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-countries">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="fw-bold text-success">{{ $citiesVisited }}</h3>
                        <p class="text-muted mb-0">Towns Visited</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-upcoming">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="fw-bold text-warning">{{ $upcomingTrips }}</h3>
                        <p class="text-muted mb-0">Upcoming Trips</p>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="row">

                    <!-- Recent Activities -->
                    <div class="card-body">
                        @forelse($recentBookings as $booking)
                        <div class="activity-item">
                            <div class="activity-icon activity-booking">
                                <i class="fas fa-plane"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $booking->route->departure_city }} → {{ $booking->route->arrival_city }}</div>
                                <div class="text-muted small">{{ $booking->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="status-{{ strtolower($booking->status) }} trip-status">{{ ucfirst($booking->status) }}</span>
                        </div>
                        @empty
                        <p class="text-center text-muted">No recent bookings</p>
                        @endforelse
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-lg-6 mb-4">
                        <div class="content-card">
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-bolt me-2 text-primary"></i>
                                    Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="quick-action-grid">
                                    <div class="quick-action">
                                        <i class="fas fa-search-location text-primary"></i>
                                        <div class="fw-semibold mt-2">Search Trips</div>
                                        <a href="{{ route(name:'destinations') }}"></a>
                                        <div class="text-muted small">Find destinations</div>
                                    </div>
                                    <div class="quick-action">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <div class="fw-semibold mt-2">Plan Trip</div>
                                        <div class="text-muted small">Create itinerary</div>
                                    </div>
                                    <div class="quick-action">
                                        <i class="fas fa-ticket-alt text-warning"></i>
                                        <div class="fw-semibold mt-2">My Bookings</div>
                                        <div class="text-muted small">View reservations</div>
                                    </div>
                                    <div class="quick-action">
                                        <i class="fas fa-headset text-info"></i>
                                        <div class="fw-semibold mt-2">Support</div>
                                        <div class="text-muted small">Get help 24/7</div>
                                    </div>
                                    <div class="quick-action">
                                        <i class="fas fa-heart text-danger"></i>
                                        <div class="fw-semibold mt-2">Favorites</div>
                                        <div class="text-muted small">Saved places</div>
                                    </div>
                                    <a href="{{ route(name:'view') }}" class="">
                                        <i class="fas fa-gift text-purple"></i>
                                        <div class="fw-semibold mt-2">Rewards</div>
                                        <div class="text-muted small">Redeem points</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trip History -->
                <div class="card-body">
                    @forelse($tripHistory as $trip)
                    <div class="trip-row">
                        <div class="trip-destination">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            {{ $trip->route->departure_city }} → {{ $trip->route->arrival_city }}
                        </div>
                        <div class="trip-date">{{ $trip->route->departure_date->format('M d, Y') }}</div>
                        <div class="trip-cost fw-bold me-3">{{ number_format($trip->amount_paid, 0) }} XAF</div>
                        <span class="trip-status status-{{ strtolower($trip->status) }}">{{ ucfirst($trip->status) }}</span>
                    </div>
                    @empty
                    <p class="text-center text-muted">No trip history</p>
                    @endforelse
                </div>


            </main>
        </div>
    </div>
 

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar navigation
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Quick actions
            const quickActions = document.querySelectorAll('.quick-action');
            quickActions.forEach(action => {
                action.addEventListener('click', function(e) {
                    e.preventDefault();
                    const title = this.querySelector('.fw-semibold').textContent;
                    console.log(`Clicked on: ${title}`);
                    // Add your navigation logic here
                });
            });

            // Stats animation on load
            const statNumbers = document.querySelectorAll('.stat-card h3');
            statNumbers.forEach((stat, index) => {
                const finalNumber = parseInt(stat.textContent);
                let currentNumber = 0;
                const increment = finalNumber / 30;
                
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= finalNumber) {
                        stat.textContent = finalNumber;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentNumber);
                    }
                }, 50);
            });
        });
    </script>
</body>
</html>