<?php

namespace App\Http\Controllers\CounterClerk;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterClerkController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $agency = null;

        if (!empty($user->agency_id)) {
            $agency = Agency::find($user->agency_id);
        }

        if (!$agency && $user->employee) {
            $agency = $user->employee->agency;
        }

        if (!$agency) {
            return redirect()->route('sign_in')
                ->with('error', 'No agency assigned to your account.');
        }

        $stats = [
            'today_bookings' => 0,
            'pending_payments' => 0,
            'cash_register_balance' => 0,
        ];

        return view('counter_clerk.dashboard', compact('stats', 'agency'));
    }

    public function reservations()
    {
        $user = Auth::user();
        $agency = null;

        if (!empty($user->agency_id)) {
            $agency = Agency::find($user->agency_id);
        }

        if (!$agency && $user->employee) {
            $agency = $user->employee->agency;
        }

        return view('counter_clerk.reservations', compact('agency'));
    }

    public function createReservation()
    {
        $user = Auth::user();
        $agency = null;

        if (!empty($user->agency_id)) {
            $agency = Agency::find($user->agency_id);
        }

        if (!$agency && $user->employee) {
            $agency = $user->employee->agency;
        }

        return view('counter_clerk.reservations.create', compact('agency'));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'seat_number' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        // Add reservation creation logic here

        return redirect()->route('counter_clerk.reservations')
            ->with('success', 'Reservation created successfully!');
    }

    public function cashRegister()
    {
        $user = Auth::user();
        $agency = null;

        if (!empty($user->agency_id)) {
            $agency = Agency::find($user->agency_id);
        }

        if (!$agency && $user->employee) {
            $agency = $user->employee->agency;
        }

        return view('counter_clerk.cash_register', compact('agency'));
    }

    public function openRegister(Request $request)
    {
        $validated = $request->validate([
            'opening_balance' => 'required|numeric|min:0',
        ]);

        // Add cash register opening logic

        return back()->with('success', 'Cash register opened successfully!');
    }

    public function closeRegister(Request $request)
    {
        $validated = $request->validate([
            'closing_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Add cash register closing logic

        return back()->with('success', 'Cash register closed successfully!');
    }
}
