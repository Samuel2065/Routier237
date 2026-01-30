<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\CashRegister;
use App\Models\Expense;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountantController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $agency = Agency::find($user->agency_id ?? null);

        $stats = [
            'today_revenue' => Reservation::whereDate('reservation_date', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'today_expenses' => Expense::whereDate('expense_date', today())
                ->where('status', 'approved')
                ->sum('amount'),
            'pending_expenses' => Expense::where('status', 'pending')->count(),
            'active_cash_registers' => CashRegister::where('status', 'open')->count(),
        ];

        // Calculate net profit
        $stats['net_profit'] = $stats['today_revenue'] - $stats['today_expenses'];

        $activeCashRegisters = CashRegister::where('status', 'open')
            ->with(['agency', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $recentTransactions = Transaction::with(['cashRegister', 'performedBy'])
            ->latest()
            ->take(10)
            ->get();

        $pendingExpenses = Expense::where('status', 'pending')
            ->with(['agency'])
            ->latest()
            ->take(10)
            ->get();

        return view('accountant.dashboard', compact(
            'stats',
            'agency',
            'activeCashRegisters',
            'recentTransactions',
            'pendingExpenses'
        ));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['cashRegister', 'performedBy'])
            ->latest()
            ->paginate(20);

        return view('accountant.transactions', compact('transactions'));
    }

    public function expenses()
    {
        $expenses = Expense::with(['agency', 'validatedBy'])
            ->latest()
            ->paginate(20);

        return view('accountant.expenses', compact('expenses'));
    }

    public function reports()
    {
        $user = Auth::user();
        $agency = Agency::find($user->agency_id ?? null);

        // Monthly revenue
        $monthlyRevenue = Reservation::whereMonth('reservation_date', now()->month)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Monthly expenses
        $monthlyExpenses = Expense::whereMonth('expense_date', now()->month)
            ->where('status', 'approved')
            ->sum('amount');

        return view('accountant.reports', compact(
            'agency',
            'monthlyRevenue',
            'monthlyExpenses'
        ));
    }

    public function cashRegisters()
    {
        $cashRegisters = CashRegister::with(['agency', 'user'])
            ->latest()
            ->paginate(20);

        return view('accountant.cash_registers', compact('cashRegisters'));
    }
}