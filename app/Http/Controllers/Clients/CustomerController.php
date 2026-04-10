<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Mail\BookingVerificationCodeMail;
use App\Models\Agency;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

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
                ->whereIn('status', ['confirmed', 'valid', 'pending'])
                ->whereHas('trip', function($q) {
                    $q->where('travel_date', '>=', today());
                })
                ->count(),
            'total_bookings' => Reservation::where('client_id', $user->client->id)
                ->count(),
        ];

        $recentBookings = Reservation::where('client_id', $user->client->id)
            ->with(['trip.route.fromCity', 'trip.route.toCity'])
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentBookings'));
    }

    public function reservations()
    {
        $user = Auth::user();
        
        $reservations = Reservation::where('client_id', $user->client->id)
            ->with(['trip.route.fromCity', 'trip.route.toCity', 'trip.vehicle', 'salesAgency'])
            ->orderByDesc('id')
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
        $tripDateColumn = Schema::hasColumn('trips', 'departure_date') ? 'departure_date' : 'travel_date';

        $availableTrips = Trip::where('status', 'scheduled')
            ->whereDate($tripDateColumn, '>=', today())
            ->where('available_seats', '>', 0)
            ->whereHas('departureAgency', function($q) {
                $q->where('approval_status', 'approved')
                  ->where('status', 'active')
                  ->whereHas('company', function($q2) {
                      $q2->where('approval_status', 'approved')
                         ->where('status', 'active');
                  });
            })
            ->with(['route.fromCity', 'route.toCity', 'vehicle', 'tripPrices', 'departureAgency.company'])
            ->orderBy($tripDateColumn, 'desc')
            ->paginate(20);

        return view('customer.book', compact('approvedAgencies', 'availableTrips'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'passenger_type' => 'nullable|in:adult,child',
            'service_class' => 'nullable|in:classic,vip',
            'seat_number' => 'nullable|string',
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
            $serviceClass = strtolower($validated['service_class'] ?? 'classic');
            $selectedPrice = $this->resolveTripPriceByClass($trip, $serviceClass);

            if ($selectedPrice === null) {
                return back()->with('error', 'Selected service class is not available for this trip.');
            }

            $passengerType = $validated['passenger_type'] ?? 'adult';
            $seatNumber = $validated['seat_number'] ?? $this->autoAssignSeat($trip, $serviceClass);

            if (!$seatNumber) {
                return back()->with('error', 'No seat available for this service class.');
            }

            // Calculate price
            $price = $selectedPrice;
            $baggageFees = $validated['baggage_fees'] ?? 0;
            $totalAmount = $price + $baggageFees;

            // Generate unique codes
            $ticketNumber = 'TKT' . strtoupper(uniqid());
            $confirmationCode = strtoupper(substr(md5(uniqid() . time()), 0, 8));

            // Create reservation
            $reservationData = [
                'trip_id' => $trip->id,
                'client_id' => $user->client->id,
            ];

            if (Schema::hasColumn('reservations', 'departure_date')) {
                $reservationData['departure_date'] = $trip->travel_date ?? now()->toDateString();
            }

            if (Schema::hasColumn('reservations', 'status')) {
                $reservationData['status'] = $this->resolvePendingReservationStatusValue();
            }

            if (Schema::hasColumn('reservations', 'ticket_number')) {
                $reservationData['ticket_number'] = $ticketNumber;
            }
            if (Schema::hasColumn('reservations', 'seat_number')) {
                $reservationData['seat_number'] = $seatNumber;
            }
            if (Schema::hasColumn('reservations', 'passenger_type')) {
                $reservationData['passenger_type'] = $passengerType;
            }
            if (Schema::hasColumn('reservations', 'price')) {
                $reservationData['price'] = $price;
            }
            if (Schema::hasColumn('reservations', 'baggage_fees')) {
                $reservationData['baggage_fees'] = $baggageFees;
            }
            if (Schema::hasColumn('reservations', 'total_amount')) {
                $reservationData['total_amount'] = $totalAmount;
            }
            if (Schema::hasColumn('reservations', 'payment_method')) {
                $reservationData['payment_method'] = 'cash';
            }
            if (Schema::hasColumn('reservations', 'payment_status')) {
                $reservationData['payment_status'] = 'pending';
            }
            if (Schema::hasColumn('reservations', 'reservation_date')) {
                $reservationData['reservation_date'] = now();
            }
            if (Schema::hasColumn('reservations', 'reserved_by')) {
                $reservationData['reserved_by'] = $user->id;
            }
            if (Schema::hasColumn('reservations', 'sales_agency_id')) {
                $reservationData['sales_agency_id'] = $trip->agency_id;
            }
            if (Schema::hasColumn('reservations', 'confirmation_code')) {
                $reservationData['confirmation_code'] = $confirmationCode;
            }

            $reservation = Reservation::create($reservationData);

            // Update available seats
            $trip->decrement('available_seats');

            $trip->loadMissing(['route.fromCity', 'route.toCity', 'departureAgency.company']);
            $mailFailed = false;

            if (!empty($user->email)) {
                $bookingMailData = [
                    'customer_name' => $user->full_name ?? 'Customer',
                    'confirmation_code' => $confirmationCode,
                    'ticket_number' => $ticketNumber,
                    'agency_name' => data_get($trip, 'departureAgency.company.name')
                        ?? data_get($trip, 'departureAgency.name')
                        ?? 'N/A',
                    'route' => trim((data_get($trip, 'route.fromCity.name', '') . ' - ' . data_get($trip, 'route.toCity.name', '')), ' -'),
                    'travel_date' => optional($trip->travel_date)->format('d/m/Y')
                        ?? ($trip->departure_date ?? '-'),
                    'departure_time' => $trip->departure_time
                        ? \Carbon\Carbon::createFromFormat('H:i:s', $trip->departure_time)->format('H:i')
                        : '-',
                    'seat_number' => $seatNumber ?: '-',
                    'service_class' => ucfirst($serviceClass),
                    'total_amount' => number_format((float) $totalAmount, 0, ',', ' ') . ' XAF',
                ];

                try {
                    Mail::to($user->email)->send(new BookingVerificationCodeMail($bookingMailData));
                } catch (\Throwable $mailException) {
                    $mailFailed = true;
                    Log::warning('Booking verification email failed.', [
                        'reservation_id' => $reservation->id ?? null,
                        'user_id' => $user->id ?? null,
                        'email' => $user->email,
                        'message' => $mailException->getMessage(),
                    ]);
                }
            }

            $successMessage = 'Booking created. Enter the verification code sent to your email to confirm it.';
            if ($mailFailed) {
                $successMessage .= ' (Booking saved, but verification email could not be sent.)';
            } else {
                $successMessage .= ' Verification code sent to your inbox.';
            }

            return redirect()->route('customer.book.confirmation', ['reservation' => $reservation->id])
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    public function bookingConfirmation(Reservation $reservation)
    {
        $user = Auth::user();

        if ((int) $reservation->client_id !== (int) optional($user->client)->id) {
            abort(403);
        }

        $reservation->load([
            'client',
            'trip.route.fromCity',
            'trip.route.toCity',
            'trip.departureAgency.company',
        ]);

        return view('customer.booking_confirmation', compact('reservation'));
    }

    public function verifyBookingConfirmation(Request $request, Reservation $reservation)
    {
        $user = Auth::user();

        if ((int) $reservation->client_id !== (int) optional($user->client)->id) {
            abort(403);
        }

        $isPaymentStep = $request->filled('payment_method') || $request->filled('payment_confirmed');
        $sessionKey = 'reservation_verified_' . $reservation->id;

        if ($isPaymentStep) {
            $validated = $request->validate([
                'payment_method' => 'required|in:om,momo',
                'payment_confirmed' => 'accepted',
            ]);
        } else {
            $validated = $request->validate([
                'confirmation_code' => 'required|string|min:4|max:20',
            ]);
        }

        if (!$isPaymentStep) {
            $providedCode = strtoupper(trim((string) $validated['confirmation_code']));
            $storedCode = strtoupper(trim((string) ($reservation->confirmation_code ?? '')));

            if ($storedCode === '' || $providedCode !== $storedCode) {
                return back()->with('error', 'Invalid confirmation code. Please check your email and try again.');
            }

            $request->session()->put($sessionKey, true);

            return redirect()->route('customer.book.confirmation', ['reservation' => $reservation->id])
                ->with('success', 'Verification successful. Please choose your payment method to complete the booking.');
        }

        if (!$request->session()->get($sessionKey, false) && strtolower((string) ($reservation->payment_status ?? '')) !== 'paid') {
            return redirect()->route('customer.book.confirmation', ['reservation' => $reservation->id])
                ->with('error', 'Please verify your booking code before proceeding to payment.');
        }

        if (Schema::hasColumn('reservations', 'status')) {
            $reservation->status = $this->resolveVerifiedReservationStatusValue();
        }
        if (Schema::hasColumn('reservations', 'payment_method')) {
            $reservation->payment_method = $validated['payment_method'];
        }
        if (Schema::hasColumn('reservations', 'payment_status')) {
            $reservation->payment_status = 'paid';
        }
        if ($reservation->isDirty()) {
            $reservation->save();
        }

        $reservation->loadMissing(['trip.route.fromCity', 'trip.route.toCity', 'trip.departureAgency.company']);

        if (!empty($user->email)) {
            $trip = $reservation->trip;

            $bookingMailData = [
                'customer_name' => $user->full_name ?? 'Customer',
                'confirmation_code' => $reservation->confirmation_code ?? null,
                'ticket_number' => $reservation->ticket_number ?? null,
                'agency_name' => data_get($trip, 'departureAgency.company.name')
                    ?? data_get($trip, 'departureAgency.name')
                    ?? 'N/A',
                'route' => trim((data_get($trip, 'route.fromCity.name', '') . ' - ' . data_get($trip, 'route.toCity.name', '')), ' -'),
                'travel_date' => optional($trip->travel_date)->format('d/m/Y')
                    ?? ($trip->departure_date ?? '-'),
                'departure_time' => $trip && $trip->departure_time
                    ? \Carbon\Carbon::createFromFormat('H:i:s', $trip->departure_time)->format('H:i')
                    : '-',
                'seat_number' => $reservation->seat_number ?: '-',
                'service_class' => ucfirst((string) ($reservation->service_class ?? 'classic')),
                'total_amount' => isset($reservation->total_amount)
                    ? number_format((float) $reservation->total_amount, 0, ',', ' ') . ' XAF'
                    : '-',
            ];

            try {
                Mail::to($user->email)->send(new BookingConfirmationMail($bookingMailData));
            } catch (\Throwable $mailException) {
                Log::warning('Booking success email failed after verification.', [
                    'reservation_id' => $reservation->id ?? null,
                    'user_id' => $user->id ?? null,
                    'email' => $user->email,
                    'message' => $mailException->getMessage(),
                ]);
            }
        }

        return redirect()->route('customer.book.confirmation', ['reservation' => $reservation->id])
            ->with('success', 'Payment completed. Your booking is now confirmed and the confirmation email has been sent.')
            ->with('last_payment_method', $validated['payment_method']);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    private function resolveTripPriceByClass(Trip $trip, string $serviceClass): ?float
    {
        $trip->loadMissing('tripPrices');

        if ($serviceClass === 'vip') {
            $vipPrice = optional($trip->tripPrices->firstWhere('class', 'VIP'))->price;
            return $vipPrice !== null ? (float) $vipPrice : null;
        }

        $normalPrice = optional($trip->tripPrices->firstWhere('class', 'Normal'))->price;
        if ($normalPrice !== null) {
            return (float) $normalPrice;
        }

        return isset($trip->base_price) ? (float) $trip->base_price : null;
    }

    private function autoAssignSeat(Trip $trip, string $serviceClass): ?string
    {
        $trip->loadMissing('vehicle');

        $seatClass = $serviceClass === 'vip' ? 'VIP' : 'Normal';
        $vehicleId = optional($trip->vehicle)->id;

        if ($vehicleId && Schema::hasTable('seats')) {
            $candidateSeats = Seat::where('vehicle_id', $vehicleId)
                ->where('class', $seatClass)
                ->orderBy('seat_number')
                ->pluck('seat_number');

            if ($candidateSeats->isNotEmpty() && Schema::hasColumn('reservations', 'seat_number')) {
                $usedSeats = Reservation::where('trip_id', $trip->id)
                    ->whereNotNull('seat_number')
                    ->pluck('seat_number')
                    ->map(fn ($v) => strtoupper((string) $v))
                    ->toArray();

                foreach ($candidateSeats as $seatNumber) {
                    if (!in_array(strtoupper((string) $seatNumber), $usedSeats, true)) {
                        return (string) $seatNumber;
                    }
                }
            }
        }

        $capacity = (int) ($trip->available_seats ?? 0);
        if ($capacity <= 0) {
            return null;
        }

        if (!Schema::hasColumn('reservations', 'seat_number')) {
            return 'AUTO';
        }

        $usedSeats = Reservation::where('trip_id', $trip->id)
            ->whereNotNull('seat_number')
            ->pluck('seat_number')
            ->map(function ($seat) {
                if (preg_match('/(\d+)$/', (string) $seat, $matches)) {
                    return (int) $matches[1];
                }
                return null;
            })
            ->filter()
            ->values()
            ->all();

        for ($i = 1; $i <= $capacity; $i++) {
            if (!in_array($i, $usedSeats, true)) {
                return 'S' . str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            }
        }

        return null;
    }

    private function resolvePendingReservationStatusValue(): string
    {
        try {
            $column = DB::selectOne("SHOW COLUMNS FROM reservations LIKE 'status'");
            $type = strtolower((string) ($column->Type ?? ''));

            if (str_starts_with($type, 'enum(')) {
                preg_match_all("/'([^']+)'/", $type, $matches);
                $allowed = $matches[1] ?? [];

                foreach (['pending', 'booked', 'valid', 'confirmed'] as $preferred) {
                    if (in_array($preferred, $allowed, true)) {
                        return $preferred;
                    }
                }

                if (!empty($allowed)) {
                    return $allowed[0];
                }
            }
        } catch (\Throwable $e) {
            // Fallback below
        }

        return 'pending';
    }

    private function resolveVerifiedReservationStatusValue(): string
    {
        try {
            $column = DB::selectOne("SHOW COLUMNS FROM reservations LIKE 'status'");
            $type = strtolower((string) ($column->Type ?? ''));

            if (str_starts_with($type, 'enum(')) {
                preg_match_all("/'([^']+)'/", $type, $matches);
                $allowed = $matches[1] ?? [];

                foreach (['confirmed', 'valid', 'booked', 'pending'] as $preferred) {
                    if (in_array($preferred, $allowed, true)) {
                        return $preferred;
                    }
                }

                if (!empty($allowed)) {
                    return $allowed[0];
                }
            }
        } catch (\Throwable $e) {
            // Fallback below
        }

        return 'confirmed';
    }
}
