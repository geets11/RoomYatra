<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Key metrics
        $totalUsers = User::count();
        $totalProperties = Property::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('bookings.status', 'completed')
            ->join('properties', 'bookings.property_id', '=', 'properties.id')
            ->sum('properties.price');

        // Growth calculations
        $lastMonthUsers = User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $thisMonthUsers = User::whereMonth('created_at', Carbon::now()->month)->count();
        $userGrowth = $lastMonthUsers > 0 ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;

        $lastMonthProperties = Property::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $thisMonthProperties = Property::whereMonth('created_at', Carbon::now()->month)->count();
        $propertyGrowth = $lastMonthProperties > 0 ? round((($thisMonthProperties - $lastMonthProperties) / $lastMonthProperties) * 100, 1) : 0;

        $lastMonthBookings = Booking::whereMonth('bookings.created_at', Carbon::now()->subMonth()->month)->count();
        $thisMonthBookings = Booking::whereMonth('bookings.created_at', Carbon::now()->month)->count();
        $bookingGrowth = $lastMonthBookings > 0 ? round((($thisMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 1) : 0;

        // Additional metrics
        $activeUsers = User::count();
        $pendingProperties = Property::where('status', 'pending')->count();
        $monthlyBookings = Booking::whereMonth('bookings.created_at', Carbon::now()->month)->count();
        $openTickets = SupportTicket::where('status', 'open')->count();

        // Recent data
        $recentUsers = User::with('roles')->latest()->take(5)->get();
        $recentProperties = Property::with('user')->latest()->take(5)->get();
        $recentBookings = Booking::with(['user', 'property'])->latest()->take(5)->get();

        // Chart data for the last 7 days
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartData[] = [
                'date' => $date->format('M d'),
                'users' => User::whereDate('created_at', $date)->count(),
                'properties' => Property::whereDate('created_at', $date)->count(),
                'bookings' => Booking::whereDate('bookings.created_at', $date)->count(),
            ];
        }

        return view('admin.reports', compact(
            'totalUsers', 'totalProperties', 'totalBookings', 'totalRevenue',
            'userGrowth', 'propertyGrowth', 'bookingGrowth',
            'activeUsers', 'pendingProperties', 'monthlyBookings', 'openTickets',
            'recentUsers', 'recentProperties', 'recentBookings',
            'chartData', 'startDate', 'endDate'
        ));
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        // Generate report data
        $data = [
            'users' => User::with('roles')->get(),
            'properties' => Property::with('user')->get(),
            'bookings' => Booking::with(['user', 'property'])->get(),
        ];

        switch ($format) {
            case 'pdf':
                return $this->exportToPdf($data);
            case 'excel':
                return $this->exportToExcel($data);
            default:
                return $this->exportToCsv($data);
        }
    }

    public function usersReport(Request $request)
    {
        $users = User::with('roles')
            ->when($request->role, function ($query, $role) {
                return $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->paginate(20);

        $stats = [
            'total' => User::count(),
            'active' => User::count(),
            'landlords' => User::whereHas('roles', function ($q) {
                $q->where('name', 'landlord');
            })->count(),
            'tenants' => User::whereHas('roles', function ($q) {
                $q->where('name', 'tenant');
            })->count(),
        ];

        return view('admin.reports.users', compact('users', 'stats'));
    }

    public function propertiesReport(Request $request)
    {
        $properties = Property::with(['user', 'propertyType'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->type, function ($query, $type) {
                return $query->where('property_type_id', $type);
            })
            ->paginate(20);

        $stats = [
            'total' => Property::count(),
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'rejected' => Property::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.properties', compact('properties', 'stats'));
    }

    public function bookingsReport(Request $request)
    {
        $bookings = Booking::with(['user', 'property'])
            ->when($request->status, function ($query, $status) {
                return $query->where('bookings.status', $status);
            })
            ->when($request->start_date, function ($query, $date) {
                return $query->whereDate('bookings.created_at', '>=', $date);
            })
            ->when($request->end_date, function ($query, $date) {
                return $query->whereDate('bookings.created_at', '<=', $date);
            })
            ->paginate(20);

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.reports.bookings', compact('bookings', 'stats'));
    }

    public function revenueReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfYear());
        $endDate = $request->get('end_date', Carbon::now());

        $monthlyRevenue = Booking::where('bookings.status', 'completed')
            ->join('properties', 'bookings.property_id', '=', 'properties.id')
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('YEAR(bookings.created_at) as year'),
                DB::raw('MONTH(bookings.created_at) as month'),
                DB::raw('SUM(properties.price) as revenue'),
                DB::raw('COUNT(*) as bookings_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $totalRevenue = $monthlyRevenue->sum('revenue');
        $totalBookings = $monthlyRevenue->sum('bookings_count');
        $averageBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        return view('admin.reports.revenue', compact(
            'monthlyRevenue', 'totalRevenue', 'totalBookings', 
            'averageBookingValue', 'startDate', 'endDate'
        ));
    }

    private function exportToCsv($data)
    {
        $filename = 'admin_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Users CSV
            fputcsv($file, ['Users Report']);
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Status', 'Created At']);
            foreach ($data['users'] as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->roles->first()->name ?? 'N/A',
                    'active', // Default status since users table doesn't have status column
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fputcsv($file, []); // Empty row
            
            // Properties CSV
            fputcsv($file, ['Properties Report']);
            fputcsv($file, ['ID', 'Title', 'Owner', 'Price', 'Status', 'Created At']);
            foreach ($data['properties'] as $property) {
                fputcsv($file, [
                    $property->id,
                    $property->title,
                    $property->user->name ?? 'N/A',
                    $property->price,
                    $property->status,
                    $property->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToPdf($data)
    {
        // For PDF export, you would typically use a library like DomPDF
        // This is a placeholder implementation
        return response()->json(['message' => 'PDF export feature coming soon']);
    }

    private function exportToExcel($data)
    {
        // For Excel export, you would typically use a library like PhpSpreadsheet
        // This is a placeholder implementation
        return response()->json(['message' => 'Excel export feature coming soon']);
    }
}
