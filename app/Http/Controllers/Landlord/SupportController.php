<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::where('user_id', Auth::id())
            ->with(['user', 'assignedTo']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $stats = [
            'total' => SupportTicket::where('user_id', Auth::id())->count(),
            'open' => SupportTicket::where('user_id', Auth::id())->where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('user_id', Auth::id())->where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('user_id', Auth::id())->where('status', 'resolved')->count(),
        ];

        return view('landlord.support.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        return view('landlord.support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        return redirect()->route('landlord.support.index')
            ->with('success', 'Support ticket created successfully.');
    }

    public function show(SupportTicket $ticket)
    {
        // Ensure landlord can only view their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['user', 'assignedTo']);
        
        return view('landlord.support.show', compact('ticket'));
    }

    public function edit(SupportTicket $ticket)
    {
        // Ensure landlord can only edit their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow editing if ticket is not resolved or closed
        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return redirect()->route('landlord.support.show', $ticket)
                ->with('error', 'Cannot edit resolved or closed tickets.');
        }

        return view('landlord.support.edit', compact('ticket'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        // Ensure landlord can only update their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        // Only allow updates if ticket is not resolved or closed
        if (in_array($ticket->status, ['resolved', 'closed'])) {
            return redirect()->back()->with('error', 'Cannot update resolved or closed tickets.');
        }

        $ticket->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return redirect()->route('landlord.support.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    public function cancel(SupportTicket $ticket)
    {
        // Ensure landlord can only cancel their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if ticket is open or in progress
        if (!in_array($ticket->status, ['open', 'in_progress'])) {
            return redirect()->back()->with('error', 'Cannot cancel this ticket.');
        }

        $ticket->update(['status' => 'closed']);

        return redirect()->route('landlord.support.index')
            ->with('success', 'Ticket cancelled successfully.');
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        // Ensure landlord can only reply to their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        // Add reply logic here (you might want to create a TicketReply model)
        // For now, we'll just redirect back with success

        return redirect()->route('landlord.support.show', $ticket)
            ->with('success', 'Reply added successfully.');
    }
}
