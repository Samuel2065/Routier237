<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin') - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --admin-primary: #2563eb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #111827;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
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
            color: rgba(255,255,255,0.84);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.05rem;
            line-height: 1;
        }

        .sidebar-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar-logout-btn {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.38);
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 0.65rem 0.85rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .sidebar-logout-btn:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        .top-bar {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
            padding: 1rem 1.5rem;
        }

        .content-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 1.25rem;
        }

        .pagination {
            margin-bottom: 0;
            gap: 0.25rem;
        }

        .pagination .page-link {
            border-radius: 8px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    @yield('page_css')
</head>
<body>
    @php
        $activeNav = trim($__env->yieldContent('active_nav')) ?: 'dashboard';
        $sidebarStats = $sidebarStats ?? ['pending_companies' => 0, 'pending_agencies' => 0];
    @endphp

    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shield-check"></i> Routier+237</h4>
            <small class="text-white-50">Super Admin Panel</small>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('super_admin.dashboard') }}" class="nav-link {{ $activeNav === 'dashboard' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.companies') }}" class="nav-link {{ in_array($activeNav, ['companies', 'companies.create']) ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Companies
                    @if(($sidebarStats['pending_companies'] ?? 0) > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $sidebarStats['pending_companies'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.agencies') }}" class="nav-link {{ $activeNav === 'agencies' ? 'active' : '' }}">
                    <i class="bi bi-shop"></i> All Agencies
                    @if(($sidebarStats['pending_agencies'] ?? 0) > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $sidebarStats['pending_agencies'] }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.users') }}" class="nav-link {{ $activeNav === 'users' ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users Management
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('super_admin.roles') }}" class="nav-link {{ in_array($activeNav, ['roles', 'permissions']) ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i> Roles & Permissions
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="mb-0">@yield('page_title', 'Super Admin')</h2>
                @hasSection('page_subtitle')
                    <small class="text-muted">@yield('page_subtitle')</small>
                @endif
            </div>
            <div>
                @yield('page_actions')
            </div>
        </div>

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

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('page_js')
</body>
</html>
