<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class SignUpController extends Controller
{
    public function showSignUpForm()
    {
        return view('pages.sign_up');
    }

    public function signUp(Request $request)
    {
        Log::info('Registration attempt', [
            'user_type' => $request->user_type,
            'email' => $request->email,
        ]);

        try {
            // Validate user type first
            if (!in_array($request->user_type, ['passenger', 'agency'])) {
                return back()
                    ->withInput()
                    ->withErrors(['user_type' => 'Invalid user type selected.']);
            }

            // Build validation rules
            $rules = [
                'user_type' => 'required|in:passenger,agency',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => ['required', 'confirmed', Password::min(8)],
                'phone' => 'required|string|unique:users,phone|regex:/^[0-9]{9}$/',
            ];

            // Add conditional validation
            if ($request->user_type === 'passenger') {
                $rules['full_name'] = 'required|string|max:255';
            } else {
                $rules['agency_name'] = 'required|string|max:255';
                $rules['business_license'] = 'required|string|max:255';
                $rules['address'] = 'required|string|max:500';
                $rules['tax_id'] = 'required|string|max:255|unique:companies,taxpayer_number';
                $rules['contact_person'] = 'required|string|max:255';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::error('Validation failed', ['errors' => $validator->errors()]);
                return back()
                    ->withErrors($validator)
                    ->withInput($request->except(['password', 'password_confirmation']));
            }

            DB::beginTransaction();

            if ($request->user_type === 'passenger') {
                // Create customer account
                $role = Role::where('slug', 'customer')->firstOrFail();
                
                $user = User::create([
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'user_type' => 'customer',
                    'role_id' => $role->id,
                    'status' => 'active',
                ]);

                // Create client profile
                Client::create([
                    'user_id' => $user->id,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'status' => 'active',
                ]);

                Log::info('Customer account created', ['user_id' => $user->id]);

            } else {
                // Create director account for agency
                $role = Role::where('slug', 'director')->firstOrFail();
                
                $user = User::create([
                    'full_name' => $request->contact_person,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                    'user_type' => 'staff',
                    'role_id' => $role->id,
                    'status' => 'active',
                ]);

                // Create company with director link
                $company = Company::create([
                    'director_id' => $user->id,
                    'name' => $request->agency_name,
                    'headquarters_address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'taxpayer_number' => $request->tax_id,
                    'status' => 'active',
                ]);

                // Generate agency code
                $agencyCode = 'AG' . str_pad($company->id, 6, '0', STR_PAD_LEFT) . '-001';

                // Create main agency (director is also the manager of main agency)
                $agency = Agency::create([
                    'company_id' => $company->id,
                    'manager_id' => $user->id,
                    'name' => $request->agency_name . ' - Main Office',
                    'city' => 'To be updated',
                    'full_address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'agency_code' => $agencyCode,
                    'type' => 'main',
                    'status' => 'active',
                ]);

                Log::info('Director account created', [
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'agency_id' => $agency->id,
                ]);
            }

            DB::commit();

            // Log the user in
            Auth::login($user);
            $user->update(['last_login_at' => now()]);

            // Redirect to appropriate dashboard
            return redirect()->to($user->getDashboardRoute())
                ->with('success', 'Welcome to Routier+237! Your account has been created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}