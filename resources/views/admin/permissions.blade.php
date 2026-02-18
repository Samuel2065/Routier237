@extends('admin.layout')

@section('active_nav', 'permissions')

@section('title', 'Permissions')
@section('page_title', 'Permissions')
@section('page_subtitle', 'Dynamic permission catalog and role coverage')

@section('page_actions')
    <a href="{{ route('super_admin.roles') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Roles
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Permission</th>
                        <th>Module</th>
                        <th>Action</th>
                        <th>Assigned Roles</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td><code>{{ $permission->name }}</code></td>
                            <td>{{ ucfirst($permission->module) }}</td>
                            <td>{{ $permission->action }}</td>
                            <td><span class="badge bg-primary">{{ $permission->roles_count }}</span></td>
                            <td>{{ $permission->description ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No permissions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $permissions->links() }}</div>
    </div>
@endsection
