@extends('director.layout')

@section('active_nav', 'agencies')
@section('title', 'My Agencies')
@section('page_title', 'My Agencies')
@section('page_subtitle', 'Manage your company agencies')

@section('page_actions')
<a href="{{ route('director.agencies.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Create Agency</a>
@endsection

@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Agency Code</th><th>Name</th><th>City</th><th>Manager</th><th>Type</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse($agencies as $agency)
                    <tr>
                        <td><strong>{{ $agency->agency_code }}</strong></td>
                        <td>{{ $agency->name }}</td>
                        <td>{{ $agency->city->name ?? '-' }}</td>
                        <td>{{ $agency->manager->full_name ?? '-' }}</td>
                        <td>{{ ucfirst($agency->type) }}</td>
                        <td><span class="badge {{ $agency->approval_status === 'approved' ? 'bg-success' : ($agency->approval_status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">{{ ucfirst($agency->approval_status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No agencies found yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $agencies->links() }}</div>
</div>
@endsection
