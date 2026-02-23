@extends('accountant.layout')

@section('active_nav', 'dashboard')
@section('title', 'Accountant Dashboard')
@section('page_title', 'Accountant Dashboard')
@section('page_subtitle', data_get($agency, 'name', 'Financial overview'))

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Today Revenue</p><h3>{{ number_format($stats['today_revenue']) }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Today Expenses</p><h3>{{ number_format($stats['today_expenses']) }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Net Profit</p><h3>{{ number_format($stats['net_profit']) }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Open Registers</p><h3>{{ $stats['active_cash_registers'] }}</h3></div>
</div>
<div class="content-card"><p class="mb-0 text-muted">Use the sidebar to access detailed financial records.</p></div>
@endsection
