<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:subadmin']);
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive');
            }
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
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $users = $query->with('roles')->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'tenants' => User::role('tenant')->count(),
            'landlords' => User::role('landlord')->count(),
            'admins' => User::role(['admin', 'subadmin'])->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // Get roles for filter
        $roles = Role::all();

        return view('subadmin.users.index', compact('users', 'stats', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('subadmin.users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'password' => 'required|string|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(), // Auto-verify admin created users
            'status' => 'active',
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Assign permissions if user is subadmin
        if ($request->role === 'subadmin' && $request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        return redirect()->route('subadmin.users.index')
                    ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['roles', 'properties', 'bookings.property']);
        
        // Get bookings for the user
        $bookings = $user->bookings ?? collect();
        
        // Get properties for landlords
        $properties = $user->properties ?? collect();
        
        // Get reviews for the user - handle different review types
        $reviews = collect();
        
        if ($user->hasRole('tenant')) {
            // For tenants, get reviews they've written
            $reviews = $user->reviews ?? collect();
        } elseif ($user->hasRole('landlord')) {
            // For landlords, get reviews on their properties
            $reviews = collect();
            foreach ($properties as $property) {
                if ($property->reviews) {
                    $reviews = $reviews->merge($property->reviews);
                }
            }
        }

        return view('subadmin.users.show', compact('user', 'bookings', 'properties', 'reviews'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('subadmin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|string|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        // Update role
        $user->syncRoles([$request->role]);

        // Update permissions if user is subadmin
        if ($request->role === 'subadmin' && $request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]);
        }

        return redirect()->route('subadmin.users.show', $user)
                        ->with('success', 'User updated successfully.');
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleStatus(User $user)
    {
        if ($user->status === 'inactive') {
            $user->update(['status' => 'active']);
            $message = 'User activated successfully.';
        } else {
            $user->update(['status' => 'inactive']);
            $message = 'User deactivated successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get user statistics for dashboard.
     */
    public function getStats()
    {
        return [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'tenants' => User::role('tenant')->count(),
            'landlords' => User::role('landlord')->count(),
            'recent_users' => User::with('roles')->latest()->take(5)->get(),
        ];
    }
}
