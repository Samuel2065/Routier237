<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'is_active'
    ];

    public function departureRoutes()
    {
        return $this->hasMany(Route::class, 'departure_destination_id');
    }

    public function arrivalRoutes()
    {
        return $this->hasMany(Route::class, 'arrival_destination_id');
    }
}
