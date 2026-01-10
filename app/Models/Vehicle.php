<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'agency_id', 'vehicle_number', 'vehicle_type', 'capacity', 'status'
    ];

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }
}