<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'agency_id',
        'route_id',
        'vehicle_id',
        'travel_date',
        'departure_time',
        'arrival_time',
        'service_type',
        'base_price',
        'available_seats',
        'status',
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    /**
     * Company operating this trip
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Agency operating this trip
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Route for this trip
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Vehicle used for this trip
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Bookings for this trip
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Trip prices (Normal and VIP)
     */
    public function tripPrices()
    {
        return $this->hasMany(TripPrice::class);
    }

    /**
     * Get VIP price
     */
    public function getVipPriceAttribute()
    {
        $vipPrice = $this->tripPrices()->where('class', 'VIP')->first();
        return $vipPrice ? $vipPrice->price : null;
    }

    /**
     * Get Normal price
     */
    public function getNormalPriceAttribute()
    {
        $normalPrice = $this->tripPrices()->where('class', 'Normal')->first();
        return $normalPrice ? $normalPrice->price : $this->base_price;
    }
}