@extends('agency_manager.layout')
@section('active_nav', 'expenses')
@section('title', 'Expenses')
@section('page_title', 'Expenses')
@section('page_subtitle', $agency->name ?? '')
@section('content')
<div class="content-card">
    <div class="table-responsive"><table class="table"><thead><tr><th>Date</th><th>Category</th><th>Amount</th><th>Status</th></tr></thead><tbody>@forelse($expenses as $expense)<tr><td>{{ $expense->expense_date }}</td><td>{{ ucfirst($expense->category) }}</td><td>{{ $expense->amount }}</td><td>{{ ucfirst($expense->status) }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No expenses found.</td></tr>@endforelse</tbody></table></div>
    <div class="mt-3">{{ $expenses->links() }}</div>
</div>
@endsection
