@extends('admin.layout')

@section('active_nav', 'roles')

@section('title', 'Roles & Permissions')
@section('page_title', 'Roles & Permissions')
@section('page_subtitle', 'Dynamic access model overview')

@section('page_actions')
    <a href="{{ route('super_admin.permissions') }}" class="btn btn-outline-primary">
        <i class="bi bi-key"></i> View All Permissions
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Slug</th>
                        <th>Users</th>
                        <th>Permissions</th>
                        <th>Sample Permission Set</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td><code>{{ $role->slug }}</code></td>
                            <td>{{ $role->users_count }}</td>
                            <td>{{ $role->permissions_count }}</td>
                            <td>
                                @if($role->permissions->isNotEmpty())
                                    <small class="text-muted">
                                        {{ $role->permissions->take(4)->pluck('name')->implode(', ') }}{{ $role->permissions->count() > 4 ? '...' : '' }}
                                    </small>
                                @else
                                    <small class="text-muted">No permissions assigned</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No roles found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
