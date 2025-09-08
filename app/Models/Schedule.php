<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id', 'travel_date', 'available_seats', 
        'current_price', 'is_available'
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
