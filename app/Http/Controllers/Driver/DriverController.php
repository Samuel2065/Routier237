<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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

        $hasDriverId = Schema::hasColumn('trips', 'driver_id');
        $driverTrips = $hasDriverId
            ? Trip::where('driver_id', $driver->id)
            : Trip::query()->whereRaw('1=0');

        $stats = [
            'upcoming_trips' => (clone $driverTrips)
                ->where('status', 'scheduled')
                ->where('travel_date', '>=', today())
                ->count(),
            'completed_trips' => (clone $driverTrips)
                ->where('status', 'completed')
                ->whereMonth('travel_date', now()->month)
                ->count(),
            'in_progress_trips' => (clone $driverTrips)
                ->whereIn('status', ['boarding', 'departed'])
                ->count(),
            'total_trips' => (clone $driverTrips)->count(),
        ];

        // Get next scheduled trip
        $nextTrip = $hasDriverId
            ? (clone $driverTrips)
                ->where('status', 'scheduled')
                ->where('travel_date', '>=', today())
                ->with(['route.fromCity', 'route.toCity', 'vehicle'])
                ->orderBy('travel_date')
                ->orderBy('departure_time')
                ->first()
            : null;

        return view('driver.dashboard', compact('stats', 'driver', 'nextTrip'));
    }

    public function trips()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $trips = Schema::hasColumn('trips', 'driver_id')
            ? Trip::where('driver_id', $driver->id)
                ->with(['route.fromCity', 'route.toCity', 'vehicle', 'departureAgency'])
                ->latest('travel_date')
                ->paginate(20)
            : Trip::query()->whereRaw('1=0')->paginate(20);

        return view('driver.trips', compact('driver', 'trips'));
    }

    public function schedule()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        $upcomingTrips = Schema::hasColumn('trips', 'driver_id')
            ? Trip::where('driver_id', $driver->id)
                ->where('status', 'scheduled')
                ->where('travel_date', '>=', today())
                ->with(['route.fromCity', 'route.toCity', 'vehicle', 'departureAgency'])
                ->orderBy('travel_date')
                ->orderBy('departure_time')
                ->get()
            : collect();

        return view('driver.schedule', compact('driver', 'upcomingTrips'));
    }

    public function vehicle()
    {
        $user = Auth::user();
        
        $driver = Driver::whereHas('employee', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['employee.agency'])->firstOrFail();

        // Get current or most recent vehicle assigned to this driver
        $currentTrip = Schema::hasColumn('trips', 'driver_id')
            ? Trip::where('driver_id', $driver->id)
                ->whereIn('status', ['scheduled', 'boarding', 'departed'])
                ->with(['vehicle.vehicleType', 'vehicle.maintenances' => function($query) {
                    $query->latest('maintenance_date')->limit(5);
                }])
                ->first()
            : null;

        $vehicle = $currentTrip ? $currentTrip->vehicle : null;

        return view('driver.vehicle', compact('driver', 'vehicle'));
    }
}
