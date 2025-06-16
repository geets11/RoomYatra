@extends('layouts.admin.admin')

@section('title', 'Properties Report')

@section('content')
<style>
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
    
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
    .status-pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .status-booked { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .status-available { background: linear-gradient(135deg, #fdbb2d 0%, #22c1c3 100%); color: white; }
    
    .price-tag {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .stats-card {
        border-radius: 20px;
        padding: 25px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .stats-card:hover { transform: translateY(-5px); }
    
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
                <h1 class="report-title">🏠 PROPERTIES REPORT</h1>
                <p class="report-subtitle">Comprehensive overview of all properties in the system</p>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['total'] }}</div>
                        <div>🏠 Total</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['active'] }}</div>
                        <div>✅ Active</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['pending'] }}</div>
                        <div>⏳ Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['rejected'] }}</div>
                        <div>❌ Rejected</div>
                    </div>
                </div>
            </div>

            <!-- Properties Table -->
            <div class="card table-modern">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">🆔 ID</th>
                                <th class="py-3 px-4">🏠 Title</th>
                                <th class="py-3 px-4">👤 Owner</th>
                                <th class="py-3 px-4">💰 Price</th>
                                <th class="py-3 px-4">📊 Status</th>
                                <th class="py-3 px-4">📅 Created</th>
                                <th class="py-3 px-4">⚡ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($properties as $property)
                            <tr>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-primary">#{{ $property->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ Str::limit($property->title, 30) }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-dark">{{ $property->user->name ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="price-tag">NPR {{ number_format($property->price, 0) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($property->status == 'active')
                                        <span class="status-badge status-active">✅ Active</span>
                                    @elseif($property->status == 'pending')
                                        <span class="status-badge status-pending">⏳ Pending</span>
                                    @elseif($property->status == 'booked')
                                        <span class="status-badge status-booked">🔵 Booked</span>
                                    @elseif($property->status == 'available')
                                        <span class="status-badge status-available">🟢 Available</span>
                                    @else
                                        <span class="status-badge" style="background: #6c757d; color: white;">{{ ucfirst($property->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ $property->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.properties.view', $property->id) }}" class="btn action-btn btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-home fa-3x mb-3"></i>
                                        <h5>No properties found</h5>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($properties->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $properties->appends(request()->query())->links() }}
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
