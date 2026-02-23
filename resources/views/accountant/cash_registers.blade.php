@extends('accountant.layout')
@section('active_nav', 'cash_registers')
@section('title', 'Cash Registers')
@section('page_title', 'Cash Registers')
@section('content')
<div class="content-card"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Agency</th><th>User</th><th>Opening</th><th>Current Amount</th><th>Status</th></tr></thead><tbody>@forelse($cashRegisters as $register)<tr><td>{{ data_get($register,'agency.name','-') }}</td><td>{{ data_get($register,'user.full_name','-') }}</td><td>{{ $register->opening_date }}</td><td>{{ $register->current_amount }}</td><td>{{ ucfirst($register->status) }}</td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">No cash registers found.</td></tr>@endforelse</tbody></table></div><div class="mt-3">{{ $cashRegisters->links() }}</div></div>
@endsection
