@extends('layouts.subadmin.subadmin')

@section('title', 'Property Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Property Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('subadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subadmin.properties.index') }}">Properties</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($property->title, 30) }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('subadmin.properties.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Properties
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Property Information -->
        <div class="col-lg-8">
            <!-- Property Images -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Images</h6>
                </div>
                <div class="card-body">
                    @if($property->images->count() > 0)
                        <div class="row">
                            @foreach($property->images->take(6) as $image)
                                <div class="col-md-4 mb-3">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $property->title }}" 
                                         class="img-fluid rounded shadow-sm">
                                </div>
                            @endforeach
                        </div>
                        @if($property->images->count() > 6)
                            <p class="text-muted">+ {{ $property->images->count() - 6 }} more images</p>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <img src="/placeholder.svg?height=200&width=300&text=No+Images" 
                                 alt="No Images" 
                                 class="img-fluid rounded">
                            <p class="text-muted mt-2">No images uploaded for this property</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Property Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">{{ $property->title }}</h5>
                            <p class="text-muted mb-3">
                                <i class="fas fa-map-marker-alt"></i> 
                                {{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}
                            </p>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Property Type:</strong></td>
                                    <td>{{ $property->propertyType->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bedrooms:</strong></td>
                                    <td>{{ $property->bedrooms }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bathrooms:</strong></td>
                                    <td>{{ $property->bathrooms }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Square Feet:</strong></td>
                                    <td>{{ number_format($property->square_feet ?? 0) }} sq ft</td>
                                </tr>
                                <tr>
                                    <td><strong>Max Guests:</strong></td>
                                    <td>{{ $property->max_guests ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ 
                                                $property->status === 'active' || $property->status === 'available' ? 'success' : 
                                                ($property->status === 'pending' ? 'warning' : 
                                                ($property->status === 'booked' ? 'info' : 
                                                ($property->status === 'undermaintenance' ? 'danger' : 'secondary'))) 
                                            }}">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Listed On:</strong></td>
                                        <td>{{ $property->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Last Updated:</strong></td>
                                        <td>{{ $property->updated_at->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($property->description)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Description</h6>
                            <p class="text-muted">{{ $property->description }}</p>
                        </div>
                    @endif

                    @if($property->amenities->count() > 0)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Amenities</h6>
                            <div class="row">
                                @foreach($property->amenities as $amenity)
                                    <div class="col-md-4 mb-2">
                                        <span class="badge badge-light">
                                            <i class="fas fa-check text-success"></i> {{ $amenity->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($property->admin_notes)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Admin Notes</h6>
                            <div class="alert alert-info">{{ $property->admin_notes }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Landlord Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Landlord Information</h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="/placeholder.svg?height=80&width=80&text={{ substr($property->user->name, 0, 1) }}" 
                                 alt="{{ $property->user->name }}" 
                                 class="rounded-circle">
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">{{ $property->user->name }}</h6>
                            <p class="text-muted mb-1">{{ $property->user->email }}</p>
                            <p class="text-muted mb-1">{{ $property->user->phone ?? 'Phone not provided' }}</p>
                            <small class="text-muted">Member since {{ $property->user->created_at->format('M Y') }}</small>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('subadmin.users.show', $property->user) }}" class="btn btn-outline-primary">
                                <i class="fas fa-user"></i> View Profile
                            </a>
                            <a href="mailto:{{ $property->user->email }}" class="btn btn-outline-secondary">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            @if($property->bookings->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Bookings</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Check-in</th>
                                      
                                       
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($property->bookings->take(5) as $booking)
                                        <tr>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                           
                                            <td>
                                                <span class="badge badge-{{ $booking->status === 'approved' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('subadmin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Status Management -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('subadmin.properties.update-status', $property) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="inactive" {{ $property->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="available" {{ $property->status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="booked" {{ $property->status === 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="undermaintenance" {{ $property->status === 'undermaintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                                      placeholder="Add notes about this status change...">{{ $property->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($property->status === 'pending')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subadmin.properties.approve', $property) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Approve Property
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Property
                        </button>
                    </div>
                </div>
            @endif

            <!-- Property Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h4 class="text-primary">{{ $property->bookings->count() }}</h4>
                                <small class="text-muted">Total Bookings</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">NPR {{ number_format($property->bookings->where('status', 'completed')->sum('total_price'), 0) }}</h4>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="text-info">{{ $property->bookings->where('status', 'approved')->count() }}</h5>
                            <small class="text-muted">Active Bookings</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning">{{ $property->bookings->where('status', 'pending')->count() }}</h5>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Property</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('subadmin.properties.reject', $property) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason</label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" 
                                  placeholder="Please provide a reason for rejecting this property..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Property</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
