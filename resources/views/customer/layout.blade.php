@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-person-circle"></i> Routier+237</h4>
        <small class="text-white-50">Customer Space</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('customer.reservations') }}" class="nav-link {{ request()->routeIs('customer.reservations') ? 'active' : '' }}"><i class="bi bi-ticket-perforated"></i> My Reservations</a></div>
        <div class="nav-item"><a href="{{ route('customer.book') }}" class="nav-link {{ request()->routeIs('customer.book') ? 'active' : '' }}"><i class="bi bi-plus-circle"></i> Book Trip</a></div>
        <div class="nav-item"><a href="{{ route('customer.profile') }}" class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}"><i class="bi bi-person"></i> Profile</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
