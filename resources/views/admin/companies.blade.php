@extends('admin.layout')

@section('active_nav', 'companies')

@section('title', 'Companies')
@section('page_title', 'Companies')
@section('page_subtitle', 'Dynamic company list and approval workflow')

@section('page_actions')
    <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Create Company
    </a>
@endsection

@section('content')
    <div class="content-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Director</th>
                        <th>Email</th>
                        <th>Agencies</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td><strong>{{ $company->name }}</strong></td>
                            <td>{{ $company->director->full_name ?? 'N/A' }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->agencies->count() }}</td>
                            <td><span class="badge bg-{{ $company->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($company->status) }}</span></td>
                            <td>
                                @php
                                    $approvalClass = $company->approval_status === 'approved' ? 'bg-success' : ($company->approval_status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark');
                                @endphp
                                <span class="badge {{ $approvalClass }}">{{ ucfirst($company->approval_status) }}</span>
                            </td>
                            <td>
                                @if($company->approval_status === 'pending')
                                    <form method="POST" action="{{ route('super_admin.companies.approve', $company->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Approve this company?')"><i class="bi bi-check-circle"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectCompanyModal{{ $company->id }}">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                @else
                                    <span class="text-muted small">No action</span>
                                @endif
                            </td>
                        </tr>

                        <div class="modal fade" id="rejectCompanyModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('super_admin.companies.reject', $company->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject {{ $company->name }}</h5>
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
                        <tr><td colspan="7" class="text-center text-muted py-4">No companies found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $companies->links() }}</div>
    </div>
@endsection
