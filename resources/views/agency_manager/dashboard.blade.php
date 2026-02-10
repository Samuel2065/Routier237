<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Manager Dashboard - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #059669;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid var(--primary-color);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: #1f2937;
        }

        .content-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
        }

        .badge-boarding {
            background: #f59e0b;
        }

        .badge-departed {
            background: #0ea5e9;
        }

        .badge-scheduled {
            background: #6b7280;
        }

        .badge-completed {
            background: #10b981;
        }

        .badge-cancelled {
            background: #ef4444;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shop"></i> Routier+237</h4>
            <small class="text-white-50">Agency Manager</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('agency_manager.dashboard') }}" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.reservations') }}" class="nav-link">
                    <i class="bi bi-ticket-perforated"></i>
                    <span>Reservations</span>
                    @if($stats['pending_reservations'] > 0)
                        <span class="badge bg-warning ms-auto">{{ $stats['pending_reservations'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.staff') }}" class="nav-link">
                    <i class="bi bi-people"></i>
                    <span>My Staff</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.vehicles') }}" class="nav-link">
                    <i class="bi bi-truck"></i>
                    <span>Vehicles</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.drivers') }}" class="nav-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Drivers</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.trips') }}" class="nav-link">
                    <i class="bi bi-calendar3"></i>
                    <span>Trips & Schedules</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.cash_register') }}" class="nav-link">
                    <i class="bi bi-cash-coin"></i>
                    <span>Cash Register</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.expenses') }}" class="nav-link">
                    <i class="bi bi-receipt"></i>
                    <span>Expenses</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('agency_manager.reports') }}" class="nav-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Reports</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Agency Dashboard</h2>
                    <small class="text-muted">{{ $agency->name }}</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->full_name }}
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Today's Sales</p>
                        <h3>{{ number_format($stats['daily_revenue']) }} XAF</h3>
                        @if(!is_null($stats['daily_revenue_change']))
                            @if($stats['daily_revenue_change'] >= 0)
                                <small class="text- success"><i class="bi bi-arrow-up"></i> {{ $stats['daily_revenue_change'] }}% vs yesterday</small>
                            @else
                                <small class="text-danger"><i class="bi bi-arrow-down"></i> {{ abs($stats['daily_revenue_change']) }}% vs yesterday</small>
                            @endif
                        @else
                            <small class="text-muted"><i class="bi bi-info-circle"></i> No data for yesterday</small>
                        @endif
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Reservations</p>
                        <h3>{{ $stats['total_reservations'] }}</h3>
                        <small class="text-info"><i class="bi bi-info-circle"></i> {{ $stats['pending_reservations'] }} pending</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-ticket-perforated" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Today's Trips</p>
                        <h3>{{ $stats['active_trips'] }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle"></i> {{ $stats['today_bookings'] }} bookings today</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-geo-alt" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">My Staff</p>
                        <h3>{{ $stats['staff_count'] }}</h3>
                        <small class="text-success"><i class="bi bi-people"></i> Active staff</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(5, 150, 105, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-3">
                <a href="{{ route('agency_manager.reservations') }}" class="btn btn-success w-100 p-3">
                    <i class="bi bi-plus-circle"></i><br>
                    New Reservation
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('agency_manager.cash_register') }}" class="btn btn-primary w-100 p-3">
                    <i class="bi bi-cash-coin"></i><br>
                    Open Cash Register
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('agency_manager.trips') }}" class="btn btn-warning w-100 p-3">
                    <i class="bi bi-calendar-plus"></i><br>
                    Schedule Trip
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('agency_manager.staff.create') }}" class="btn btn-info w-100 p-3 text-white">
                    <i class="bi bi-person-plus"></i><br>
                    Add Staff
                </a>
            </div>
        </div>

        <!-- Today's Trips -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Today's Scheduled Trips</h5>
                <a href="{{ route('agency_manager.trips') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-calendar3"></i> View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Route</th>
                            <th>Departure</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Seats</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayTrips as $trip)
                            @php
                                $fromCity = $trip->route->fromCity->name ?? 'N/A';
                                $toCity = $trip->route->toCity->name ?? 'N/A';
                                $vehiclePlate = optional($trip->vehicle)->plate_number;
                                $vehicleModel = optional($trip->vehicle)->model;
                                $vehicleLabel = $vehiclePlate ?: ($vehicleModel ?: 'N/A');
                                $totalSeats = optional($trip->vehicle)->seat_count ?? $trip->available_seats;
                                $reservedSeats = $trip->reservations_count ?? 0;
                                $statusClass = match($trip->status) {
                                    'boarding' => 'badge-boarding',
                                    'departed' => 'badge-departed',
                                    'completed' => 'badge-completed',
                                    'cancelled' => 'badge-cancelled',
                                    default => 'badge-scheduled',
                                };
                            @endphp
                            <tr>
                                <td><strong>{{ $fromCity }} → {{ $toCity }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($trip->departure_time)->format('h:i A') }}</td>
                                <td>{{ $vehicleLabel }}</td>
                                <td><span class="text-muted">Not assigned</span></td>
                                <td>{{ $reservedSeats }}/{{ $totalSeats }}</td>
                                <td><span class="badge {{ $statusClass }}">{{ ucfirst($trip->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No trips scheduled for today</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
