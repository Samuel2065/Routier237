<?php
use App\Http\Controllers\{HomeController, BookingController};
use App\Http\Controllers\Auth\AgencyRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Company;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Agency\{DashboardController as AgencyDashboard, PackageController, BookingController as AgencyBookingController};
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard, AgencyController as AdminAgencyController};
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'home'])->name('/');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/agency', [HomeController::class, 'agency'])->name('agency');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/agency_details', [HomeController::class, 'agency_details'])->name('agency_details');
Route::get('/destinations', [HomeController::class, 'destinations'])->name('destinations');
Route::get('/partner', [HomeController::class, 'partner'])->name('partner');
Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');

Route::get('sign_up', [AuthController::class, 'showSign_up'])->name('sign_up');
Route::post('sign_up', [AuthController::class, 'sign_up'])->name('sign_up');

Route::get('sign_in', [AuthController::class, 'showSign_in'])->name('sign_in');
Route::post('sign_in', [AuthController::class, 'sign_in'])->name('sign_in');

// Add login route alias
Route::get('login', [AuthController::class, 'showSign_in'])->name('login');
Route::post('login', [AuthController::class, 'sign_in']);

Route::get('view', [Company::class, 'showView'])->name('view');
Route::post('view', [Company::class, 'view']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/dashboard_clients', [AuthController::class, 'dashboardClients'])->middleware('auth')->name('dashboard_clients');
Route::get('/dashboard_agency', [AuthController::class, 'dashboardAgency'])->middleware('auth')->name('dashboard_agency');