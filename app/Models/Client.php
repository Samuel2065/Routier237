<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'status',
    ];

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec Reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Vérifier si le client est actif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si le client est bloqué
     */
    public function isBlocked()
    {
        return $this->status === 'blocked';
    }
}