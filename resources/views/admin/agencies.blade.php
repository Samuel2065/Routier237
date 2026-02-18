@extends('admin.layout')

@section('active_nav', 'agencies')

@section('title', 'All Agencies')
@section('page_title', 'All Agencies')
@section('page_subtitle', 'Dynamic agency approval queue')

@section('content')
    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Agency</th>
                        <th>Company</th>
                        <th>Manager</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agencies as $agency)
                        <tr>
                            <td>
                                <strong>{{ $agency->name }}</strong><br>
                                <small class="text-muted">{{ $agency->agency_code }}</small>
                            </td>
                            <td>{{ $agency->company->name ?? 'N/A' }}</td>
                            <td>{{ $agency->manager->full_name ?? 'Unassigned' }}</td>
                            <td>{{ ucfirst($agency->type) }}</td>
                            <td><span class="badge bg-{{ $agency->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($agency->status) }}</span></td>
                            <td>
                                @php
                                    $approvalClass = $agency->approval_status === 'approved' ? 'bg-success' : ($agency->approval_status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark');
                                @endphp
                                <span class="badge {{ $approvalClass }}">{{ ucfirst($agency->approval_status) }}</span>
                            </td>
                            <td>
                                @if($agency->approval_status === 'pending')
                                    <form method="POST" action="{{ route('super_admin.agencies.approve', $agency->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Approve this agency?')"><i class="bi bi-check-circle"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectAgencyModal{{ $agency->id }}"><i class="bi bi-x-circle"></i></button>
                                @else
                                    <span class="text-muted small">No action</span>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="rejectAgencyModal{{ $agency->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('super_admin.agencies.reject', $agency->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject {{ $agency->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label class="form-label">Rejection reason</label>
                                            <textarea class="form-control" name="rejection_reason" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No agencies found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $agencies->links() }}</div>
    </div>
@endsection
