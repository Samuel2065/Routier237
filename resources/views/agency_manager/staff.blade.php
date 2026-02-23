@extends('agency_manager.layout')

@section('active_nav', 'staff')
@section('title', 'Staff')
@section('page_title', 'Staff')
@section('page_subtitle', $agency->name ?? '')

@section('page_actions')
<a href="{{ route('agency_manager.staff.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-person-plus"></i> New Staff</a>
@endsection

@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Name</th><th>Role</th><th>Position</th><th>Employee #</th></tr></thead>
            <tbody>
                @forelse($staff as $employee)
                    <tr>
                        <td>{{ data_get($employee, 'user.full_name', $employee->first_name . ' ' . $employee->last_name) }}</td>
                        <td>{{ data_get($employee, 'user.role.name', '-') }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->employee_number }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No staff records.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $staff->links() }}</div>
</div>
@endsection
