<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'director_id',
        'manager_id',
        'name',
        'acronym',
        'logo',
        'headquarters_address',
        'phone',
        'email',
        'taxpayer_number',
        'description',
        'status',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}