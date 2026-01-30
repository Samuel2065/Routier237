<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'vehicle_id',
        'driver_id',
        'departure_agency_id',
        'departure_date',
        'departure_time',
        'expected_arrival_date',
        'expected_arrival_time',
        'available_seats',
        'unit_price',
        'status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'expected_arrival_date' => 'date',
        'departure_time' => 'datetime',
        'expected_arrival_time' => 'datetime',
        'available_seats' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}