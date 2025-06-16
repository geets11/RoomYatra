@extends('layouts.admin.admin')

@section('title', 'Revenue Report')

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
    
    .revenue-amount {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .month-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 12px;
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
                <h1 class="report-title">💰 REVENUE REPORT</h1>
                <p class="report-subtitle">Comprehensive financial performance overview</p>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">NPR {{ number_format($totalRevenue, 0) }}</div>
                        <div>💰 Total Revenue</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">NPR {{ $totalBookings }}</div>
                        <div>📅 Total Bookings</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div style="font-size: 2.5rem; font-weight: 700;">NPR {{ number_format($averageBookingValue, 0) }}</div>
                        <div>📊 Average Value</div>
                    </div>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="filter-card">
                <form method="GET" class="d-flex align-items-center gap-3">
                    <div>
                        <label class="form-label fw-bold text-dark">📅 From:</label>
                        <input type="date" name="start_date" class="form-control" style="border-radius: 10px;" value="{{ $startDate }}">
                    </div>
                    <div>
                        <label class="form-label fw-bold text-dark">📅 To:</label>
                        <input type="date" name="end_date" class="form-control" style="border-radius: 10px;" value="{{ $endDate }}">
                    </div>
                    <div style="margin-top: 32px;">
                        <button type="submit" class="btn action-btn me-2">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.revenue') }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                            <i class="fas fa-times me-1"></i> Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Monthly Revenue Table -->
            <div class="card table-modern">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4">📅 Month</th>
                                <th class="py-3 px-4">📊 Year</th>
                                <th class="py-3 px-4">📅 Bookings</th>
                                <th class="py-3 px-4">💰 Revenue</th>
                                <th class="py-3 px-4">📈 Average per Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyRevenue as $revenue)
                            <tr>
                                <td class="py-3 px-4">
                                    <span class="month-badge">{{ \Carbon\Carbon::create()->month($revenue->month)->format('F') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-dark">{{ $revenue->year }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="fw-bold text-primary">{{ $revenue->bookings_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="revenue-amount">NPR {{ number_format($revenue->revenue, 0) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-dark fw-bold">{{ $revenue->bookings_count > 0 ? number_format($revenue->revenue / $revenue->bookings_count, 0) : '0' }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                                        <h5>No revenue data found</h5>
                                        <p>No data available for the selected period</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

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
