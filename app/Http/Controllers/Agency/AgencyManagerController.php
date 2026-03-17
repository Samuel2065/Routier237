<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AgencyManagerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get the agency the manager is assigned to
        $agency = $user->managedAgency;
        
        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $reservationsQuery = $agency->reservations();

        // Support different reservation schemas without breaking manager login.
        $todayBookingsQuery = clone $reservationsQuery;
        if (Schema::hasColumn('reservations', 'reservation_date')) {
            $todayBookingsQuery->whereDate('reservation_date', today());
        } elseif (Schema::hasColumn('reservations', 'departure_date')) {
            $todayBookingsQuery->whereDate('departure_date', today());
        } else {
            $todayBookingsQuery->whereHas('trip', function ($query) {
                $query->whereDate('travel_date', today());
            });
        }

        $dailyRevenue = 0;
        if (Schema::hasColumn('reservations', 'total_amount')) {
            $dailyRevenueQuery = clone $todayBookingsQuery;
            if (Schema::hasColumn('reservations', 'payment_status')) {
                $dailyRevenueQuery->where('payment_status', 'paid');
            }
            $dailyRevenue = $dailyRevenueQuery->sum('total_amount');
        }

        $stats = [
            'total_reservations' => $reservationsQuery->count(),
            'today_bookings' => $todayBookingsQuery->count(),
            'staff_count' => $agency->employees()->count(),
            'daily_revenue' => $dailyRevenue,
        ];

        return view('agency_manager.dashboard', compact('stats', 'agency'));
    }

    public function reservations()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $reservations = $agency->reservations()
            ->with(['trip', 'client'])
            ->latest()
            ->paginate(20);

        return view('agency_manager.reservations', compact('agency', 'reservations'));
    }

    public function staff()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;
        
        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $staff = $agency->employees()
            ->with('user.role')
            ->paginate(15);

        return view('agency_manager.staff', compact('staff', 'agency'));
    }

    public function createStaff()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        return view('agency_manager.staff.create', compact('agency'));
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:counter_clerk,accountant,driver',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'base_salary' => 'required|numeric|min:0',
            'id_card_number' => 'required|string|unique:employees,id_card_number',
            // Driver specific fields
            'license_number' => 'required_if:role,driver|nullable|string|unique:drivers,license_number',
            'license_category' => 'required_if:role,driver|nullable|string',
            'license_issue_date' => 'required_if:role,driver|nullable|date',
            'license_expiry_date' => 'required_if:role,driver|nullable|date|after:license_issue_date',
            'years_experience' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $agency = $user->managedAgency;
        
        if (!$agency) {
            return back()->with('error', 'No agency found for your account.');
        }

        try {
            DB::beginTransaction();

            $role = Role::where('slug', $validated['role'])->firstOrFail();

            // Create User account
            $newUser = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
                'user_type' => 'staff',
                'status' => 'active',
            ]);

            // Split full name into first and last name
            $nameParts = explode(' ', $validated['full_name'], 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Generate employee number
            $employeeNumber = 'EMP' . str_pad($agency->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($agency->employees()->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create Employee record
            $employee = Employee::create([
                'user_id' => $newUser->id,
                'agency_id' => $agency->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'position' => $validated['position'],
                'employee_number' => $employeeNumber,
                'hire_date' => $validated['hire_date'],
                'base_salary' => $validated['base_salary'],
                'id_card_number' => $validated['id_card_number'],
            ]);

            // If driver, create driver record
            if ($validated['role'] === 'driver') {
                Driver::create([
                    'employee_id' => $employee->id,
                    'license_number' => $validated['license_number'],
                    'license_category' => $validated['license_category'],
                    'license_issue_date' => $validated['license_issue_date'],
                    'license_expiry_date' => $validated['license_expiry_date'],
                    'years_experience' => $validated['years_experience'] ?? 0,
                    'status' => 'available',
                ]);
            }

            DB::commit();

            return redirect()->route('agency_manager.staff')
                ->with('success', 'Staff member added successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create staff: ' . $e->getMessage());
        }
    }

    public function vehicles()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        return view('agency_manager.vehicles', compact('agency'));
    }

    public function drivers()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;
        
        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $drivers = $agency->employees()
            ->whereHas('user.role', function($query) {
                $query->where('slug', 'driver');
            })
            ->with(['user', 'driver'])
            ->paginate(15);

        return view('agency_manager.drivers', compact('drivers', 'agency'));
    }

    public function trips()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $tripDateColumn = Schema::hasColumn('trips', 'departure_date') ? 'departure_date' : 'travel_date';

        $trips = $agency->departureTrips()
            ->with(['route', 'vehicle', 'driver'])
            ->latest($tripDateColumn)
            ->paginate(20);

        return view('agency_manager.trips', compact('agency', 'trips'));
    }

    public function cashRegister()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $cashRegisters = $agency->cashRegisters()
            ->with('user')
            ->latest('opening_date')
            ->paginate(20);

        return view('agency_manager.cash_register', compact('agency', 'cashRegisters'));
    }

    public function expenses()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        $expenses = $agency->expenses()
            ->with('validatedBy')
            ->latest('expense_date')
            ->paginate(20);

        return view('agency_manager.expenses', compact('agency', 'expenses'));
    }

    public function reports()
    {
        $user = Auth::user();
        $agency = $user->managedAgency;

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency found for your account.');
        }

        return view('agency_manager.reports', compact('agency'));
    }
}
