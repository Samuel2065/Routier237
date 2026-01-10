<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'route_id', 'passenger_name', 'passenger_phone',
        'seat_number', 'amount_paid', 'status', 'payment_status', 'booking_date'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}