@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-calculator"></i> Routier+237</h4>
        <small class="text-white-50">Accountant Panel</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('accountant.dashboard') }}" class="nav-link {{ request()->routeIs('accountant.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('accountant.transactions') }}" class="nav-link {{ request()->routeIs('accountant.transactions') ? 'active' : '' }}"><i class="bi bi-arrow-left-right"></i> Transactions</a></div>
        <div class="nav-item"><a href="{{ route('accountant.expenses') }}" class="nav-link {{ request()->routeIs('accountant.expenses') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Expenses</a></div>
        <div class="nav-item"><a href="{{ route('accountant.cash_registers') }}" class="nav-link {{ request()->routeIs('accountant.cash_registers') ? 'active' : '' }}"><i class="bi bi-safe2"></i> Cash Registers</a></div>
        <div class="nav-item"><a href="{{ route('accountant.reports') }}" class="nav-link {{ request()->routeIs('accountant.reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Reports</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
