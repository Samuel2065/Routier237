<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'manager_id',
        'name',
        'city',
        'district',
        'full_address',
        'phone',
        'email',
        'agency_code',
        'type',
        'status',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relation avec Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation avec Manager (User)
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Relation avec Employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Relation avec Reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'sales_agency_id');
    }

    /**
     * Relation avec Cash Registers
     */
    public function cashRegisters()
    {
        return $this->hasMany(CashRegister::class);
    }

    /**
     * Relation avec Expenses
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Relation avec Trips (départ)
     */
    public function departureTrips()
    {
        return $this->hasMany(Trip::class, 'departure_agency_id');
    }

    /**
     * Vérifier si l'agence est active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si c'est l'agence principale
     */
    public function isMain()
    {
        return $this->type === 'main';
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

}