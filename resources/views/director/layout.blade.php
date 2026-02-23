@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-building"></i> Routier+237</h4>
        <small class="text-white-50">Director Panel</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('director.dashboard') }}" class="nav-link {{ request()->routeIs('director.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('director.company') }}" class="nav-link {{ request()->routeIs('director.company') ? 'active' : '' }}"><i class="bi bi-building"></i> My Company</a></div>
        <div class="nav-item"><a href="{{ route('director.agencies') }}" class="nav-link {{ request()->routeIs('director.agencies') || request()->routeIs('director.agencies.create') ? 'active' : '' }}"><i class="bi bi-shop"></i> My Agencies</a></div>
        <div class="nav-item"><a href="{{ route('director.managers') }}" class="nav-link {{ request()->routeIs('director.managers') ? 'active' : '' }}"><i class="bi bi-people"></i> Agency Managers</a></div>
        <div class="nav-item"><a href="{{ route('director.fleet') }}" class="nav-link {{ request()->routeIs('director.fleet') ? 'active' : '' }}"><i class="bi bi-truck"></i> Fleet</a></div>
        <div class="nav-item"><a href="{{ route('director.reports') }}" class="nav-link {{ request()->routeIs('director.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Reports</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
