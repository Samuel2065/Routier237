<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Route;
use App\Models\Booking;

class AuthController extends Controller
{
    /**
     * Show the sign-in form
     */
    public function showSign_in()
    {
        return view('pages.sign_in');
    }
    
    /**
     * Show the sign-up form  
     */
    public function showSign_up()
    {
        return view('pages.sign_up');
    }

    /**
     * Handle user sign-in (login)
     */
    public function sign_in(Request $request)
    {
        \Log::info('Login attempt received:', [
            'email' => $request->email,
            'password_provided' => !empty($request->password)
        ]);

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            \Log::error('Login validation failed:', ['errors' => $validator->errors()]);
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Get the user by email
        $user = User::where('email', $request->email)->first();
        
        \Log::info('User lookup result:', [
            'email' => $request->email,
            'user_found' => $user ? 'yes' : 'no',
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? $user->user_type : null
        ]);

        if (!$user) {
            \Log::error('No user found with email:', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'No account found with this email address.'])
                ->withInput($request->only('email'));
        }

        \Log::info('Attempting password verification:', [
            'user_id' => $user->id,
            'password_length' => strlen($request->password),
            'stored_hash_length' => strlen($user->password)
        ]);

        // Try both direct comparison and Hash::check
        $directMatch = ($request->password === $user->password);
        $hashMatch = Hash::check($request->password, $user->password);

        \Log::info('Password verification results:', [
            'direct_match' => $directMatch,
            'hash_match' => $hashMatch
        ]);

        // Check the password using Hash::check
        if (!$hashMatch) {
            \Log::error('Password verification failed for user:', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            return back()
                ->withErrors(['password' => 'The password is incorrect.'])
                ->withInput($request->only('email'));
        }

        // Log the user in manually
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();
        
        // Log successful login
        \Log::info('User logged in successfully', [
            'user_id' => $user->id, 
            'email' => $user->email,
            'user_type' => $user->user_type
        ]);
        
        // Redirect based on user type
        if ($user->user_type === 'agency') {
            $welcomeName = $user->agency_name ?? $user->name;
            return redirect()->route('dashboard_agency')
                ->with('success', 'Welcome back, ' . $welcomeName . '!');
        } else {
            return redirect()->route('dashboard_clients')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }
    }

    /**
     * Handle user registration (sign-up)
     */
    public function sign_up(Request $request)
    {
        \Log::info('Registration attempt received', [
            'user_type' => $request->user_type,
            'name' => $request->name,
            'agency_name' => $request->agency_name,
            'email' => $request->email,
            'has_password' => !empty($request->password),
        ]);

        // First check if email already exists
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            \Log::warning('Email already exists', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'This email address is already registered.'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Build validation rules based on user type
        $rules = [
            'user_type' => 'required|in:passenger,agency',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password'
        ];

        $messages = [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password_confirmation.required' => 'Please confirm your password.',
            'password_confirmation.same' => 'Password confirmation does not match.'
        ];

        // Add conditional validation based on user type
        if ($request->user_type === 'passenger') {
            $rules['name'] = 'required|string|max:255';
            $messages['name.required'] = 'Full name is required.';
        } else {
            $rules['agency_name'] = 'required|string|max:255';
            $rules['business_license'] = 'required|string|max:255';
            $rules['address'] = 'required|string|max:500';
            $rules['tax_id'] = 'required|string|max:255';
            $rules['contact_person'] = 'required|string|max:255';
            
            $messages['agency_name.required'] = 'Agency name is required.';
            $messages['business_license.required'] = 'Business license number is required.';
            $messages['address.required'] = 'Business address is required.';
            $messages['tax_id.required'] = 'Tax ID is required.';
            $messages['contact_person.required'] = 'Contact person is required.';
        }

        // Validate
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            \Log::error('Registration validation failed:', [
                'errors' => $validator->errors()->all(),
                'user_type' => $request->user_type
            ]);
            return back()
                ->withErrors($validator)
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        try {
            // Check database connection first
            try {
                \DB::connection()->getPdo();
            } catch (\Exception $e) {
                \Log::error('Database connection failed', [
                    'error' => $e->getMessage(),
                    'connection' => config('database.default'),
                    'database' => config('database.connections.' . config('database.default') . '.database')
                ]);
                throw new \Exception('Unable to connect to the database. Please try again later.');
            }

            // Hash password
            $hashedPassword = Hash::make($request->password);
            \Log::info('Password hashed successfully');

            // Create new user based on type
            $user = new User();
            $user->user_type = $request->user_type;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $hashedPassword;
            
            if ($request->user_type === 'passenger') {
                $user->name = $request->name;
            } else {
                $user->name = $request->contact_person; // For agencies, use contact person as name
                $user->agency_name = $request->agency_name;
                $user->business_license = $request->business_license;
                $user->address = $request->address;
                $user->tax_id = $request->tax_id;
                $user->contact_person = $request->contact_person;
            }
            
            \Log::info('Attempting to save user', [
                'user_type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
            ]);
            
            $saved = $user->save();
            
            if (!$saved) {
                \Log::error('Failed to save user');
                throw new \Exception('Failed to create your account. Please try again.');
            }

            \Log::info('User saved successfully', [
                'user_id' => $user->id,
                'user_type' => $user->user_type
            ]);

            // Log the user in
            Auth::login($user);
            
            \Log::info('User logged in successfully after registration');

            // Redirect based on user type
            if ($user->user_type === 'agency') {
                return redirect()
                    ->route('dashboard_agency')
                    ->with('success', 'Welcome to Routier+237, ' . $user->agency_name . '!');
            } else {
                return redirect()
                    ->route('dashboard_clients')
                    ->with('success', 'Welcome to Routier+237, ' . $user->name . '!');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error during registration', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings()
            ]);
            return back()
                ->withErrors(['error' => 'Database error during registration. Please try again.'])
                ->withInput($request->except(['password', 'password_confirmation']));
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error_type' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            $errorMessage = 'Registration failed: ' . $e->getMessage();
            if (app()->environment('local')) {
                $errorMessage .= ' (Line ' . $e->getLine() . ' in ' . basename($e->getFile()) . ')';
            }
            
            return back()
                ->withErrors(['error' => $errorMessage])
                ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Log successful logout
        if ($user) {
            \Log::info('User logged out', [
                'user_id' => $user->id, 
                'email' => $user->email,
                'user_type' => $user->user_type
            ]);
        }
        
        return redirect()->route('/')->with('success', 'You have been logged out successfully.');
    }


    /**
 * Show the client (passenger) dashboard with dynamic data
 */
    public function dashboardClients()
    {
        if (Auth::check() && Auth::user()->user_type === 'agency') {
            return redirect()->route('agency.dashboard');
        }
        
        $user = Auth::user();
        
        // Get user's bookings
        $bookings = Booking::where('user_id', $user->id)
            ->with('route.agency')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalTrips = $bookings->where('status', 'completed')->count();
        $upcomingTrips = $bookings->where('status', 'confirmed')
            ->where('booking_date', '>', now())
            ->count();
        
        // Get unique cities visited
        $citiesVisited = $bookings->where('status', 'completed')
            ->pluck('route.arrival_city')
            ->unique()
            ->count();
        
        // Recent bookings (last 5)
        $recentBookings = $bookings->take(5);
        
        // Trip history
        $tripHistory = $bookings->take(5);
        
        return view('pages.dashboard_clients', compact(
            'user',
            'totalTrips',
            'upcomingTrips',
            'citiesVisited',
            'recentBookings',
            'tripHistory'
        ));
    }

    /**
     * Show the agency dashboard with dynamic data
     */
    public function dashboardAgency()
    {
        if (Auth::check() && Auth::user()->user_type === 'passenger') {
            return redirect()->route('dashboard_clients');
        }
        
        $agency = Auth::user();
        
        // Get agency's routes
        $routes = Route::where('agency_id', $agency->id)->get();
        
        // Get all bookings for agency's routes
        $bookings = Booking::whereIn('route_id', $routes->pluck('id'))
            ->with(['route', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $activeRoutes = $routes->where('status', 'active')->count();
        $totalBookings = $bookings->count();
        $totalPassengers = $bookings->where('status', 'completed')->count();
        
        // Calculate monthly revenue
        $monthlyRevenue = $bookings->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('amount_paid');
        
        // Recent bookings (last 5)
        $recentBookings = $bookings->take(5);
        
        // Today's active routes
        $todayRoutes = $routes->where('departure_date', now()->toDateString())
            ->where('status', 'active');
        
        return view('pages.dashboard_agency', compact(
            'agency',
            'activeRoutes',
            'totalBookings',
            'totalPassengers',
            'monthlyRevenue',
            'recentBookings',
            'todayRoutes'
        ));
    }
}