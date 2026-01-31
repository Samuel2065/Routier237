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
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Agencies in this city
     */
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }

    /**
     * Routes starting from this city
     */
    public function routesFrom()
    {
        return $this->hasMany(Route::class, 'from_city_id');
    }

    /**
     * Routes ending in this city
     */
    public function routesTo()
    {
        return $this->hasMany(Route::class, 'to_city_id');
    }

    /**
     * Vérifier si la ville est active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

}