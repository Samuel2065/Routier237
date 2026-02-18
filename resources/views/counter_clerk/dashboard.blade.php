<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Clerk Dashboard - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #f97316;
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
            background: linear-gradient(180deg, #fb923c 0%, #f97316 100%);
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
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
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
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-ticket-perforated"></i> Routier+237</h4>
            <small class="text-white-50">Counter Clerk</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('counter_clerk.dashboard') }}" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('counter_clerk.reservations') }}" class="nav-link">
                    <i class="bi bi-ticket-perforated"></i>
                    <span>Reservations</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('counter_clerk.reservations.create') }}" class="nav-link">
                    <i class="bi bi-plus-circle"></i>
                    <span>New Reservation</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('counter_clerk.cash_register') }}" class="nav-link">
                    <i class="bi bi-cash-coin"></i>
                    <span>Cash Register</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Counter Clerk Dashboard</h2>
                    <small class="text-muted">Agency: {{ $agency->name ?? 'N/A' }}</small>
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
                        <p class="text-muted mb-1">Today's Bookings</p>
                        <h3>{{ $stats['today_bookings'] ?? 0 }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle"></i> New reservations</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(249, 115, 22, 0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-ticket-perforated" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Pending Payments</p>
                        <h3>{{ $stats['pending_payments'] ?? 0 }}</h3>
                        <small class="text-warning"><i class="bi bi-exclamation-circle"></i> Awaiting payment</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(249, 115, 22, 0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-hourglass-split" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Cash Register Balance</p>
                        <h3>{{ number_format($stats['cash_register_balance'] ?? 0) }} XAF</h3>
                        <small class="text-info"><i class="bi bi-cash-coin"></i> Current balance</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(249, 115, 22, 0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Quick Actions</h5>
                    <p class="text-muted mb-0">Create a reservation or manage the cash register</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('counter_clerk.reservations.create') }}" class="btn btn-warning text-white">
                        <i class="bi bi-plus-circle"></i> New Reservation
                    </a>
                    <a href="{{ route('counter_clerk.cash_register') }}" class="btn btn-outline-warning">
                        <i class="bi bi-cash-coin"></i> Cash Register
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
