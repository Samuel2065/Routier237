@extends('accountant.layout')
@section('active_nav', 'transactions')
@section('title', 'Transactions')
@section('page_title', 'Transactions')
@section('content')
<div class="content-card"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Date</th><th>Type</th><th>Amount</th><th>Reference</th></tr></thead><tbody>@forelse($transactions as $tx)<tr><td>{{ $tx->transaction_date }}</td><td>{{ ucfirst($tx->type) }}</td><td>{{ $tx->amount }}</td><td>{{ $tx->reference }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No transactions found.</td></tr>@endforelse</tbody></table></div><div class="mt-3">{{ $transactions->links() }}</div></div>
@endsection
