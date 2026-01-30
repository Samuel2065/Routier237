<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TripPrice extends Model
{
    protected $fillable = [
        'trip_id',
        'class',
        'price'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
