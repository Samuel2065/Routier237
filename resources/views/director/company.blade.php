@extends('director.layout')

@section('active_nav', 'company')
@section('title', 'My Company')
@section('page_title', 'My Company')
@section('page_subtitle', $company->name)

@section('content')
<div class="content-card">
    <h5 class="mb-3">Company Details</h5>
    <div class="row g-3">
        <div class="col-md-6"><strong>Name:</strong> {{ $company->name }}</div>
        <div class="col-md-6"><strong>Email:</strong> {{ $company->email }}</div>
        <div class="col-md-6"><strong>Phone:</strong> {{ $company->phone }}</div>
        <div class="col-md-6"><strong>Taxpayer Number:</strong> {{ $company->taxpayer_number }}</div>
        <div class="col-md-12"><strong>Headquarters:</strong> {{ $company->headquarters_address }}</div>
        <div class="col-md-6"><strong>Status:</strong> <span class="badge bg-{{ $company->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($company->status) }}</span></div>
        <div class="col-md-6"><strong>Approval:</strong> <span class="badge bg-{{ $company->approval_status === 'approved' ? 'success' : ($company->approval_status === 'rejected' ? 'danger' : 'warning text-dark') }}">{{ ucfirst($company->approval_status) }}</span></div>
    </div>
</div>
@endsection
