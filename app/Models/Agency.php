<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'address',
        'city',
        'rating'
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

}
