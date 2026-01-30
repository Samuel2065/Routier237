<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Routier+237</title>
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
            transition: all 0.3s;
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

        .badge-pending {
            background: #f59e0b;
        }

        .badge-approved {
            background: #10b981;
        }

        .badge-rejected {
            background: #ef4444;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shield-check"></i> Routier+237</h4>
            <small class="text-white-50">Super Admin Panel</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('super_admin.dashboard') }}" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.companies') }}" class="nav-link">
                    <i class="bi bi-building"></i>
                    <span>Companies</span>
                    @if($stats['pending_companies'] > 0)
                        <span class="badge bg-warning ms-auto">{{ $stats['pending_companies'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.agencies') }}" class="nav-link">
                    <i class="bi bi-shop"></i>
                    <span>All Agencies</span>
                    @if($stats['pending_agencies'] > 0)
                        <span class="badge bg-warning ms-auto">{{ $stats['pending_agencies'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.users') }}" class="nav-link">
                    <i class="bi bi-people"></i>
                    <span>Users Management</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.roles') }}" class="nav-link">
                    <i class="bi bi-shield-lock"></i>
                    <span>Roles & Permissions</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Dashboard Overview</h2>
                    <small class="text-muted">Welcome back, Super Admin</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
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

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p>Total Companies</p>
                        <h3>{{ $stats['total_companies'] }}</h3>
                        @if($stats['pending_companies'] > 0)
                            <small class="text-warning"><i class="bi bi-exclamation-circle"></i> {{ $stats['pending_companies'] }} pending</small>
                        @endif
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-building" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p>Active Agencies</p>
                        <h3>{{ $stats['active_agencies'] }}</h3>
                        @if($stats['pending_agencies'] > 0)
                            <small class="text-warning"><i class="bi bi-exclamation-circle"></i> {{ $stats['pending_agencies'] }} pending</small>
                        @endif
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-shop" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p>Total Users</p>
                        <h3>{{ $stats['total_users'] }}</h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <p>Total Revenue</p>
                        <h3>{{ number_format($stats['total_revenue']) }} XAF</h3>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        @if($pendingApprovals->count() > 0)
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle text-warning"></i> Pending Company Approvals</h5>
                <a href="{{ route('super_admin.companies') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Director</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingApprovals as $company)
                        <tr>
                            <td><strong>{{ $company->name }}</strong></td>
                            <td>{{ $company->director->full_name }}</td>
                            <td>{{ $company->created_at->diffForHumans() }}</td>
                            <td>
                                <form method="POST" action="{{ route('super_admin.companies.approve', $company->id) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Approve this company?')">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $company->id }}">
                                    <i class="bi bi-x-circle"></i> Reject
                                </button>
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $company->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('super_admin.companies.reject', $company->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Company</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Rejection Reason</label>
                                                <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject Company</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Recent Companies -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Companies</h5>
                <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Create Company
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Director</th>
                            <th>Agencies</th>
                            <th>Status</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCompanies as $company)
                        <tr>
                            <td><strong>{{ $company->name }}</strong></td>
                            <td>{{ $company->director->full_name }}</td>
                            <td>{{ $company->agencies->count() }}</td>
                            <td>
                                <span class="badge bg-{{ $company->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $company->approval_status }}">
                                    {{ ucfirst($company->approval_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No companies yet</td>
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