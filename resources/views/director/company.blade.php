<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Company - Director Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 260px; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-width); height: 100vh; background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); color: #fff; }
        .sidebar-header { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,.15); }
        .nav-item { margin: .25rem .75rem; }
        .nav-link { color: rgba(255,255,255,.85); border-radius: 8px; padding: .75rem 1rem; display: flex; align-items: center; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,.15); color: #fff; }
        .nav-link i { margin-right: .75rem; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; }
        .top-bar, .content-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .top-bar { padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .content-card { padding: 1.5rem; margin-bottom: 1.25rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-building"></i> Routier+237</h4>
            <small class="text-white-50">Director Panel</small>
        </div>
        <div class="py-3">
            <div class="nav-item"><a href="{{ route('director.dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i>Dashboard</a></div>
            <div class="nav-item"><a href="{{ route('director.company') }}" class="nav-link active"><i class="bi bi-building"></i>My Company</a></div>
            <div class="nav-item"><a href="{{ route('director.agencies') }}" class="nav-link"><i class="bi bi-shop"></i>My Agencies</a></div>
            <div class="nav-item"><a href="{{ route('director.managers') }}" class="nav-link"><i class="bi bi-people"></i>Agency Managers</a></div>
            <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link"><i class="bi bi-truck"></i>Fleet Overview</a></div>
            <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link"><i class="bi bi-graph-up"></i>Reports</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">My Company</h2>
                <small class="text-muted">Presentation demo information</small>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <h5 class="mb-3">Company Profile</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Name:</strong> {{ $company->name ?? 'Routier Express' }}</p>
                            <p class="mb-2"><strong>Registration No:</strong> RC/YAO/2022/B/1456</p>
                            <p class="mb-2"><strong>Email:</strong> contact@routier-demo.cm</p>
                            <p class="mb-0"><strong>Phone:</strong> +237 6 95 11 22 33</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Head Office:</strong> Yaounde, Bastos</p>
                            <p class="mb-2"><strong>Founded:</strong> 2022</p>
                            <p class="mb-2"><strong>Status:</strong> <span class="badge bg-success">Operational</span></p>
                            <p class="mb-0"><strong>Business Type:</strong> Intercity transport</p>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <h5 class="mb-3">Coverage Snapshot (Demo)</h5>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h3 class="text-primary mb-1">6</h3>
                            <small class="text-muted">Cities Covered</small>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-primary mb-1">14</h3>
                            <small class="text-muted">Active Routes</small>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-primary mb-1">28</h3>
                            <small class="text-muted">Daily Departures</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <h5 class="mb-3">Compliance Notes</h5>
                    <p class="small text-muted mb-2">Insurance expiry: 17 Sep 2026</p>
                    <p class="small text-muted mb-2">Transport license renewal: 05 Jun 2026</p>
                    <p class="small text-muted mb-0">Audit status: Up to date</p>
                </div>
                <div class="content-card">
                    <h5 class="mb-3">Director Actions</h5>
                    <a href="{{ route('director.agencies') }}" class="btn btn-primary w-100 mb-2"><i class="bi bi-shop"></i> Manage Agencies</a>
                    <a href="{{ route('director.reports') }}" class="btn btn-outline-primary w-100"><i class="bi bi-file-earmark-bar-graph"></i> View Reports</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
