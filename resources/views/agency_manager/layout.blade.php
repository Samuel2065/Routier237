@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-shop"></i> Routier+237</h4>
        <small class="text-white-50">Agency Manager</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('agency_manager.dashboard') }}" class="nav-link {{ request()->routeIs('agency_manager.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.reservations') }}" class="nav-link {{ request()->routeIs('agency_manager.reservations') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Reservations</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.staff') }}" class="nav-link {{ request()->routeIs('agency_manager.staff') || request()->routeIs('agency_manager.staff.create') ? 'active' : '' }}"><i class="bi bi-people"></i> Staff</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.vehicles') }}" class="nav-link {{ request()->routeIs('agency_manager.vehicles') ? 'active' : '' }}"><i class="bi bi-bus-front"></i> Vehicles</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.drivers') }}" class="nav-link {{ request()->routeIs('agency_manager.drivers') ? 'active' : '' }}"><i class="bi bi-person-badge"></i> Drivers</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.trips') }}" class="nav-link {{ request()->routeIs('agency_manager.trips') ? 'active' : '' }}"><i class="bi bi-signpost-split"></i> Trips</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.cash_register') }}" class="nav-link {{ request()->routeIs('agency_manager.cash_register') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i> Cash Register</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.expenses') }}" class="nav-link {{ request()->routeIs('agency_manager.expenses') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Expenses</a></div>
        <div class="nav-item"><a href="{{ route('agency_manager.reports') }}" class="nav-link {{ request()->routeIs('agency_manager.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Reports</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
