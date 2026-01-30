<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_trips' => Reservation::where('client_id', $user->client->id)
                ->where('status', 'used')
                ->count(),
            'upcoming_trips' => Reservation::where('client_id', $user->client->id)
                ->where('status', 'confirmed')
                ->whereHas('trip', function($q) {
                    $q->where('departure_date', '>=', today());
                })
                ->count(),
            'total_bookings' => Reservation::where('client_id', $user->client->id)
                ->count(),
        ];

        $recentBookings = Reservation::where('client_id', $user->client->id)
            ->with(['trip.route.departureCity', 'trip.route.arrivalCity'])
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentBookings'));
    }

    public function reservations()
    {
        $user = Auth::user();
        
        $reservations = Reservation::where('client_id', $user->client->id)
            ->with(['trip.route.departureCity', 'trip.route.arrivalCity', 'trip.vehicle', 'salesAgency'])
            ->latest()
            ->paginate(20);

        return view('customer.reservations', compact('reservations'));
    }

    public function book()
    {
        // Only show approved agencies and companies
        $approvedAgencies = Agency::where('approval_status', 'approved')
            ->where('status', 'active')
            ->whereHas('company', function($q) {
                $q->where('approval_status', 'approved')
                  ->where('status', 'active');
            })
            ->with('company')
            ->get();

        // Get available trips from approved agencies only
        $availableTrips = Trip::where('status', 'scheduled')
            ->where('departure_date', '>=', today())
            ->where('available_seats', '>', 0)
            ->whereHas('departureAgency', function($q) {
                $q->where('approval_status', 'approved')
                  ->where('status', 'active')
                  ->whereHas('company', function($q2) {
                      $q2->where('approval_status', 'approved')
                         ->where('status', 'active');
                  });
            })
            ->with(['route.departureCity', 'route.arrivalCity', 'vehicle', 'departureAgency.company'])
            ->latest('departure_date')
            ->paginate(20);

        return view('customer.book', compact('approvedAgencies', 'availableTrips'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'passenger_type' => 'required|in:adult,child',
            'seat_number' => 'required|string',
            'baggage_fees' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        $trip = Trip::findOrFail($validated['trip_id']);

        // Verify trip is from approved agency
        if ($trip->departureAgency->approval_status !== 'approved' || 
            $trip->departureAgency->company->approval_status !== 'approved') {
            return back()->with('error', 'This trip is not available for booking.');
        }

        // Check if seat is available
        if ($trip->available_seats <= 0) {
            return back()->with('error', 'No seats available for this trip.');
        }

        try {
            // Calculate price
            $price = $trip->unit_price;
            $baggageFees = $validated['baggage_fees'] ?? 0;
            $totalAmount = $price + $baggageFees;

            // Generate unique codes
            $ticketNumber = 'TKT' . strtoupper(uniqid());
            $confirmationCode = strtoupper(substr(md5(uniqid() . time()), 0, 8));

            // Create reservation
            $reservation = Reservation::create([
                'trip_id' => $trip->id,
                'client_id' => $user->client->id,
                'ticket_number' => $ticketNumber,
                'seat_number' => $validated['seat_number'],
                'passenger_type' => $validated['passenger_type'],
                'price' => $price,
                'baggage_fees' => $baggageFees,
                'total_amount' => $totalAmount,
                'payment_method' => 'cash', // Default, can be updated
                'payment_status' => 'pending',
                'reservation_date' => now(),
                'reserved_by' => $user->id,
                'sales_agency_id' => $trip->departure_agency_id,
                'confirmation_code' => $confirmationCode,
                'status' => 'confirmed',
            ]);

            // Update available seats
            $trip->decrement('available_seats');

            return redirect()->route('customer.reservations')
                ->with('success', 'Booking confirmed! Your confirmation code is: ' . $confirmationCode);

        } catch (\Exception $e) {
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }
}