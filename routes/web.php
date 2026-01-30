
<?php

use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\DirectorController;  
use App\Http\Controllers\Agency\AgencyManagerController;
use App\Http\Controllers\CounterClerk\CounterClerkController;
use App\Http\Controllers\Accountant\AccountantController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\Clients\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'home'])->name('/');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/agency', [HomeController::class, 'agency'])->name('agency');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/agency_details', [HomeController::class, 'agency_details'])->name('agency_details');
Route::get('/destinations', [HomeController::class, 'destinations'])->name('destinations');
Route::get('/partner', [HomeController::class, 'partner'])->name('partner');
Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/marketplace/{city:slug}', [HomeController::class, 'marketplaceCity'])->name('marketplace.city');
Route::get('/view', [HomeController::class, 'view'])->name('view');    

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/sign-in', [SignInController::class, 'showSignInForm'])->name('sign_in');
    Route::post('/sign-in', [SignInController::class, 'signIn']);
    
    Route::get('/sign-up', [SignUpController::class, 'showSignUpForm'])->name('sign_up');
    Route::post('/sign-up', [SignUpController::class, 'signUp']);
});

Route::post('/logout', [SignInController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    
    // Super Admin Routes
    Route::middleware(['role:super_admin'])->prefix('super-admin')->name('super_admin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        
        // Companies Management
        Route::get('/companies', [SuperAdminController::class, 'companies'])->name('companies');
        Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('companies.create');
        Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('companies.store');
        Route::post('/companies/{id}/approve', [SuperAdminController::class, 'approveCompany'])->name('companies.approve');
        Route::post('/companies/{id}/reject', [SuperAdminController::class, 'rejectCompany'])->name('companies.reject');
        
        // Agencies Management
        Route::get('/agencies', [SuperAdminController::class, 'agencies'])->name('agencies');
        Route::post('/agencies/{id}/approve', [SuperAdminController::class, 'approveAgency'])->name('agencies.approve');
        Route::post('/agencies/{id}/reject', [SuperAdminController::class, 'rejectAgency'])->name('agencies.reject');
        
        // Other Routes
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::get('/roles', [SuperAdminController::class, 'roles'])->name('roles');
        Route::get('/permissions', [SuperAdminController::class, 'permissions'])->name('permissions');
    });
    
    // Director Routes
    Route::middleware(['role:director'])->prefix('director')->name('director.')->group(function () {
        Route::get('/dashboard', [DirectorController::class, 'dashboard'])->name('dashboard');
        Route::get('/company', [DirectorController::class, 'company'])->name('company');
        
        // Agencies
        Route::get('/agencies', [DirectorController::class, 'agencies'])->name('agencies');
        Route::get('/agencies/create', [DirectorController::class, 'createAgency'])->name('agencies.create');
        Route::post('/agencies', [DirectorController::class, 'storeAgency'])->name('agencies.store');
        
        Route::get('/managers', [DirectorController::class, 'managers'])->name('managers');
        Route::get('/fleet', [DirectorController::class, 'fleet'])->name('fleet');
        Route::get('/reports', [DirectorController::class, 'reports'])->name('reports');
    });
    
    // Agency Manager Routes
    Route::middleware(['role:agency_manager'])->prefix('agency')->name('agency_manager.')->group(function () {
        Route::get('/dashboard', [AgencyManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/reservations', [AgencyManagerController::class, 'reservations'])->name('reservations');
        
        // Staff Management
        Route::get('/staff', [AgencyManagerController::class, 'staff'])->name('staff');
        Route::get('/staff/create', [AgencyManagerController::class, 'createStaff'])->name('staff.create');
        Route::post('/staff', [AgencyManagerController::class, 'storeStaff'])->name('staff.store');
        
        Route::get('/vehicles', [AgencyManagerController::class, 'vehicles'])->name('vehicles');
        Route::get('/drivers', [AgencyManagerController::class, 'drivers'])->name('drivers');
        Route::get('/trips', [AgencyManagerController::class, 'trips'])->name('trips');
        Route::get('/cash-register', [AgencyManagerController::class, 'cashRegister'])->name('cash_register');
        Route::get('/expenses', [AgencyManagerController::class, 'expenses'])->name('expenses');
        Route::get('/reports', [AgencyManagerController::class, 'reports'])->name('reports');
    });
    
    // Counter Clerk Routes
    Route::middleware(['role:counter_clerk'])->prefix('clerk')->name('counter_clerk.')->group(function () {
        Route::get('/dashboard', [CounterClerkController::class, 'dashboard'])->name('dashboard');
        Route::get('/reservations', [CounterClerkController::class, 'reservations'])->name('reservations');
        Route::get('/reservations/create', [CounterClerkController::class, 'createReservation'])->name('reservations.create');
        Route::post('/reservations', [CounterClerkController::class, 'storeReservation'])->name('reservations.store');
        Route::get('/cash-register', [CounterClerkController::class, 'cashRegister'])->name('cash_register');
        Route::post('/cash-register/open', [CounterClerkController::class, 'openRegister'])->name('cash_register.open');
        Route::post('/cash-register/close', [CounterClerkController::class, 'closeRegister'])->name('cash_register.close');
    });
    
    // Accountant Routes
    Route::middleware(['role:accountant'])->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [AccountantController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [AccountantController::class, 'transactions'])->name('transactions');
        Route::get('/expenses', [AccountantController::class, 'expenses'])->name('expenses');
        Route::get('/reports', [AccountantController::class, 'reports'])->name('reports');
        Route::get('/cash-registers', [AccountantController::class, 'cashRegisters'])->name('cash_registers');
    });
    
    // Driver Routes
    Route::middleware(['role:driver'])->prefix('driver')->name('driver.')->group(function () {
        Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('dashboard');
        Route::get('/trips', [DriverController::class, 'trips'])->name('trips');
        Route::get('/schedule', [DriverController::class, 'schedule'])->name('schedule');
        Route::get('/vehicle', [DriverController::class, 'vehicle'])->name('vehicle');
    });
    
    // Customer Routes
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/reservations', [CustomerController::class, 'reservations'])->name('reservations');
        Route::get('/book', [CustomerController::class, 'book'])->name('book');
        Route::post('/book', [CustomerController::class, 'storeBooking'])->name('book.store');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    });
});