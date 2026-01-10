<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'agency_id', 'departure_city', 'arrival_city',
        'departure_date', 'departure_time', 'price',
        'total_seats', 'available_seats', 'status', 'description'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper to get booked seats count
    public function getBookedSeatsAttribute()
    {
        return $this->total_seats - $this->available_seats;
    }
}