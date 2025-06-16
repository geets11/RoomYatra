@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid p-4" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    
    <!-- Much Bigger and Bolder Title -->
    <div class="text-center mb-4">
        <h1 class="display-2 fw-black text-dark mb-3" style="font-size: 4rem; font-weight: 900; letter-spacing: -2px;">
            <i class="fas fa-calendar-check me-3 text-primary"></i>
            BOOKING MANAGEMENT
        </h1>
        <p class="text-muted fs-5 mb-3">Manage all property bookings efficiently</p>
        <span class="badge bg-light text-dark px-3 py-2 fs-6 border">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            {{ $bookings->total() }} of {{ $totalBookings }} bookings
        </span>
    </div>

    <!-- Much Smaller Statistics Cards with Soft Colors -->
    <div class="row mb-4 justify-content-center">
        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-3">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="card-body text-center py-2 px-2">
                            <i class="fas fa-clock text-info mb-1"></i>
                            <h6 class="fw-bold mb-0 text-dark">{{ $bookings->where('status', 'pending')->count() }}</h6>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                        <div class="card-body text-center py-2 px-2">
                            <i class="fas fa-check-circle text-success mb-1"></i>
                            <h6 class="fw-bold mb-0 text-dark">{{ $bookings->where('status', 'approved')->count() }}</h6>
                            <small class="text-muted">Approved</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);">
                        <div class="card-body text-center py-2 px-2">
                            <i class="fas fa-times-circle text-danger mb-1"></i>
                            <h6 class="fw-bold mb-0 text-dark">{{ $bookings->where('status', 'rejected')->count() }}</h6>
                            <small class="text-muted">Rejected</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fff3e0 0%, #ffcc80 100%);">
                        <div class="card-body text-center py-2 px-2">
                            <i class="fas fa-star text-warning mb-1"></i>
                            <h6 class="fw-bold mb-0 text-dark">{{ $bookings->where('status', 'completed')->count() }}</h6>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Filters -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm" style="background: rgba(255, 255, 255, 0.9);">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="fas fa-bookmark me-1"></i>Booking Status
                            </label>
                            <select name="booking_status" class="form-select">
                                <option value="">All Statuses</option>
                                @foreach($bookingStatuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('booking_status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="fas fa-home me-1"></i>Property Status
                            </label>
                            <select name="property_status" class="form-select">
                                <option value="">All Statuses</option>
                                @foreach($propertyStatuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('property_status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="fas fa-building me-1"></i>Property
                            </label>
                            <select name="property_id" class="form-select">
                                <option value="">All Properties</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="alert alert-success alert-dismissible fade show border-0" role="alert" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="alert alert-danger alert-dismissible fade show border-0" role="alert" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Compact Bookings Table -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow" style="background: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                            <thead style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                                <tr>
                                    <th class="text-white fw-bold py-3 px-3 border-0">ID</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Property</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Tenant</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Check-in</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Check-out</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Booking Status</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Property Status</th>
                                    <th class="text-white fw-bold py-3 px-3 border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr class="booking-row align-middle">
                                        <td class="px-3 py-3">
                                            <span class="badge bg-light text-primary border px-2 py-1">#{{ $booking->id }}</span>
                                        </td>
                                        <td class="px-3 py-3">
                                            @if($booking->property)
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $booking->property->title }}</div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ $booking->property->city ?? 'Unknown' }}
                                                    </small>
                                                </div>
                                            @else
                                                <span class="text-danger">Property Deleted</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if($booking->user)
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $booking->user->name }}</div>
                                                    <small class="text-muted">{{ $booking->user->email }}</small>
                                                </div>
                                            @else
                                                <span class="text-danger">User Deleted</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if($booking->check_in)
                                                <div class="text-center">
                                                    <div class="fw-bold text-primary">{{ $booking->check_in->format('M d') }}</div>
                                                    <small class="text-muted">{{ $booking->check_in->format('Y') }}</small>
                                                </div>
                                            @else
                                                <small class="text-muted">Not set</small>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            @if($booking->check_out)
                                                <div class="text-center">
                                                    <div class="fw-bold text-danger">{{ $booking->check_out->format('M d') }}</div>
                                                    <small class="text-muted">{{ $booking->check_out->format('Y') }}</small>
                                                </div>
                                            @else
                                                <small class="text-muted">Not set</small>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            <select class="form-select form-select-sm status-select" 
                                                    data-booking-id="{{ $booking->id }}" 
                                                    data-original-value="{{ $booking->status }}"
                                                    style="min-width: 120px;">
                                                @foreach($bookingStatuses as $value => $label)
                                                    <option value="{{ $value }}" {{ $booking->status == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-3 py-3">
                                            @if($booking->property)
                                                <select class="form-select form-select-sm property-status-select" 
                                                        data-booking-id="{{ $booking->id }}"
                                                        data-original-value="{{ $booking->property->status }}"
                                                        style="min-width: 120px;">
                                                    @foreach($propertyStatuses as $value => $label)
                                                        <option value="{{ $value }}" {{ $booking->property->status == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <small class="text-muted">N/A</small>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm save-changes" 
                                                        data-booking-id="{{ $booking->id }}" 
                                                        style="display: none;"
                                                        title="Save Changes">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary btn-sm reset-changes" 
                                                        data-booking-id="{{ $booking->id }}" 
                                                        style="display: none;"
                                                        title="Reset Changes">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                                                <h6>No bookings found</h6>
                                                <p>Try adjusting your filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($bookings->hasPages())
                    <div class="card-footer bg-transparent border-0 py-3">
                        <div class="d-flex justify-content-center">
                            {{ $bookings->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .booking-row:hover {
        background: rgba(108, 117, 125, 0.1) !important;
        transition: all 0.3s ease;
    }
    
    .status-select, .property-status-select {
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .status-select:focus, .property-status-select:focus {
        border-color: #6c757d;
        box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
    }
    
    .status-select.changed, .property-status-select.changed {
        border-color: #ffc107;
        background-color: #fff3cd;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .table th {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .form-select-sm {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }
    
    .badge {
        font-size: 0.8rem;
    }
    
    /* Custom font weight for the main title */
    .fw-black {
        font-weight: 900 !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle inline status changes with action buttons
    document.querySelectorAll('.status-select, .property-status-select').forEach(select => {
        select.addEventListener('change', function() {
            const bookingId = this.dataset.bookingId;
            const originalValue = this.dataset.originalValue;
            const row = this.closest('tr');
            const saveButton = row.querySelector(`.save-changes[data-booking-id="${bookingId}"]`);
            const resetButton = row.querySelector(`.reset-changes[data-booking-id="${bookingId}"]`);
            
            // Check if any select in this row has changed
            const statusSelect = row.querySelector('.status-select');
            const propertyStatusSelect = row.querySelector('.property-status-select');
            
            let hasChanges = false;
            
            if (statusSelect && statusSelect.value !== statusSelect.dataset.originalValue) {
                hasChanges = true;
                statusSelect.classList.add('changed');
            } else if (statusSelect) {
                statusSelect.classList.remove('changed');
            }
            
            if (propertyStatusSelect && propertyStatusSelect.value !== propertyStatusSelect.dataset.originalValue) {
                hasChanges = true;
                propertyStatusSelect.classList.add('changed');
            } else if (propertyStatusSelect) {
                propertyStatusSelect.classList.remove('changed');
            }
            
            if (hasChanges) {
                saveButton.style.display = 'inline-block';
                resetButton.style.display = 'inline-block';
            } else {
                saveButton.style.display = 'none';
                resetButton.style.display = 'none';
            }
        });
    });
    
    // Handle save changes
    document.querySelectorAll('.save-changes').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            const row = this.closest('tr');
            const statusSelect = row.querySelector('.status-select');
            const propertyStatusSelect = row.querySelector('.property-status-select');
            
            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ route('admin.bookings.update-status', '') }}/${bookingId}`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Add status
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = statusSelect.value;
            form.appendChild(statusInput);
            
            // Add property status if exists
            if (propertyStatusSelect) {
                const propertyStatusInput = document.createElement('input');
                propertyStatusInput.type = 'hidden';
                propertyStatusInput.name = 'property_status';
                propertyStatusInput.value = propertyStatusSelect.value;
                form.appendChild(propertyStatusInput);
            }
            
            document.body.appendChild(form);
            form.submit();
        });
    });
    
    // Handle reset changes
    document.querySelectorAll('.reset-changes').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            const row = this.closest('tr');
            const statusSelect = row.querySelector('.status-select');
            const propertyStatusSelect = row.querySelector('.property-status-select');
            
            // Reset to original values
            if (statusSelect) {
                statusSelect.value = statusSelect.dataset.originalValue;
                statusSelect.classList.remove('changed');
            }
            
            if (propertyStatusSelect) {
                propertyStatusSelect.value = propertyStatusSelect.dataset.originalValue;
                propertyStatusSelect.classList.remove('changed');
            }
            
            // Hide action buttons
            this.style.display = 'none';
            row.querySelector(`.save-changes[data-booking-id="${bookingId}"]`).style.display = 'none';
        });
    });
});
</script>
@endpush
@endsection
