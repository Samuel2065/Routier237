@extends('agency_manager.layout')

@section('active_nav', 'staff.create')
@section('title', 'Create Staff')
@section('page_title', 'Create Staff Member')
@section('page_subtitle', $agency->name ?? '')

@section('content')
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="content-card">
    <form method="POST" action="{{ route('agency_manager.staff.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" name="full_name" value="{{ old('full_name') }}" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone" value="{{ old('phone') }}" required></div>
        <div class="col-md-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
        <div class="col-md-3"><label class="form-label">Confirm Password</label><input class="form-control" type="password" name="password_confirmation" required></div>
        <div class="col-md-4"><label class="form-label">Role</label><select class="form-select" name="role" required><option value="counter_clerk">Counter Clerk</option><option value="accountant">Accountant</option><option value="driver">Driver</option></select></div>
        <div class="col-md-4"><label class="form-label">Position</label><input class="form-control" name="position" value="{{ old('position') }}" required></div>
        <div class="col-md-4"><label class="form-label">Hire Date</label><input class="form-control" type="date" name="hire_date" value="{{ old('hire_date') }}" required></div>
        <div class="col-md-4"><label class="form-label">Base Salary</label><input class="form-control" type="number" step="0.01" name="base_salary" value="{{ old('base_salary') }}" required></div>
        <div class="col-md-4"><label class="form-label">ID Card Number</label><input class="form-control" name="id_card_number" value="{{ old('id_card_number') }}" required></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Create Staff</button></div>
    </form>
</div>
@endsection
