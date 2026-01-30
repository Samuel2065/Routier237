<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SignInController extends Controller
{
    public function showSignInForm()
    {
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
        
        return redirect()->route('sign_in')->with('success', 'You have been logged out successfully.');
    }
}