<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_city_id',
        'to_city_id',
        'distance_km',
        'estimated_duration',
        'route_description',
        'status',
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'estimated_duration' => 'integer',
    ];

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function fares()
    {
        return $this->hasMany(Fare::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }
}