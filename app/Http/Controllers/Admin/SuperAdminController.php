<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\Agency;
use App\Models\Role;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_companies' => Company::count(),
            'pending_companies' => Company::where('approval_status', 'pending')->count(),
            'active_agencies' => Agency::where('status', 'active')->where('approval_status', 'approved')->count(),
            'pending_agencies' => Agency::where('approval_status', 'pending')->count(),
            'total_users' => User::count(),
            // 'total_revenue' => Reservation::where('payment_status', 'paid')->sum('total_amount'),
        ];

        $recentCompanies = Company::with('director')
            ->latest()
            ->take(10)
            ->get();

        $pendingApprovals = Company::where('approval_status', 'pending')
            ->with('director')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCompanies', 'pendingApprovals'));
    }

    public function companies()
    {
        $companies = Company::with(['director', 'agencies'])
            ->latest()
            ->paginate(20);

        return view('admin.companies', compact('companies'));
    }

    public function createCompany()
    {
        // Get users who can be directors (users without a company)
        $directorRole = Role::where('slug', 'director')->first();
        $availableDirectors = User::where('role_id', $directorRole->id)
            ->whereDoesntHave('managedCompany')
            ->get();

        return view('admin.companies.create', compact('availableDirectors'));
    }

    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:10',
            'headquarters_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:companies,email',
            'taxpayer_number' => 'required|string|unique:companies,taxpayer_number',
            'description' => 'nullable|string',
            'director_option' => 'required|in:existing,new',
            'director_id' => 'required_if:director_option,existing|nullable|exists:users,id',
            // New director fields
            'director_name' => 'required_if:director_option,new|nullable|string|max:255',
            'director_email' => 'required_if:director_option,new|nullable|email|unique:users,email',
            'director_phone' => 'required_if:director_option,new|nullable|string|unique:users,phone',
            'director_password' => 'required_if:director_option,new|nullable|min:8',
        ]);

        try {
            DB::beginTransaction();

            // Create new director if needed
            if ($request->director_option === 'new') {
                $directorRole = Role::where('slug', 'director')->firstOrFail();
                
                $director = User::create([
                    'full_name' => $request->director_name,
                    'email' => $request->director_email,
                    'phone' => $request->director_phone,
                    'password' => Hash::make($request->director_password),
                    'user_type' => 'staff',
                    'role_id' => $directorRole->id,
                    'status' => 'active',
                ]);
                
                $directorId = $director->id;
            } else {
                $directorId = $request->director_id;
            }

            // Create company - Super admin creates approved companies
            $company = Company::create([
                'director_id' => $directorId,
                'name' => $validated['name'],
                'acronym' => $validated['acronym'],
                'headquarters_address' => $validated['headquarters_address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'taxpayer_number' => $validated['taxpayer_number'],
                'description' => $validated['description'],
                'status' => 'active',
                'approval_status' => 'approved', // Super admin created = auto approved
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('super_admin.companies')
                ->with('success', 'Company created and approved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Failed to create company: ' . $e->getMessage());
        }
    }

    public function approveCompany($id)
    {
        try {
            $company = Company::findOrFail($id);
            
            $company->update([
                'approval_status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'status' => 'active',
            ]);

            // Also approve the main agency if it exists
            $mainAgency = $company->agencies()->where('type', 'main')->first();
            if ($mainAgency) {
                $mainAgency->update([
                    'approval_status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                    'status' => 'active',
                ]);
            }

            return back()->with('success', 'Company approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve company: ' . $e->getMessage());
        }
    }

    public function rejectCompany(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $company = Company::findOrFail($id);
            
            $company->update([
                'approval_status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
                'status' => 'inactive',
            ]);

            return back()->with('success', 'Company rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject company: ' . $e->getMessage());
        }
    }

    public function agencies()
    {
        $agencies = Agency::with(['company', 'manager'])
            ->latest()
            ->paginate(20);

        return view('admin.agencies', compact('agencies'));
    }

    public function approveAgency($id)
    {
        try {
            $agency = Agency::findOrFail($id);
            
            // Check if company is approved first
            if ($agency->company->approval_status !== 'approved') {
                return back()->with('error', 'Cannot approve agency. Company must be approved first.');
            }
            
            $agency->update([
                'approval_status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'status' => 'active',
            ]);

            return back()->with('success', 'Agency approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve agency: ' . $e->getMessage());
        }
    }

    public function rejectAgency(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            $agency = Agency::findOrFail($id);
            
            $agency->update([
                'approval_status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
                'status' => 'inactive',
            ]);

            return back()->with('success', 'Agency rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject agency: ' . $e->getMessage());
        }
    }

    public function users()
    {
        $users = User::with('role')
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function roles()
    {
        $roles = Role::withCount('users')
            ->get();

        return view('admin.roles', compact('roles'));
    }

    public function permissions()
    {
        return view('admin.permissions');
    }
}