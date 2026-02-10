<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'client_id',
        'ticket_number',
        'confirmation_code',
        'seat_number',
        'passenger_type',
        'price',
        'baggage_fees',
        'total_amount',
        'payment_method',
        'payment_status',
        'reservation_date',
        'reserved_by',
        'sales_agency_id',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'price' => 'decimal:2',
        'baggage_fees' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reservedBy()
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    public function salesAgency()
    {
        return $this->belongsTo(Agency::class, 'sales_agency_id');
    }
}
