<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $guarded = [];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function salesAgency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'sales_agency_id');
    }

    /**
     * Backward compatibility for views using $reservation->route
     */
    public function getRouteAttribute()
    {
        return optional($this->trip)->route;
    }
}
