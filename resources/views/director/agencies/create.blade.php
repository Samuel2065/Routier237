<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Agency - Director Dashboard</title>
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
        .content-card { padding: 1.5rem; }
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
            <div class="nav-item"><a href="{{ route('director.agencies') }}" class="nav-link active"><i class="bi bi-shop"></i>My Agencies</a></div>
            <div class="nav-item"><a href="{{ route('director.managers') }}" class="nav-link"><i class="bi bi-people"></i>Agency Managers</a></div>
            <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link"><i class="bi bi-truck"></i>Fleet Overview</a></div>
            <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link"><i class="bi bi-graph-up"></i>Reports</a></div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Create New Agency</h2>
                <small class="text-muted">Complete agency data and assign an agency manager</small>
            </div>
            <a href="{{ route('director.agencies') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Agencies
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="content-card">
            <form method="POST" action="{{ route('director.agencies.store') }}">
                @csrf
                <h5 class="mb-3">Agency Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Agency Name *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">City *</label>
                        <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">District</label>
                        <input type="text" class="form-control" name="district" value="{{ old('district') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Full Address *</label>
                        <textarea class="form-control" rows="2" name="full_address" required>{{ old('full_address') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone *</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Agency Type *</label>
                        <select name="type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="main" {{ old('type') === 'main' ? 'selected' : '' }}>Main</option>
                            <option value="secondary" {{ old('type') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Agency Manager Assignment</h5>
                <p class="text-muted small mb-3">Required: assign one manager so they can log in from the main sign-in page and access their assigned agency dashboard directly.</p>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Manager Option *</label>
                        <select id="manager_option" name="manager_option" class="form-select" required>
                            <option value="existing" {{ old('manager_option', 'existing') === 'existing' ? 'selected' : '' }}>Assign Existing Manager</option>
                            <option value="new" {{ old('manager_option') === 'new' ? 'selected' : '' }}>Create New Manager Account</option>
                        </select>
                    </div>
                </div>

                <div id="existing_manager_block" class="row g-3 mt-1">
                    <div class="col-md-8">
                        <label class="form-label">Select Existing Manager *</label>
                        <select name="manager_id" class="form-select">
                            <option value="">Choose manager</option>
                            @foreach(($availableManagers ?? collect()) as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->full_name }} - {{ $manager->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="new_manager_block" class="row g-3 mt-1 d-none">
                    <div class="col-md-6">
                        <label class="form-label">Manager Full Name *</label>
                        <input type="text" class="form-control" name="manager_full_name" value="{{ old('manager_full_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Manager Email *</label>
                        <input type="email" class="form-control" name="manager_email" value="{{ old('manager_email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Manager Phone *</label>
                        <input type="text" class="form-control" name="manager_phone" value="{{ old('manager_phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Temporary Password *</label>
                        <input type="password" class="form-control" name="manager_password">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Create Agency
                    </button>
                    <a href="{{ route('director.agencies') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var optionInput = document.getElementById('manager_option');
            var existingBlock = document.getElementById('existing_manager_block');
            var newBlock = document.getElementById('new_manager_block');

            function toggleManagerBlocks() {
                var isNew = optionInput.value === 'new';
                newBlock.classList.toggle('d-none', !isNew);
                existingBlock.classList.toggle('d-none', isNew);
            }

            optionInput.addEventListener('change', toggleManagerBlocks);
            toggleManagerBlocks();
        })();
    </script>
</body>
</html>
