<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:subadmin']);
    }

    /**
     * Display a listing of support tickets.
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Date filter
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
        ];

        return view('subadmin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Display the specified support ticket.
     */
   public function show(SupportTicket $ticket)
    {
        $ticket->load('user', 'user.roles');
        $userTicketsCount = SupportTicket::where('user_id', $ticket->user_id)->count();
        return view('subadmin.support.show', compact('ticket', 'userTicketsCount'));
    }

    /**
     * Update support ticket status.
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'admin_response' => 'nullable|string',
        ]);

        $ticket->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Respond to support ticket.
     */
    public function respond(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $ticket->update([
            'admin_response' => $request->response,
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Response sent successfully.');
    }
}
