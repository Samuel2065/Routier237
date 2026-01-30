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
        'name',
        'acronym',
        'logo',
        'headquarters_address',
        'phone',
        'email',
        'taxpayer_number',
        'description',
        'status',
    ];

    /**
     * Relation avec Director (User)
     */
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    /**
     * Relation avec Agencies
     */
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }

    /**
     * Obtenir l'agence principale
     */
    public function mainAgency()
    {
        return $this->hasOne(Agency::class)->where('type', 'main');
    }

    /**
     * Obtenir les agences secondaires
     */
    public function secondaryAgencies()
    {
        return $this->hasMany(Agency::class)->where('type', 'secondary');
    }

    /**
     * Vérifier si la compagnie est active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
