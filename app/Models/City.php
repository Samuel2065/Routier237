<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'region',
        'postal_code',
        'status',
    ];

    /**
     * Routes partant de cette ville
     */
    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'departure_city_id');
    }

    /**
     * Routes arrivant dans cette ville
     */
    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'arrival_city_id');
    }

    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }

    /**
     * Vérifier si la ville est active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}