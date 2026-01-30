<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'license_number',
        'license_category',
        'license_issue_date',
        'license_expiry_date',
        'insurance_number',
        'years_experience',
        'status',
    ];

    protected $casts = [
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
        'years_experience' => 'integer',
    ];

    /**
     * Relation avec Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relation avec User via Employee
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Employee::class, 'id', 'id', 'employee_id', 'user_id');
    }

    /**
     * Relation avec Agency via Employee
     */
    public function agency()
    {
        return $this->hasOneThrough(Agency::class, Employee::class, 'id', 'id', 'employee_id', 'agency_id');
    }

    /**
     * Relation avec Trips
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Vérifier si le permis est expiré
     */
    public function isLicenseExpired()
    {
        return $this->license_expiry_date < now();
    }

    /**
     * Vérifier si le conducteur est disponible
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}