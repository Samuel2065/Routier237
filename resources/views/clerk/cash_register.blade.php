@extends('clerk.layout')

@section('active_nav', 'cash_register')
@section('title', 'Cash Register')
@section('page_title', 'Cash Register')
@section('page_subtitle', $agency->name ?? '')

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="content-card">
            <h5>Open Register</h5>
            <form method="POST" action="{{ route('counter_clerk.cash_register.open') }}" class="row g-2">
                @csrf
                <div class="col-12"><input class="form-control" type="number" step="0.01" name="opening_balance" placeholder="Opening balance" required></div>
                <div class="col-12"><button class="btn btn-success" type="submit">Open</button></div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="content-card">
            <h5>Close Register</h5>
            <form method="POST" action="{{ route('counter_clerk.cash_register.close') }}" class="row g-2">
                @csrf
                <div class="col-12"><input class="form-control" type="number" step="0.01" name="closing_balance" placeholder="Closing balance" required></div>
                <div class="col-12"><textarea class="form-control" name="notes" rows="3" placeholder="Notes"></textarea></div>
                <div class="col-12"><button class="btn btn-danger" type="submit">Close</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
