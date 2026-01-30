<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plate_number',
        'model',
        'seat_count',
        'type',
        'status'
    ];

    /**
     * Get the company that owns the vehicle
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all trips for this vehicle
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get all seats for this vehicle
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Get all maintenance records for this vehicle
     */
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Check if vehicle is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}