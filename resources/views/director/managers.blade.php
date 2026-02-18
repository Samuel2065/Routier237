<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Managers - Director Dashboard</title>
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
            <div class="nav-item"><a href="{{ route('director.managers') }}" class="nav-link active"><i class="bi bi-people"></i>Agency Managers</a></div>
            <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link"><i class="bi bi-truck"></i>Fleet Overview</a></div>
            <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link"><i class="bi bi-graph-up"></i>Reports</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2 class="mb-0">Agency Managers</h2>
            <small class="text-muted">Demo manager assignments and status</small>
        </div>

        @php
            $demoManagers = [
                ['name' => 'Nana Michel', 'agency' => 'Yaounde Central', 'email' => 'nana.michel@routier-demo.cm', 'phone' => '+237 6 70 00 11 22', 'status' => 'Active'],
                ['name' => 'Esther Nji', 'agency' => 'Douala Bonanjo', 'email' => 'esther.nji@routier-demo.cm', 'phone' => '+237 6 80 22 33 44', 'status' => 'Active'],
                ['name' => 'Jean Ewane', 'agency' => 'Bafoussam Intercity', 'email' => 'jean.ewane@routier-demo.cm', 'phone' => '+237 6 90 55 66 77', 'status' => 'Pending'],
            ];
        @endphp

        <div class="card-shell">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Manager</th>
                            <th>Assigned Agency</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demoManagers as $manager)
                            <tr>
                                <td><strong>{{ $manager['name'] }}</strong></td>
                                <td>{{ $manager['agency'] }}</td>
                                <td>{{ $manager['email'] }}</td>
                                <td>{{ $manager['phone'] }}</td>
                                <td>
                                    <span class="badge {{ $manager['status'] === 'Active' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $manager['status'] }}
                                    </span>
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
