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
        'estimated_duration_min',
        'price',
        'status',
    ];

    /**
     * City where route starts
     */
    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    /**
     * City where route ends
     */
    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    /**
     * Backward compatibility for legacy templates.
     */
    public function getDepartureCityAttribute()
    {
        return optional($this->fromCity)->name;
    }

    /**
     * Backward compatibility for legacy templates.
     */
    public function getArrivalCityAttribute()
    {
        return optional($this->toCity)->name;
    }

    /**
     * Trips on this route
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Schedules for this route
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Fares for this route
     */
    public function fares()
    {
        return $this->hasMany(Fare::class);
    }
}
