<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #f59e0b;
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
            background: linear-gradient(180deg, #d97706 0%, #b45309 100%);
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

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
        }

        .trip-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .trip-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.1);
        }

        .trip-card.active {
            border-color: var(--primary-color);
            background: #fffbeb;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-person-badge"></i> Routier+237</h4>
            <small class="text-white-50">Driver Portal</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-calendar3"></i>
                    <span>My Schedule</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-geo-alt"></i>
                    <span>My Trips</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-truck"></i>
                    <span>My Vehicle</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Trip Reports</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Driver Dashboard</h2>
                    <small class="text-muted">Welcome, John Doe</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Driver
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
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

        <!-- Current Status -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Current Status</h6>
                    <h3 class="mb-0 text-success"><i class="bi bi-check-circle-fill"></i> On Trip</h3>
                    <small>Yaoundé → Douala</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Assigned Vehicle</h6>
                    <h3 class="mb-0">Bus 001</h3>
                    <small>Toyota Coaster - 70 seats</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h6 class="text-muted">Trips This Month</h6>
                    <h3 class="mb-0">24</h3>
                    <small class="text-success"><i class="bi bi-arrow-up"></i> 8% more than last month</small>
                </div>
            </div>
        </div>

        <!-- Active Trip -->
        <div class="stat-card mb-4">
            <h5 class="mb-3"><i class="bi bi-geo-alt-fill text-warning"></i> Active Trip</h5>
            <div class="trip-card active">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4>Yaoundé → Douala</h4>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <small class="text-muted d-block">Departure</small>
                                <strong>08:00 AM</strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Expected Arrival</small>
                                <strong>12:30 PM</strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Passengers</small>
                                <strong>65/70</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-warning btn-lg">
                            <i class="bi bi-geo-alt"></i> Update Location
                        </button>
                        <button class="btn btn-success btn-lg mt-2">
                            <i class="bi bi-check-circle"></i> Complete Trip
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Trips -->
        <div class="stat-card">
            <h5 class="mb-3">Upcoming Trips</h5>
            <div class="trip-card">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h5>Douala → Yaoundé</h5>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <small class="text-muted">Date</small>
                                <div><strong>Tomorrow, 06:00 AM</strong></div>
                            </div>
                            <div>
                                <small class="text-muted">Vehicle</small>
                                <div><strong>Bus 001</strong></div>
                            </div>
                            <div>
                                <small class="text-muted">Passengers</small>
                                <div><strong>52/70</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge bg-info p-2">Scheduled</span>
                    </div>
                </div>
            </div>
            
            <div class="trip-card">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h5>Yaoundé → Bamenda</h5>
                        <div class="d-flex gap-4 mt-2">
                            <div>
                                <small class="text-muted">Date</small>
                                <div><strong>Jan 28, 08:30 AM</strong></div>
                            </div>
                            <div>
                                <small class="text-muted">Vehicle</small>
                                <div><strong>Bus 001</strong></div>
                            </div>
                            <div>
                                <small class="text-muted">Passengers</small>
                                <div><strong>38/70</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge bg-info p-2">Scheduled</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Status -->
        <div class="stat-card">
            <h5 class="mb-3">My Vehicle Status</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <i class="bi bi-fuel-pump display-4 text-warning"></i>
                        <div class="mt-2">
                            <strong>Fuel Level</strong>
                            <div>75%</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <i class="bi bi-speedometer display-4 text-primary"></i>
                        <div class="mt-2">
                            <strong>Mileage</strong>
                            <div>45,230 km</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <i class="bi bi-wrench display-4 text-success"></i>
                        <div class="mt-2">
                            <strong>Condition</strong>
                            <div>Good</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 border rounded">
                        <i class="bi bi-calendar-check display-4 text-info"></i>
                        <div class="mt-2">
                            <strong>Next Service</strong>
                            <div>2,000 km</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>