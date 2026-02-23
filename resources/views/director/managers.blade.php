@extends('director.layout')

@section('active_nav', 'managers')
@section('title', 'Agency Managers')
@section('page_title', 'Agency Managers')
@section('page_subtitle', 'Managers assigned to your agencies')

@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Agency</th></tr></thead>
            <tbody>
                @forelse($managers as $manager)
                    <tr>
                        <td>{{ $manager->full_name }}</td>
                        <td>{{ $manager->email }}</td>
                        <td>{{ $manager->phone }}</td>
                        <td>{{ $manager->managedAgency->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No managers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $managers->links() }}</div>
</div>
@endsection
