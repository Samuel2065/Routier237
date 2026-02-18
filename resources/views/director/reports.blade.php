<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Director Dashboard</title>
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
        .top-bar, .card-shell { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .top-bar { padding: 1rem 1.5rem; margin-bottom: 1.5rem; }
        .card-shell { padding: 1.25rem; margin-bottom: 1rem; }
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
            <div class="nav-item"><a href="{{ route('director.company') }}" class="nav-link"><i class="bi bi-building"></i>My Company</a></div>
            <div class="nav-item"><a href="{{ route('director.agencies') }}" class="nav-link"><i class="bi bi-shop"></i>My Agencies</a></div>
            <div class="nav-item"><a href="{{ route('director.managers') }}" class="nav-link"><i class="bi bi-people"></i>Agency Managers</a></div>
            <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link"><i class="bi bi-truck"></i>Fleet Overview</a></div>
            <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link active"><i class="bi bi-graph-up"></i>Reports</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2 class="mb-0">Reports</h2>
            <small class="text-muted">Demo KPI snapshots for board presentation</small>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-shell">
                    <h6 class="mb-3">Revenue by Agency (Demo)</h6>
                    <div class="mb-2 d-flex justify-content-between"><span>Yaounde Central</span><strong>18.2M XAF</strong></div>
                    <div class="progress mb-3"><div class="progress-bar bg-primary" style="width: 92%"></div></div>
                    <div class="mb-2 d-flex justify-content-between"><span>Douala Bonanjo</span><strong>14.7M XAF</strong></div>
                    <div class="progress mb-3"><div class="progress-bar bg-info" style="width: 74%"></div></div>
                    <div class="mb-2 d-flex justify-content-between"><span>Bafoussam Intercity</span><strong>9.9M XAF</strong></div>
                    <div class="progress"><div class="progress-bar bg-success" style="width: 56%"></div></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-shell">
                    <h6 class="mb-3">Operational Indicators (Demo)</h6>
                    <p class="mb-2">On-time departure rate: <strong>93%</strong></p>
                    <p class="mb-2">Average seat occupancy: <strong>78%</strong></p>
                    <p class="mb-2">Cancellation ratio: <strong>2.8%</strong></p>
                    <p class="mb-0">Customer satisfaction index: <strong>4.4 / 5</strong></p>
                </div>
            </div>
        </div>

        <div class="card-shell mt-3">
            <h6 class="mb-3">Monthly Summary (Demo)</h6>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Bookings</th>
                            <th>Revenue</th>
                            <th>Net Margin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>November</td><td>10,920</td><td>39.7M XAF</td><td>23%</td></tr>
                        <tr><td>December</td><td>12,310</td><td>44.2M XAF</td><td>25%</td></tr>
                        <tr><td>January</td><td>11,880</td><td>42.9M XAF</td><td>24%</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
