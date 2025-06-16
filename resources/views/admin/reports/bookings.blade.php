@extends('layouts.admin.admin')

@section('title', 'Bookings Report')

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
    
    .status-pending { background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%); color: white; }
    .status-confirmed { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
    .status-completed { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .status-cancelled { background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%); color: white; }
    
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
    
    .action-btn:hover { transform: translateY(-2px); color: white; }
    
    .filter-card {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
                <h1 class="report-title">📅 BOOKINGS REPORT</h1>
                <p class="report-subtitle">Comprehensive overview of all bookings in the system</p>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['total'] }}</div>
                        <div>📅 Total</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #ff9ff3 0%, #f368e0 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['pending'] }}</div>
                        <div>⏳ Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['confirmed'] }}</div>
                        <div>✅ Confirmed</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">{{ $stats['completed'] }}</div>
                        <div>🎉 Completed</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-card">
                <form method="GET" class="d-flex align-items-center gap-3">
                    <div>
                        <label class="form-label fw-bold text-dark">📊 Status:</label>
                        <select name="status" class="form-select" style="border-radius: 10px;">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>🎉 Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-bold text-dark">📅 From:</label>
                        <input type="date" name="start_date" class="form-control" style="border-radius: 10px;" value="{{ request('start_date') }}">
                    </div>
                    <div>
                        <label class="form-label fw-bold text-dark">📅 To:</label>
                        <input type="date" name="end_date" class="form-control" style="border-radius: 10px;" value="{{ request('end_date') }}">
                    </div>
                    <div style="margin-top: 32px;">
                        <button type="submit" class="btn action-btn me-2">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.bookings') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bookings Table -->
            <div class="card table-modern">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">🆔 ID</th>
                                <th class="py-3 px-4">🏠 Property</th>
                                <th class="py-3 px-4">👤 Tenant</th>
                                <th class="py-3 px-4">📅 Check-in</th>
                                <th class="py-3 px-4">📅 Check-out</th>
                                <th class="py-3 px-4">📊 Status</th>
                                <th class="py-3 px-4">📅 Created</th>
                                <th class="py-3 px-4">⚡ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-primary">#{{ $booking->id }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ Str::limit($booking->property->title ?? 'N/A', 25) }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 10px;">
                                            {{ substr($booking->user->name ?? 'N', 0, 1) }}
                                        </div>
                                        <span class="text-dark">{{ $booking->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-dark">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') : 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-dark">{{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') : 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($booking->status == 'pending')
                                        <span class="status-badge status-pending">⏳ Pending</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="status-badge status-confirmed">✅ Confirmed</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="status-badge status-completed">🎉 Completed</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="status-badge status-cancelled">❌ Cancelled</span>
                                    @else
                                        <span class="status-badge" style="background: #6c757d; color: white;">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-bold text-dark">{{ $booking->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn action-btn btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar fa-3x mb-3"></i>
                                        <h5>No bookings found</h5>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($bookings->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(request()->query())->links() }}
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
