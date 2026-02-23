<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --sidebar-width: 260px; --panel-primary: #2563eb; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; color: #111827; }
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-width); background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); color: #fff; display: flex; flex-direction: column; z-index: 1000; overflow-y: auto; }
        .sidebar-header { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.12); }
        .nav-menu { padding: 1rem 0; flex: 1; }
        .nav-item { margin: 0.25rem 0.75rem; }
        .nav-link { display: flex; align-items: center; padding: 0.75rem 1rem; color: rgba(255,255,255,0.84); text-decoration: none; border-radius: 8px; transition: all 0.2s ease; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.18); color: #fff; }
        .nav-link i { margin-right: 0.75rem; font-size: 1.05rem; line-height: 1; }
        .sidebar-footer { padding: 1rem 0.75rem; border-top: 1px solid rgba(255,255,255,0.15); }
        .sidebar-logout-btn { width: 100%; border: 1px solid rgba(255,255,255,0.38); color: #fff; background: rgba(255,255,255,0.08); border-radius: 8px; padding: 0.65rem 0.85rem; text-align: left; display: flex; align-items: center; gap: 0.55rem; }
        .sidebar-logout-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; min-height: 100vh; }
        .top-bar { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 1.5rem; padding: 1rem 1.5rem; }
        .content-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 1.25rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: #fff; padding: 1.25rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid var(--panel-primary); }
        .stat-card h3 { font-size: 1.8rem; font-weight: 700; margin: 0.35rem 0; }
        .profile-trigger { border: 0; background: transparent; padding: 0; }
        .profile-name { font-weight: 700; color: #111827; line-height: 1.1; text-align: right; }
        .profile-status { font-size: 0.72rem; font-weight: 600; color: #6b7280; letter-spacing: 0.03em; text-transform: uppercase; }
        .profile-avatar-wrap { width: 42px; height: 42px; border-radius: 50%; position: relative; overflow: hidden; border: 2px solid #e5e7eb; cursor: pointer; }
        .profile-avatar { width: 100%; height: 100%; object-fit: cover; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; background: #10b981; border: 2px solid #fff; position: absolute; right: 0; bottom: 0; }
        .profile-menu { border: 0; border-radius: 14px; box-shadow: 0 14px 35px rgba(15, 23, 42, 0.18); min-width: 250px; padding: 0.8rem; }
        .profile-menu .menu-header { padding: 0.5rem 0.4rem 0.7rem; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.45rem; }
        .profile-menu .menu-label { font-size: 0.74rem; font-weight: 700; letter-spacing: 0.03em; color: #9ca3af; text-transform: uppercase; }
        .profile-menu .menu-email { color: #111827; font-weight: 600; }
        @media (max-width: 991.98px) { .sidebar { position: relative; width: 100%; height: auto; } .main-content { margin-left: 0; padding: 1rem; } }
    </style>
    @yield('page_css')
</head>
<body>
    @php
        $activeNav = trim($__env->yieldContent('active_nav')) ?: 'dashboard';
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

    @yield('sidebar')

    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="mb-0">@yield('page_title', 'Dashboard')</h2>
                @hasSection('page_subtitle')
                    <small class="text-muted">@yield('page_subtitle')</small>
                @endif
            </div>
            <div class="d-flex align-items-center gap-3">
                <div>@yield('page_actions')</div>
                <div class="dropdown">
                    @if(Route::has('profile.photo.update'))
                        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" id="profilePhotoFormBaseLayout" class="d-none">
                            @csrf
                            <input type="file" id="profilePhotoInputBaseLayout" name="photo" accept="image/*" onchange="this.form.submit()">
                        </form>
                    @endif
                    <button class="profile-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-none d-md-block">
                                <div class="profile-name">{{ $dashboardUserName }}</div>
                                <div class="profile-status">Account Active</div>
                            </div>
                            <div class="profile-avatar-wrap" @if(Route::has('profile.photo.update')) onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('profilePhotoInputBaseLayout').click();" @endif>
                                <img src="{{ $dashboardPhotoUrl }}" alt="{{ $dashboardUserName }}" class="profile-avatar">
                                <span class="status-dot"></span>
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end profile-menu">
                        <li class="menu-header">
                            <div class="menu-label">User</div>
                            <div class="menu-email">{{ $dashboardUserEmail }}</div>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('page_js')
</body>
</html>
