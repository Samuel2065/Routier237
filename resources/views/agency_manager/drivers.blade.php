@extends('agency_manager.layout')
@section('active_nav', 'drivers')
@section('title', 'Drivers')
@section('page_title', 'Drivers')
@section('page_subtitle', $agency->name ?? '')
@section('content')
<div class="content-card">
    <div class="table-responsive"><table class="table"><thead><tr><th>Name</th><th>Phone</th><th>License</th></tr></thead><tbody>@forelse($drivers as $employee)<tr><td>{{ data_get($employee, 'user.full_name', '-') }}</td><td>{{ data_get($employee, 'user.phone', '-') }}</td><td>{{ data_get($employee, 'driver.license_number', '-') }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted py-4">No drivers found.</td></tr>@endforelse</tbody></table></div>
    <div class="mt-3">{{ $drivers->links() }}</div>
</div>
@endsection
