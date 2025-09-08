<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'phone', 'email', 'address', 
        'city', 'logo', 'rating', 'is_active'
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function activeRoutes()
    {
        return $this->hasMany(Route::class)->where('is_active', true);
    }
}
