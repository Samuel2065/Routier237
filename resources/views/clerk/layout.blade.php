@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-cash-coin"></i> Routier+237</h4>
        <small class="text-white-50">Counter Clerk</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('counter_clerk.dashboard') }}" class="nav-link {{ request()->routeIs('counter_clerk.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('counter_clerk.reservations') }}" class="nav-link {{ request()->routeIs('counter_clerk.reservations') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Reservations</a></div>
        <div class="nav-item"><a href="{{ route('counter_clerk.reservations.create') }}" class="nav-link {{ request()->routeIs('counter_clerk.reservations.create') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i> New Reservation</a></div>
        <div class="nav-item"><a href="{{ route('counter_clerk.cash_register') }}" class="nav-link {{ request()->routeIs('counter_clerk.cash_register') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i> Cash Register</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
