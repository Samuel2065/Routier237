@extends('admin.layout')

@section('active_nav', 'dashboard')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Welcome back, Super Admin')

@section('page_css')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid var(--admin-primary);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .badge-pending { background: #f59e0b; }
        .badge-approved { background: #10b981; }
        .badge-rejected { background: #ef4444; }
    </style>
@endsection

@section('page_actions')
    <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Create Company
    </a>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <p>Total Companies</p>
                    <h3>{{ $stats['total_companies'] }}</h3>
                    @if($stats['pending_companies'] > 0)
                        <small class="text-warning"><i class="bi bi-exclamation-circle"></i> {{ $stats['pending_companies'] }} pending</small>
                    @endif
                </div>
                <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-building" style="color: var(--admin-primary); font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <p>Active Agencies</p>
                    <h3>{{ $stats['active_agencies'] }}</h3>
                    @if($stats['pending_agencies'] > 0)
                        <small class="text-warning"><i class="bi bi-exclamation-circle"></i> {{ $stats['pending_agencies'] }} pending</small>
                    @endif
                </div>
                <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-shop" style="color: var(--admin-primary); font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <p>Total Users</p>
                    <h3>{{ $stats['total_users'] }}</h3>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="color: var(--admin-primary); font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    @if($pendingApprovals->count() > 0)
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle text-warning"></i> Pending Company Approvals</h5>
                <a href="{{ route('super_admin.companies') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Director</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingApprovals as $company)
                            <tr>
                                <td><strong>{{ $company->name }}</strong></td>
                                <td>{{ $company->director->full_name ?? 'N/A' }}</td>
                                <td>{{ $company->created_at->diffForHumans() }}</td>
                                <td>
                                    <form method="POST" action="{{ route('super_admin.companies.approve', $company->id) }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Approve this company?')">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $company->id }}">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="rejectModal{{ $company->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('super_admin.companies.reject', $company->id) }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject Company</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Rejection Reason</label>
                                                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Reject Company</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Recent Companies</h5>
            <a href="{{ route('super_admin.companies.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Create Company
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Director</th>
                        <th>Agencies</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentCompanies as $company)
                        <tr>
                            <td><strong>{{ $company->name }}</strong></td>
                            <td>{{ $company->director->full_name ?? 'N/A' }}</td>
                            <td>{{ $company->agencies->count() }}</td>
                            <td>
                                <span class="badge bg-{{ $company->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $company->approval_status }}">
                                    {{ ucfirst($company->approval_status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No companies yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
