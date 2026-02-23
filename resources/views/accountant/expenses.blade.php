@extends('accountant.layout')
@section('active_nav', 'expenses')
@section('title', 'Expenses')
@section('page_title', 'Expenses')
@section('content')
<div class="content-card"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Date</th><th>Agency</th><th>Category</th><th>Amount</th><th>Status</th></tr></thead><tbody>@forelse($expenses as $expense)<tr><td>{{ $expense->expense_date }}</td><td>{{ data_get($expense,'agency.name','-') }}</td><td>{{ ucfirst($expense->category) }}</td><td>{{ $expense->amount }}</td><td>{{ ucfirst($expense->status) }}</td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">No expenses found.</td></tr>@endforelse</tbody></table></div><div class="mt-3">{{ $expenses->links() }}</div></div>
@endsection
