@extends('layouts.admin.admin')

@section('title', 'Users Report')

@section('content')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card-gradient-1 {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }
    
    .card-gradient-2 {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }
    
    .card-gradient-3 {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    }
    
    .card-gradient-4 {
        background: linear-gradient(135deg, #ff8a80 0%, #ea80fc 100%);
    }
    
    .table-modern {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .table-modern thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .table-modern tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }
    
    .table-modern tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .role-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .role-admin {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
    }
    
    .role-landlord {
        background: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
        color: white;
    }
    
    .role-tenant {
        background: linear-gradient(135deg, #00d2d3 0%, #54a0ff 100%);
        color: white;
    }
    
    .role-subadmin {
        background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%);
        color: white;
    }
    
    .status-active {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    
    .stats-card {
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }
    
    .filter-card {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .action-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .report-title {
        font-size: 3.5rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .report-subtitle {
        text-align: center;
        color: #6c757d;
        font-size: 1.2rem;
        margin-bottom: 40px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Centered Header -->
            <div class="text-center mb-5">
                <h1 class="report-title">👥 USERS REPORT</h1>
                <p class="report-subtitle">Comprehensive overview of all users in the system</p>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card card-gradient-1">
                        <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">{{ $stats['total'] }}</div>
                        <div style="font-size: 1rem; opacity: 0.9;">👥 Total Users</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-gradient-2">
                        <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">{{ $stats['active'] }}</div>
                        <div style="font-size: 1rem; opacity: 0.9;">✅ Active Users</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-gradient-3">
                        <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">{{ $stats['landlords'] }}</div>
                        <div style="font-size: 1rem; opacity: 0.9;">🏠 Landlords</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card card-gradient-4">
                        <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 10px;">{{ $stats['tenants'] }}</div>
                        <div style="font-size: 1rem; opacity: 0.9;">🏡 Tenants</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" class="d-flex align-items-center gap-3">
                    <div class="flex-grow-1">
                        <label class="form-label fw-bold text-dark">🔍 Filter by Role:</label>
                        <select name="role" class="form-select" style="border-radius: 10px; border: 2px solid #ddd;">
                            <option value="">🌟 All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>👑 Admin</option>
                            <option value="landlord" {{ request('role') == 'landlord' ? 'selected' : '' }}>🏠 Landlord</option>
                            <option value="tenant" {{ request('role') == 'tenant' ? 'selected' : '' }}>🏡 Tenant</option>
                            <option value="subadmin" {{ request('role') == 'subadmin' ? 'selected' : '' }}>⚡ Subadmin</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn action-btn me-2">
                            <i class="fas fa-filter me-1"></i> Apply Filter
                        </button>
                        <a href="{{ route('admin.reports.users') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="card table-modern">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">🆔 ID</th>
                                <th class="py-3 px-4">👤 User</th>
                                <th class="py-3 px-4">📧 Email</th>
                                <th class="py-3 px-4">📱 Phone</th>
                                <th class="py-3 px-4">🎭 Role</th>
                                <th class="py-3 px-4">📊 Status</th>
                                <th class="py-3 px-4">📅 Joined</th>
                                <th class="py-3 px-4">⚡ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-primary">#{{ $user->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-dark">{{ $user->email }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-muted">{{ $user->phone ?? 'Not provided' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $role = $user->roles->first()->name ?? 'user';
                                    @endphp
                                    <span class="role-badge role-{{ $role }}">
                                        @if($role == 'admin') 👑 Admin
                                        @elseif($role == 'landlord') 🏠 Landlord
                                        @elseif($role == 'tenant') 🏡 Tenant
                                        @elseif($role == 'subadmin') ⚡ Subadmin
                                        @else 👤 {{ ucfirst($role) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="status-active">✅ Active</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ $user->created_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn action-btn btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No users found</h5>
                                        <p>Try adjusting your filters or check back later.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
            @endif

            <!-- Back Button at Bottom -->
            <div class="text-center mt-5">
                <a href="{{ route('admin.reports.index') }}" class="btn action-btn btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Back to Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
