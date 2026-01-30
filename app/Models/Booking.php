<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'client_id', // Changed from user_id to client_id
        'booking_date',
        'number_of_seats',
        'total_amount',
        'amount_paid',
        'payment_status',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Get the client who made the booking
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the route for this booking
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Scope for confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}