<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountant Dashboard - Routier+237</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #8b5cf6;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border-left: 4px solid var(--primary-color);
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .content-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
        }

        .transaction-row {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .transaction-row:hover {
            background: #f9fafb;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-calculator"></i> Routier+237</h4>
            <small class="text-white-50">Accountant Panel</small>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-receipt"></i>
                    <span>Transactions</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-cash-coin"></i>
                    <span>Cash Registers</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-wallet2"></i>
                    <span>Expenses</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-graph-up"></i>
                    <span>Financial Reports</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Revenue Analysis</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-bank"></i>
                    <span>Banking</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Tax Reports</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Financial Dashboard</h2>
                    <small class="text-muted">Express Voyages - Accounting</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Accountant
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Today's Revenue</p>
                        <h3>2.4M XAF</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 18% vs yesterday</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cash-stack" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Expenses</p>
                        <h3>480K XAF</h3>
                        <small class="text-danger"><i class="bi bi-arrow-down"></i> Today</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-wallet2" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Net Profit</p>
                        <h3>1.92M XAF</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 22% margin</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-graph-up" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Pending Validation</p>
                        <h3>12</h3>
                        <small class="text-warning"><i class="bi bi-exclamation-triangle"></i> Requires attention</small>
                    </div>
                    <div style="width: 48px; height: 48px; background: rgba(139, 92, 246, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-clipboard-check" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash Register Status -->
        <div class="content-card">
            <h5 class="mb-3">Active Cash Registers</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Agency</th>
                            <th>Clerk</th>
                            <th>Opened At</th>
                            <th>Initial Amount</th>
                            <th>Current Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Yaoundé Main</strong></td>
                            <td>Jean Dupont</td>
                            <td>08:00 AM</td>
                            <td>50,000 XAF</td>
                            <td>325,000 XAF</td>
                            <td><span class="badge bg-success">Open</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Douala Branch</strong></td>
                            <td>Marie Nkosi</td>
                            <td>07:30 AM</td>
                            <td>50,000 XAF</td>
                            <td>485,000 XAF</td>
                            <td><span class="badge bg-success">Open</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Transactions</h5>
                <button class="btn btn-primary btn-sm">View All</button>
            </div>
            <div>
                <div class="transaction-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Ticket Sale #TK-20250126-001</strong>
                            <div class="small text-muted">Yaoundé → Douala • Jean Dupont</div>
                        </div>
                        <div class="text-end">
                            <div class="text-success fw-bold">+15,000 XAF</div>
                            <div class="small text-muted">10:30 AM</div>
                        </div>
                    </div>
                </div>
                
                <div class="transaction-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Fuel Expense</strong>
                            <div class="small text-muted">Bus 001 • Pending Validation</div>
                        </div>
                        <div class="text-end">
                            <div class="text-danger fw-bold">-45,000 XAF</div>
                            <div class="small text-muted">09:15 AM</div>
                        </div>
                    </div>
                </div>
                
                <div class="transaction-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Ticket Sale #TK-20250126-002</strong>
                            <div class="small text-muted">Douala → Bamenda • Marie Nkosi</div>
                        </div>
                        <div class="text-end">
                            <div class="text-success fw-bold">+18,000 XAF</div>
                            <div class="small text-muted">08:45 AM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Expenses -->
        <div class="content-card">
            <h5 class="mb-3"><i class="bi bi-exclamation-triangle text-warning"></i> Pending Expense Validations</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Expense</th>
                            <th>Agency</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fuel - Bus 001</td>
                            <td>Yaoundé Main</td>
                            <td>45,000 XAF</td>
                            <td>Today, 09:15 AM</td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i> Approve</button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i> Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Maintenance - Bus 003</td>
                            <td>Douala Branch</td>
                            <td>125,000 XAF</td>
                            <td>Yesterday, 4:30 PM</td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i> Approve</button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i> Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>