@extends('customer.layout')
@section('active_nav', 'profile')
@section('title', 'Profile')
@section('page_title', 'My Profile')
@section('content')
<div class="content-card">
    <div class="row g-3">
        <div class="col-md-6"><strong>Full Name:</strong> {{ $user->full_name }}</div>
        <div class="col-md-6"><strong>Email:</strong> {{ $user->email }}</div>
        <div class="col-md-6"><strong>Phone:</strong> {{ $user->phone }}</div>
        <div class="col-md-6"><strong>Status:</strong> {{ ucfirst($user->status) }}</div>
    </div>
</div>
@endsection
