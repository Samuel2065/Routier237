<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use App\Models\Vehicle;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DirectorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $company = $user->managedCompany;
        
        if (!$company) {
            return redirect()->route('sign_in')
                ->with('error', 'No company found for your account.');
        }

        // Check if company is approved
        $companyApproved = $company->approval_status === 'approved';

        $stats = [
            'total_agencies' => Agency::where('company_id', $company->id)->count(),
            'approved_agencies' => Agency::where('company_id', $company->id)
                ->where('approval_status', 'approved')->count(),
            'pending_agencies' => Agency::where('company_id', $company->id)
                ->where('approval_status', 'pending')->count(),
            'active_vehicles' => Vehicle::whereHas('trips', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'active')->count(),
            'total_bookings' => Reservation::whereHas('trip', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
            'monthly_revenue' => Reservation::whereHas('trip', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })
            ->whereMonth('reservation_date', now()->month)
            ->where('payment_status', 'paid')
            ->sum('total_amount'),
        ];

        return view('director.dashboard', compact('stats', 'company', 'companyApproved'));
    }

    public function company()
    {
        $user = Auth::user();
        $company = $user->managedCompany;

        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        return view('director.company', compact('company'));
    }

    public function agencies()
    {
        $user = Auth::user();
        $company = $user->managedCompany;
        
        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        $agencies = Agency::where('company_id', $company->id)
            ->with(['manager', 'city'])
            ->latest()
            ->paginate(15);

        return view('director.agencies.index', compact('agencies', 'company'));
    }

    public function createAgency()
    {
        $user = Auth::user();
        $company = $user->managedCompany;

        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        // Check if company is approved
        if ($company->approval_status !== 'approved') {
            return redirect()->route('director.dashboard')
                ->with('error', 'Your company must be approved before creating agencies.');
        }

        // Get available managers (users without assigned agency)
        $availableManagers = User::whereHas('role', function($query) {
            $query->where('slug', 'agency_manager');
        })
        ->whereDoesntHave('managedAgency')
        ->get();

        $cities = City::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        if ($cities->isEmpty()) {
            return redirect()->route('director.agencies')
                ->with('error', 'No active cities found. Please add at least one active city first.');
        }

        return view('director.agencies.create', compact('company', 'availableManagers', 'cities'));
    }

    public function storeAgency(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'district' => 'nullable|string|max:255',
            'full_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:main,secondary',
            'manager_option' => 'required|in:existing,new',
            'manager_id' => 'required_if:manager_option,existing|nullable|exists:users,id',
            // New manager fields
            'manager_full_name' => 'required_if:manager_option,new|nullable|string|max:255',
            'manager_email' => 'required_if:manager_option,new|nullable|email|unique:users,email',
            'manager_phone' => 'required_if:manager_option,new|nullable|string|unique:users,phone',
            'manager_password' => 'required_if:manager_option,new|nullable|min:8',
        ]);

        $user = Auth::user();
        $company = $user->managedCompany;

        if (!$company) {
            return back()->with('error', 'No company found for your account.');
        }

        if ($company->approval_status !== 'approved') {
            return back()->with('error', 'Your company must be approved before creating agencies.');
        }

        try {
            DB::beginTransaction();

            // Create new manager if needed
            if ($request->manager_option === 'new') {
                $managerRole = Role::where('slug', 'agency_manager')->firstOrFail();
                
                $manager = User::create([
                    'full_name' => $request->manager_full_name,
                    'email' => $request->manager_email,
                    'phone' => $request->manager_phone,
                    'password' => Hash::make($request->manager_password),
                    'user_type' => 'staff',
                    'role_id' => $managerRole->id,
                    'status' => 'active',
                ]);
                
                $managerId = $manager->id;
            } else {
                $managerId = $request->manager_id;
            }

            // Generate agency code
            $agencyCount = Agency::where('company_id', $company->id)->count();
            $agencyCode = 'AG' . str_pad($company->id, 6, '0', STR_PAD_LEFT) . '-' . str_pad($agencyCount + 1, 3, '0', STR_PAD_LEFT);

            // Create agency - Needs approval from super admin
            Agency::create([
                'company_id' => $company->id,
                'manager_id' => $managerId,
                'name' => $validated['name'],
                'city_id' => $validated['city_id'],
                'district' => $validated['district'],
                'full_address' => $validated['full_address'],
                'slug' => $this->generateUniqueAgencySlug($validated['name']),
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'agency_code' => $agencyCode,
                'type' => $validated['type'],
                'status' => 'inactive', // Inactive until approved
                'approval_status' => 'pending', // Needs super admin approval
            ]);

            DB::commit();

            return redirect()->route('director.agencies')
                ->with('success', 'Agency created! Waiting for Super Admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create agency: ' . $e->getMessage());
        }
    }

    public function managers()
    {
        $user = Auth::user();
        $company = $user->managedCompany;
        
        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        // Get managers of this company's agencies
        $managers = User::whereHas('role', function($query) {
            $query->where('slug', 'agency_manager');
        })
        ->whereHas('managedAgency', function($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->with('managedAgency')
        ->paginate(15);

        return view('director.managers', compact('managers', 'company'));
    }

    public function fleet()
    {
        $user = Auth::user();
        $company = $user->managedCompany;

        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        $vehicles = Vehicle::paginate(15);

        return view('director.fleet', compact('company', 'vehicles'));
    }

    public function reports()
    {
        $user = Auth::user();
        $company = $user->managedCompany;

        if (!$company) {
            return redirect()->route('director.dashboard')
                ->with('error', 'No company found for your account.');
        }

        return view('director.reports', compact('company'));
    }

    private function generateUniqueAgencySlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'agency';
        $slug = $baseSlug;
        $suffix = 1;

        while (DB::table('agencies')->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
