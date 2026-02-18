<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Overview - Director Dashboard</title>
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
        .card-shell { padding: 1.25rem; }
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
            <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link active"><i class="bi bi-truck"></i>Fleet Overview</a></div>
            <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link"><i class="bi bi-graph-up"></i>Reports</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2 class="mb-0">Fleet Overview</h2>
            <small class="text-muted">Demo fleet health and availability</small>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3"><div class="card-shell text-center"><h3 class="text-primary mb-1">42</h3><small class="text-muted">Total Vehicles</small></div></div>
            <div class="col-md-3"><div class="card-shell text-center"><h3 class="text-success mb-1">35</h3><small class="text-muted">Active</small></div></div>
            <div class="col-md-3"><div class="card-shell text-center"><h3 class="text-warning mb-1">5</h3><small class="text-muted">Maintenance</small></div></div>
            <div class="col-md-3"><div class="card-shell text-center"><h3 class="text-danger mb-1">2</h3><small class="text-muted">Out of Service</small></div></div>
        </div>

        @php
            $demoFleet = [
                ['plate' => 'LT-342-AA', 'model' => 'Toyota Coaster 30', 'agency' => 'Yaounde Central', 'capacity' => 30, 'status' => 'Active'],
                ['plate' => 'CE-912-BB', 'model' => 'Hyundai Universe', 'agency' => 'Douala Bonanjo', 'capacity' => 45, 'status' => 'Maintenance'],
                ['plate' => 'NW-118-CC', 'model' => 'Mercedes Sprinter', 'agency' => 'Bafoussam Intercity', 'capacity' => 18, 'status' => 'Active'],
                ['plate' => 'OU-451-DD', 'model' => 'Yutong ZK6122', 'agency' => 'Yaounde Central', 'capacity' => 52, 'status' => 'Out of Service'],
            ];
        @endphp

        <div class="card-shell">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Plate</th>
                            <th>Model</th>
                            <th>Agency</th>
                            <th>Capacity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demoFleet as $vehicle)
                            <tr>
                                <td><strong>{{ $vehicle['plate'] }}</strong></td>
                                <td>{{ $vehicle['model'] }}</td>
                                <td>{{ $vehicle['agency'] }}</td>
                                <td>{{ $vehicle['capacity'] }} seats</td>
                                <td>
                                    @php
                                        $statusClass = $vehicle['status'] === 'Active' ? 'bg-success' : ($vehicle['status'] === 'Maintenance' ? 'bg-warning text-dark' : 'bg-danger');
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $vehicle['status'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
