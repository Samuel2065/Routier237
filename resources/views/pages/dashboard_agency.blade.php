<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard - Routier+237</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Miniver&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a5c6a;
            --secondary-color: #6c757d;
            --accent-color: #7c3aed;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: #7c3aed;
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
            background-color: #f3e8ff;
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
        }

        .main-content {
            padding: 20px;
        }

        .welcome-section {
            background: #7c3aed;
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
            background: linear-gradient(90deg, #a855f7, #ec4899);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
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

        .icon-routes { background-color: #f3e8ff; color: #7c3aed; }
        .icon-bookings { background-color: #dbeafe; color: #2563eb; }
        .icon-revenue { background-color: #dcfce7; color: #16a34a; }
        .icon-passengers { background-color: #fee2e2; color: #dc2626; }

        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .content-card .card-header {
            background: #7c3aed;
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px 25px;
        }

        .content-card .card-body {
            padding: 25px;
        }

        .booking-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .booking-item:last-child {
            border-bottom: none;
        }

        .booking-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
        }

        .booking-confirmed { background-color: #dcfce7; color: #16a34a; }
        .booking-pending { background-color: #fef3c7; color: #d97706; }
        .booking-cancelled { background-color: #fee2e2; color: #dc2626; }

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

        .route-row {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .route-row:last-child {
            border-bottom: none;
        }

        .route-name {
            flex: 1;
            font-weight: 600;
            color: var(--primary-color);
        }

        .route-info {
            flex: 1;
            color: var(--secondary-color);
            font-size: 14px;
        }

        .route-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .status-full {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-available {
            background-color: #dbeafe;
            color: #2563eb;
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
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin-right: 15px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
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
            <a class="navbar-brand fw-bold fs-3" href="#" style="font-family: poppins-regular;">
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
                    <div class="user-avatar">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->agency_name ?? 'Agency' }}</div>
                        <small class="text-muted">Travel Agency</small>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="nav flex-column">
                    <a class="nav-link active" href="#dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                    <a class="nav-link" href="#routes">
                        <i class="fas fa-route me-2"></i>
                        My Routes
                    </a>
                    <a class="nav-link" href="#bookings">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Bookings
                    </a>
                    <a class="nav-link" href="#vehicles">
                        <i class="fas fa-bus me-2"></i>
                        Vehicles
                    </a>
                    <a class="nav-link" href="#passengers">
                        <i class="fas fa-users me-2"></i>
                        Passengers
                    </a>
                    <a class="nav-link" href="#revenue">
                        <i class="fas fa-chart-line me-2"></i>
                        Revenue
                    </a>
                    <a class="nav-link" href="#settings">
                        <i class="fas fa-cog me-2"></i>
                        Settings
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-10 col-md-9 main-content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <h2 class="mb-2">Welcome back, {{ Auth::user()->agency_name ?? Auth::user()->name }} 👋</h2>
                            <p class="mb-0 opacity-75">Here's what's happening with your agency today</p>
                            
                            <div class="mt-3">
                                <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <p class="mb-1"><strong>Business License:</strong> {{ Auth::user()->business_license ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Member since:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-light">
                                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="fas fa-building" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon icon-routes">
                            <i class="fas fa-route"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #7c3aed;">{{ $activeRoutes }}</h3>
                        <p class="text-muted mb-0">Active Routes</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-bookings">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #2563eb;">{{ $totalBookings }}</h3>
                        <p class="text-muted mb-0">Total Bookings</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-revenue">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #16a34a;">{{ number_format($monthlyRevenue, 0) }} XAF</h3>
                        <p class="text-muted mb-0">Monthly Revenue</p>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon icon-passengers">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #dc2626;">{{ $totalPassengers }}</h3>
                        <p class="text-muted mb-0">Total Passengers</p>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="card-body">
                    @forelse($recentBookings as $booking)
                    <div class="booking-item">
                        <div class="booking-icon booking-{{ strtolower($booking->status) }}">
                            <i class="fas fa-{{ $booking->status === 'confirmed' ? 'check' : 'clock' }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $booking->route->departure_city }} → {{ $booking->route->arrival_city }}</div>
                            <div class="text-muted small">{{ $booking->passenger_name }} • Seat {{ $booking->seat_number ?? 'TBA' }}</div>
                            <div class="text-muted small">{{ $booking->created_at->format('M d, H:i') }}</div>
                        </div>
                        <span class="route-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                    @empty
                    <p class="text-center text-muted">No recent bookings</p>
                    @endforelse
                </div>

                <!-- Active Routes Today -->
                <div class="card-body">
                    @forelse($todayRoutes as $route)
                    <div class="route-row">
                        <div class="route-name">
                            <i class="fas fa-map-marker-alt me-2" style="color: #7c3aed;"></i>
                            {{ $route->departure_city }} → {{ $route->arrival_city }}
                        </div>
                        <div class="route-info">
                            Departure: {{ $route->departure_time->format('H:i') }} • 
                            {{ $route->booked_seats }}/{{ $route->total_seats }} seats
                        </div>
                        <div class="fw-bold me-3" style="color: #16a34a;">{{ number_format($route->price, 0) }} XAF</div>
                        <span class="route-status status-{{ $route->available_seats > 0 ? 'available' : 'full' }}">
                            {{ $route->available_seats > 0 ? 'Available' : 'Full' }}
                        </span>
                    </div>
                    @empty
                    <p class="text-center text-muted">No active routes today</p>
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

            // Stats animation on load
            const statNumbers = document.querySelectorAll('.stat-card h3');
            statNumbers.forEach((stat, index) => {
                const text = stat.textContent.trim();
                const numberMatch = text.match(/[\d.]+[KM]?/);
                
                if (numberMatch) {
                    const finalText = numberMatch[0];
                    const hasK = finalText.includes('K');
                    const hasM = finalText.includes('M');
                    const multiplier = hasK ? 1000 : hasM ? 1000000 : 1;
                    const finalNumber = parseFloat(finalText) * multiplier;
                    
                    let currentNumber = 0;
                    const increment = finalNumber / 30;
                    
                    const timer = setInterval(() => {
                        currentNumber += increment;
                        if (currentNumber >= finalNumber) {
                            stat.textContent = finalText;
                            clearInterval(timer);
                        } else {
                            const display = Math.floor(currentNumber);
                            if (hasK) {
                                stat.textContent = (display / 1000).toFixed(1) + 'K';
                            } else if (hasM) {
                                stat.textContent = (display / 1000000).toFixed(1) + 'M';
                            } else {
                                stat.textContent = display;
                            }
                        }
                    }, 50);
                }
            });
        });
    </script>
</body>
</html>