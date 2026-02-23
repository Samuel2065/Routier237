<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get driver record via employee relationship
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->first();
        
        if (!$driver) {
            return redirect()->route('sign_in')
                ->with('error', 'No driver profile found for your account.');
        }

        $agencyId = optional($driver->employee)->agency_id;

        $agencyTripsQuery = Trip::query();
        if ($agencyId) {
            $agencyTripsQuery->where('agency_id', $agencyId);
        } else {
            $agencyTripsQuery->whereRaw('1 = 0');
        }

        $stats = [
            'upcoming_trips' => (clone $agencyTripsQuery)
                ->where('status', 'scheduled')
                ->whereDate('travel_date', '>=', today())
                ->count(),
            'completed_trips' => (clone $agencyTripsQuery)
                ->where('status', 'completed')
                ->whereMonth('travel_date', now()->month)
                ->count(),
            'in_progress_trips' => (clone $agencyTripsQuery)
                ->whereIn('status', ['boarding', 'departed'])
                ->count(),
            'total_trips' => (clone $agencyTripsQuery)
                ->count(),
        ];

        // Get next scheduled trip
        $nextTrip = (clone $agencyTripsQuery)
            ->where('status', 'scheduled')
            ->whereDate('travel_date', '>=', today())
            ->with(['route.fromCity', 'route.toCity', 'vehicle'])
            ->orderBy('travel_date')
            ->orderBy('departure_time')
            ->first();

        return view('driver.dashboard', compact('stats', 'driver', 'nextTrip'));
    }

    public function trips()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $agencyId = optional($driver->employee)->agency_id;

        $trips = Trip::where('agency_id', $agencyId)
            ->with(['route.fromCity', 'route.toCity', 'vehicle', 'agency'])
            ->latest('travel_date')
            ->paginate(20);

        return view('driver.trips', compact('driver', 'trips'));
    }

    public function schedule()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $agencyId = optional($driver->employee)->agency_id;

        $upcomingTrips = Trip::where('agency_id', $agencyId)
            ->where('status', 'scheduled')
            ->whereDate('travel_date', '>=', today())
            ->with(['route.fromCity', 'route.toCity', 'vehicle', 'agency'])
            ->orderBy('travel_date')
            ->orderBy('departure_time')
            ->get();

        return view('driver.schedule', compact('driver', 'upcomingTrips'));
    }

    public function vehicle()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $agencyId = optional($driver->employee)->agency_id;

        // Get current or most recent vehicle assigned to this driver
        $currentTrip = Trip::where('agency_id', $agencyId)
            ->whereIn('status', ['scheduled', 'boarding', 'departed'])
            ->with(['vehicle.maintenances' => function($query) {
                $query->latest('maintenance_date')->limit(5);
            }])
            ->orderBy('travel_date')
            ->orderBy('departure_time')
            ->first();

        $vehicle = $currentTrip ? $currentTrip->vehicle : null;

        return view('driver.vehicle', compact('driver', 'vehicle'));
    }
}
