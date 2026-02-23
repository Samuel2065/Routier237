@extends('agency_manager.layout')
@section('active_nav', 'cash_register')
@section('title', 'Cash Register')
@section('page_title', 'Cash Registers')
@section('page_subtitle', $agency->name ?? '')
@section('content')
<div class="content-card">
    <div class="table-responsive"><table class="table"><thead><tr><th>Opened</th><th>User</th><th>Current Amount</th><th>Status</th></tr></thead><tbody>@forelse($cashRegisters as $register)<tr><td>{{ $register->opening_date }}</td><td>{{ data_get($register, 'user.full_name', '-') }}</td><td>{{ $register->current_amount }}</td><td>{{ ucfirst($register->status) }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No cash registers found.</td></tr>@endforelse</tbody></table></div>
    <div class="mt-3">{{ $cashRegisters->links() }}</div>
</div>
@endsection
