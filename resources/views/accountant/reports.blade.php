@extends('accountant.layout')
@section('active_nav', 'reports')
@section('title', 'Reports')
@section('page_title', 'Financial Reports')
@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Monthly Revenue</p><h3>{{ number_format($monthlyRevenue) }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Monthly Expenses</p><h3>{{ number_format($monthlyExpenses) }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Monthly Net</p><h3>{{ number_format($monthlyRevenue - $monthlyExpenses) }}</h3></div>
</div>
@endsection
