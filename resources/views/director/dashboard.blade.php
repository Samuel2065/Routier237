<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director Dashboard - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2563eb;
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
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-menu {
            padding: 1rem 0;
            flex: 1;
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

        .content-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
        }

        .approval-alert {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar-logout-btn {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 0.65rem 0.85rem;
            text-align: left;
        }

        .sidebar-logout-btn:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        .profile-trigger {
            border: 0;
            background: transparent;
            padding: 0;
        }

        .profile-name {
            font-weight: 700;
            color: #111827;
            line-height: 1.1;
            text-align: right;
        }

        .profile-status {
            font-size: 0.72rem;
            font-weight: 600;
            color: #6b7280;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .profile-avatar-wrap {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 2px solid #e5e7eb;
            cursor: pointer;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #fff;
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .profile-menu {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.18);
            min-width: 250px;
            padding: 0.8rem;
        }

        .profile-menu .menu-header {
            padding: 0.5rem 0.4rem 0.7rem;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 0.45rem;
        }

        .profile-menu .menu-label {
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .profile-menu .menu-email {
            color: #111827;
            font-weight: 600;
        }

        .profile-menu .dropdown-item {
            border-radius: 10px;
            padding: 0.6rem 0.55rem;
            font-weight: 500;
        }

        .profile-menu .dropdown-item.text-danger {
            font-weight: 700;
        }
    </style>
</head>
<body>
    @php
        $dashboardUser = auth()->user();
        $dashboardUserName = $dashboardUser->full_name ?? $dashboardUser->name ?? 'User';
        $dashboardUserEmail = $dashboardUser->email ?? '';
        $dashboardUserPhoto = $dashboardUser->photo ?? null;
        if (!empty($dashboardUserPhoto)) {
            if (\Illuminate\Support\Str::startsWith($dashboardUserPhoto, ['http://', 'https://'])) {
                $dashboardPhotoUrl = $dashboardUserPhoto;
            } elseif (\Illuminate\Support\Str::startsWith($dashboardUserPhoto, ['assets/', 'storage/'])) {
                $dashboardPhotoUrl = asset($dashboardUserPhoto);
            } else {
                $dashboardPhotoUrl = asset('storage/' . ltrim($dashboardUserPhoto, '/'));
            }
        } else {
            $dashboardPhotoUrl = asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png');
        }
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-building"></i> Routier+237</h4>
            <small class="text-white-50">Director Panel</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('director.dashboard') }}" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('director.company') }}" class="nav-link">
                    <i class="bi bi-building"></i>
                    <span>My Company</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('director.agencies') }}" class="nav-link">
                    <i class="bi bi-shop"></i>
                    <span>My Agencies</span>
                    @if($stats['pending_agencies'] > 0)
                        <span class="badge bg-warning ms-auto">{{ $stats['pending_agencies'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('director.managers') }}" class="nav-link">
                    <i class="bi bi-people"></i>
                    <span>Agency Managers</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('director.fleet') }}" class="nav-link">
                    <i class="bi bi-truck"></i>
                    <span>Fleet Overview</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('director.reports') }}" class="nav-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Reports</span>
                </a>
            </div>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Director Dashboard</h2>
                    <small class="text-muted">Company: {{ $company->name }}</small>
                </div>
                <div class="dropdown">
                    <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" id="profilePhotoFormDirector" class="d-none">
                        @csrf
                        <input type="file" id="profilePhotoInputDirector" name="photo" accept="image/*" onchange="this.form.submit()">
                    </form>
                    <button class="profile-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-md-block">
                                <div class="profile-name">{{ $dashboardUserName }}</div>
                                <div class="profile-status">Compte active</div>
                            </div>
                            <div class="profile-avatar-wrap" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('profilePhotoInputDirector').click();">
                                <img src="{{ $dashboardPhotoUrl }}" alt="{{ $dashboardUserName }}" class="profile-avatar">
                                <span class="status-dot"></span>
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end profile-menu">
                        <li class="menu-header">
                            <div class="menu-label">Utilisateur</div>
                            <div class="menu-email">{{ $dashboardUserEmail }}</div>
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Mon Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-clock-history me-2"></i> Historique</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                </button>
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

        <!-- Company Status Alert -->
        @if($company->approval_status === 'pending')
            <div class="alert approval-alert">
                <h5 class="alert-heading"><i class="bi bi-hourglass-split"></i> Company Pending Approval</h5>
                <p class="mb-0">Your company is waiting for Super Admin approval. You won't be able to create agencies until approved.</p>
            </div>
        @elseif($company->approval_status === 'rejected')
            <div class="alert alert-danger">
                <h5 class="alert-heading"><i class="bi bi-x-circle"></i> Company Rejected</h5>
                <p class="mb-0"><strong>Reason:</strong> {{ $company->rejection_reason }}</p>
            </div>
        @elseif(!$companyApproved)
            <div class="alert alert-warning">
                <p class="mb-0"><i class="bi bi-exclamation-triangle"></i> Your company status: {{ ucfirst($company->approval_status) }}</p>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">My Agencies</p>
                        <h3 style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0;">{{ $stats['total_agencies'] }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle"></i> {{ $stats['approved_agencies'] }} approved</small>
                        @if($stats['pending_agencies'] > 0)
                            <br><small class="text-warning"><i class="bi bi-clock"></i> {{ $stats['pending_agencies'] }} pending</small>
                        @endif
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-shop" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Vehicles</p>
                        <h3 style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0;">{{ $stats['active_vehicles'] }}</h3>
                        <small class="text-success"><i class="bi bi-check-circle"></i> Active</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-truck" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Monthly Revenue</p>
                        <h3 style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0;">{{ number_format($stats['monthly_revenue']) }} XAF</h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Bookings</p>
                        <h3 style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0;">{{ $stats['total_bookings'] }}</h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-ticket-perforated" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action -->
        @if($companyApproved)
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Manage Agencies</h5>
                    <p class="text-muted mb-0">Create new agencies and assign managers</p>
                </div>
                <a href="{{ route('director.agencies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create New Agency
                </a>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
