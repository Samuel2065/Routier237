<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SignInController extends Controller
{
    public function showSignInForm()
    {
        $redirect = request()->query('redirect');
        if (!empty($redirect)) {
            session()->put('url.intended', $redirect);
        }

        return view('pages.sign_in');
    }

    public function signIn(Request $request)
    {
        Log::info('Login attempt received:', [
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

        if ($validator->fails()) {
            Log::error('Login validation failed:', ['errors' => $validator->errors()]);
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Get the user by email
        $user = User::where('email', $request->email)->first();
        
        Log::info('User lookup result:', [
            'email' => $request->email,
            'user_found' => $user ? 'yes' : 'no',
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? $user->user_type : null
        ]);

        if (!$user) {
            Log::error('No user found with email:', ['email' => $request->email]);
            return back()
                ->withErrors(['email' => 'No account found with this email address.'])
                ->withInput($request->only('email'));
        }

        // Check if user is active
        if (!$user->isActive()) {
            Log::error('Inactive user login attempt:', ['user_id' => $user->id]);
            return back()
                ->withErrors(['email' => 'Your account has been suspended. Please contact support.'])
                ->withInput($request->only('email'));
        }

        // Check the password
        if (!Hash::check($request->password, $user->password)) {
            Log::error('Password verification failed for user:', [
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
        
        // Update last login time
        $user->update(['last_login_at' => now()]);
        
        // Log successful login
        Log::info('User logged in successfully', [
            'user_id' => $user->id, 
            'email' => $user->email,
            'user_type' => $user->user_type,
            'role' => $user->role->slug ?? 'no_role'
        ]);
        
        // Redirect to appropriate dashboard
        return redirect()->intended(
            $user->getDashboardRoute()
        )->with('success', 'Welcome back, ' . $user->full_name . '!');
        
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (empty($googleUser->getEmail())) {
                return redirect()->route('sign_in')->withErrors([
                    'sign_in' => 'Google account did not return an email address.',
                ]);
            }

            $customerRole = Role::where('slug', 'customer')->first();
            if (!$customerRole) {
                Log::error('Google login failed: customer role not found.');

                return redirect()->route('sign_in')->withErrors([
                    'sign_in' => 'Authentication is not configured correctly. Please contact support.',
                ]);
            }

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user && !$user->isActive()) {
                return redirect()->route('sign_in')->withErrors([
                    'sign_in' => 'Your account has been suspended. Please contact support.',
                ]);
            }

            if (!$user) {
                $displayName = trim((string) $googleUser->getName());
                if ($displayName === '') {
                    $displayName = Str::before($googleUser->getEmail(), '@');
                }

                $phone = $this->generateUniqueCameroonPhone();

                $user = User::create([
                    'full_name' => $displayName,
                    'email' => $googleUser->getEmail(),
                    'phone' => $phone,
                    'password' => Hash::make(Str::random(32)),
                    'user_type' => 'customer',
                    'role_id' => $customerRole->id,
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'google_id' => $googleUser->getId(),
                ]);

                Client::create([
                    'user_id' => $user->id,
                    'full_name' => $displayName,
                    'email' => $user->email,
                    'phone' => $phone,
                    'status' => 'active',
                ]);
            } else {
                $updateData = [
                    'google_id' => $googleUser->getId(),
                ];

                if (!$user->email_verified_at) {
                    $updateData['email_verified_at'] = now();
                }

                $user->update($updateData);

                if ($user->user_type === 'customer') {
                    Client::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'full_name' => $user->full_name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'status' => 'active',
                        ]
                    );
                }
            }

            Auth::login($user, true);
            $request->session()->regenerate();
            $user->update(['last_login_at' => now()]);

            return redirect()->intended($user->getDashboardRoute())
                ->with('success', 'Signed in with Google successfully.');
        } catch (\Throwable $e) {
            Log::error('Google OAuth callback failed', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('sign_in')->withErrors([
                'sign_in' => 'Google sign-in failed. Please try again.',
            ]);
        }
    }

    private function generateUniqueCameroonPhone(): string
    {
        do {
            $phone = '6' . (string) random_int(5, 9) . str_pad((string) random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        } while (User::where('phone', $phone)->exists());

        return $phone;
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Log successful logout
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id, 
                'email' => $user->email,
                'user_type' => $user->user_type
            ]);
        }
        
        return redirect()->route('/')->with('success', 'You have been logged out successfully.');
    }
}

