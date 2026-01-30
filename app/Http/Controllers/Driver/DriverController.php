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

        $stats = [
            'upcoming_trips' => Trip::where('driver_id', $driver->id)
                ->where('status', 'scheduled')
                ->where('departure_date', '>=', today())
                ->count(),
            'completed_trips' => Trip::where('driver_id', $driver->id)
                ->where('status', 'arrived')
                ->whereMonth('departure_date', now()->month)
                ->count(),
            'in_progress_trips' => Trip::where('driver_id', $driver->id)
                ->where('status', 'in_progress')
                ->count(),
            'total_trips' => Trip::where('driver_id', $driver->id)
                ->count(),
        ];

        // Get next scheduled trip
        $nextTrip = Trip::where('driver_id', $driver->id)
            ->where('status', 'scheduled')
            ->where('departure_date', '>=', today())
            ->with(['route.departureCity', 'route.arrivalCity', 'vehicle'])
            ->orderBy('departure_date')
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

        $trips = Trip::where('driver_id', $driver->id)
            ->with(['route.departureCity', 'route.arrivalCity', 'vehicle', 'departureAgency'])
            ->latest('departure_date')
            ->paginate(20);

        return view('driver.trips', compact('driver', 'trips'));
    }

    public function schedule()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $upcomingTrips = Trip::where('driver_id', $driver->id)
            ->where('status', 'scheduled')
            ->where('departure_date', '>=', today())
            ->with(['route.departureCity', 'route.arrivalCity', 'vehicle', 'departureAgency'])
            ->orderBy('departure_date')
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

        // Get current or most recent vehicle assigned to this driver
        $currentTrip = Trip::where('driver_id', $driver->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->with(['vehicle.vehicleType', 'vehicle.maintenances' => function($query) {
                $query->latest('maintenance_date')->limit(5);
            }])
            ->first();

        $vehicle = $currentTrip ? $currentTrip->vehicle : null;

        return view('driver.vehicle', compact('driver', 'vehicle'));
    }
}