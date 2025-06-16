<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:subadmin']);
    }

    /**
     * Display reports and analytics.
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $reportType = $request->get('report_type', 'overview');

        // Validate dates
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $data = [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'report_type' => $reportType,
        ];

        // Get overview statistics
        $data['overview'] = [
            'total_users' => User::count(),
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_properties' => Property::count(),
            'new_properties' => Property::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_bookings' => Booking::count(),
            'new_bookings' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_revenue' => Booking::where('status', 'completed')->sum('total_price'),
            'period_revenue' => Booking::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_price'),
        ];

        // Get user statistics by role
        $data['user_stats'] = [
            'admins' => User::role('admin')->count(),
            'subadmins' => User::role('subadmin')->count(),
            'landlords' => User::role('landlord')->count(),
            'tenants' => User::role('tenant')->count(),
        ];

        // Get property statistics by status
        $data['property_stats'] = [
            'active' => Property::where('status', 'active')->count(),
            'pending' => Property::where('status', 'pending')->count(),
            'inactive' => Property::where('status', 'inactive')->count(),
        ];

        // Get booking statistics by status
        $data['booking_stats'] = [
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
        ];

        // Get support ticket statistics
        $data['support_stats'] = [
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
        ];

        // Get daily statistics for the period
        $data['daily_stats'] = $this->getDailyStats($startDate, $endDate);

        return view('subadmin.reports.index', $data);
    }

    /**
     * Get daily statistics for charts.
     */
    private function getDailyStats($startDate, $endDate)
    {
        $stats = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $stats[] = [
                'date' => $current->format('Y-m-d'),
                'users' => User::whereDate('created_at', $current)->count(),
                'properties' => Property::whereDate('created_at', $current)->count(),
                'bookings' => Booking::whereDate('created_at', $current)->count(),
                'revenue' => Booking::where('status', 'completed')
                    ->whereDate('created_at', $current)
                    ->sum('total_price'),
            ];
            $current->addDay();
        }

        return $stats;
    }

    /**
     * Export report as CSV.
     */
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $reportType = $request->get('report_type', 'overview');

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $filename = "report_{$reportType}_{$startDate->format('Y-m-d')}_to_{$endDate->format('Y-m-d')}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($reportType, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            switch ($reportType) {
                case 'users':
                    fputcsv($file, ['Name', 'Email', 'Role', 'Phone', 'Joined', 'Status']);
                    User::with('roles')->whereBetween('created_at', [$startDate, $endDate])
                        ->chunk(100, function($users) use ($file) {
                            foreach ($users as $user) {
                                fputcsv($file, [
                                    $user->name,
                                    $user->email,
                                    $user->roles->pluck('name')->implode(', '),
                                    $user->phone,
                                    $user->created_at->format('Y-m-d H:i:s'),
                                    $user->email_verified_at ? 'Active' : 'Inactive'
                                ]);
                            }
                        });
                    break;

                case 'properties':
                    fputcsv($file, ['Title', 'Owner', 'City', 'State', 'Price', 'Status', 'Created']);
                    Property::with('user')->whereBetween('created_at', [$startDate, $endDate])
                        ->chunk(100, function($properties) use ($file) {
                            foreach ($properties as $property) {
                                fputcsv($file, [
                                    $property->title,
                                    $property->user->name,
                                    $property->city,
                                    $property->state,
                                    $property->price,
                                    $property->status,
                                    $property->created_at->format('Y-m-d H:i:s')
                                ]);
                            }
                        });
                    break;

                case 'bookings':
                    fputcsv($file, ['Booking ID', 'Guest', 'Property', 'Check-in', 'Check-out', 'Amount', 'Status', 'Created']);
                    Booking::with(['user', 'property'])->whereBetween('created_at', [$startDate, $endDate])
                        ->chunk(100, function($bookings) use ($file) {
                            foreach ($bookings as $booking) {
                                fputcsv($file, [
                                    $booking->id,
                                    $booking->user->name,
                                    $booking->property->title,
                                    $booking->check_in,
                                    $booking->check_out,
                                    $booking->total_price,
                                    $booking->status,
                                    $booking->created_at->format('Y-m-d H:i:s')
                                ]);
                            }
                        });
                    break;

                default:
                    fputcsv($file, ['Metric', 'Value']);
                    fputcsv($file, ['Total Users', User::count()]);
                    fputcsv($file, ['New Users (Period)', User::whereBetween('created_at', [$startDate, $endDate])->count()]);
                    fputcsv($file, ['Total Properties', Property::count()]);
                    fputcsv($file, ['New Properties (Period)', Property::whereBetween('created_at', [$startDate, $endDate])->count()]);
                    fputcsv($file, ['Total Bookings', Booking::count()]);
                    fputcsv($file, ['New Bookings (Period)', Booking::whereBetween('created_at', [$startDate, $endDate])->count()]);
                    fputcsv($file, ['Total Revenue', Booking::where('status', 'completed')->sum('total_price')]);
                    fputcsv($file, ['Period Revenue', Booking::where('status', 'completed')->whereBetween('created_at', [$startDate, $endDate])->sum('total_price')]);
                    break;
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
