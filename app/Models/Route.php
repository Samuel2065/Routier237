<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id', 'departure_destination_id', 'arrival_destination_id',
        'departure_time', 'arrival_time', 'price', 'available_seats',
        'total_seats', 'bus_type', 'amenities', 'notes', 'is_active'
    ];

    protected $casts = [
        'amenities' => 'array',
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function departureDestination()
    {
        return $this->belongsTo(Destination::class, 'departure_destination_id');
    }

    public function arrivalDestination()
    {
        return $this->belongsTo(Destination::class, 'arrival_destination_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
