{{-- resources/views/admin/bookings/show.blade.php --}}

@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Booking Details</h2>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Bookings
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Booking Information -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Booking #{{ $booking->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : 
                                    ($booking->status == 'pending' ? 'warning' : 
                                    ($booking->status == 'rejected' ? 'danger' : 
                                    ($booking->status == 'completed' ? 'info' : 'secondary'))) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><strong>Check-in Date:</strong> {{ $booking->check_in->format('M d, Y') }}</p>
                            <p><strong>Check-out Date:</strong> {{ $booking->check_out->format('M d, Y') }}</p>
                            <p><strong>Number of Nights:</strong> {{ $booking->nights }}</p>
                            <p><strong>Number of Guests:</strong> {{ $booking->guests }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                            <p><strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $booking->is_paid ? 'success' : 'danger' }}">
                                    {{ $booking->is_paid ? 'Paid' : 'Unpaid' }}
                                </span>
                            </p>
                            <p><strong>Created At:</strong> {{ $booking->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Updated At:</strong> {{ $booking->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    @if($booking->special_requests)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Special Requests:</h6>
                            <p class="border p-3 bg-light">{{ $booking->special_requests }}</p>
                        </div>
                    </div>
                    @endif

                    @if($booking->status === 'rejected' && $booking->rejection_reason)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Rejection Reason:</h6>
                            <p class="border p-3 bg-light text-danger">{{ $booking->rejection_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="col-md-4">
            <!-- Property Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Property Information</h5>
                </div>
                <div class="card-body">
                    @if($booking->property)
                        <div class="mb-3">
                            @if($booking->property->primaryImage)
                                <img src="{{ asset('storage/' . $booking->property->primaryImage->image_path) }}" 
                                     class="img-fluid rounded mb-3" alt="{{ $booking->property->title }}">
                            @endif
                            <h6>{{ $booking->property->title }}</h6>
                            <p class="text-muted">
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $booking->property->address }}, {{ $booking->property->city }}, {{ $booking->property->state }}
                            </p>
                            <p><strong>Type:</strong> {{ $booking->property->propertyType->name ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> ${{ number_format($booking->property->price, 2) }} / {{ $booking->property->price_type }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($booking->property->status) }}</p>
                        </div>
                        <a href="{{ route('admin.properties.view', $booking->property->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> View Property
                        </a>
                    @else
                        <p class="text-muted">Property information not available</p>
                    @endif
                </div>
            </div>

            <!-- Tenant Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Tenant Information</h5>
                </div>
                <div class="card-body">
                    @if($booking->user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-text rounded-circle bg-primary">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $booking->user->name }}</h6>
                                <p class="text-muted mb-0">{{ $booking->user->email }}</p>
                            </div>
                        </div>
                        <p><strong>Phone:</strong> {{ $booking->user->phone ?? 'N/A' }}</p>
                        <p><strong>Member Since:</strong> {{ $booking->user->created_at->format('M Y') }}</p>
                        <a href="{{ route('admin.users.show', $booking->user->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user"></i> View Tenant Profile
                        </a>
                    @else
                        <p class="text-muted">Tenant information not available</p>
                    @endif
                </div>
            </div>

            <!-- Landlord Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Landlord Information</h5>
                </div>
                <div class="card-body">
                    @if($booking->property && $booking->property->user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar me-3">
                                <span class="avatar-text rounded-circle bg-success">
                                    {{ substr($booking->property->user->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $booking->property->user->name }}</h6>
                                <p class="text-muted mb-0">{{ $booking->property->user->email }}</p>
                            </div>
                        </div>
                        <p><strong>Phone:</strong> {{ $booking->property->user->phone ?? 'N/A' }}</p>
                        <a href="{{ route('admin.users.show', $booking->property->user->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user"></i> View Landlord Profile
                        </a>
                    @else
                        <p class="text-muted">Landlord information not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Information (if exists) -->
    @if($booking->review)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Review</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-success p-2">{{ $booking->review->rating }} <i class="fas fa-star"></i></span>
                        </div>
                        <div>
                            <h6>{{ $booking->review->title }}</h6>
                            <p class="text-muted mb-0">Posted on {{ $booking->review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <p>{{ $booking->review->comment }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Booking Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="mb-3 rejection-reason" style="{{ $booking->status == 'rejected' ? '' : 'display: none;' }}">
                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3">{{ $booking->rejection_reason }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide rejection reason based on status
        const statusSelect = document.getElementById('status');
        const rejectionReason = document.querySelector('.rejection-reason');
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'rejected') {
                rejectionReason.style.display = 'block';
            } else {
                rejectionReason.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection
