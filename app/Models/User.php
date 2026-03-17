<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'user_type',
        'role_id',
        'status',
        'photo',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relation avec Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation avec Client (pour les customers)
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Relation avec Employee (pour les staff)
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Relation avec Company (pour les directeurs)
     */
    public function managedCompany()
    {
        return $this->hasOne(Company::class, 'director_id');
    }

    /**
     * Relation avec Agency (pour les managers d'agence)
     */
    public function managedAgency()
    {
        return $this->hasOne(Agency::class, 'manager_id');
    }

    /**
     * Reservations créées par l'utilisateur
     */
    public function createdReservations()
    {
        return $this->hasMany(Reservation::class, 'reserved_by');
    }

    /**
     * Transactions effectuées par l'utilisateur
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'performed_by');
    }

    /**
     * Vérifier si l'utilisateur a une permission
     */
    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('name', $permission)->exists();
    }

    /**
     * Vérifier si l'utilisateur a un rôle
     */
    public function hasRole($roleSlug)
    {
        return $this->role->slug === $roleSlug;
    }

    /**
     * Obtenir la route du dashboard selon le rôle
     */
    public function getDashboardRoute()
    {
        $roleRoutes = [
            'super_admin' => '/super-admin/dashboard',
            'director' => '/director/dashboard',
            'agency_manager' => '/agency/dashboard',
            'counter_clerk' => '/clerk/dashboard',
            'accountant' => '/accountant/dashboard',
            'driver' => '/driver/dashboard',
            'customer' => '/customer/dashboard',
        ];

        return $roleRoutes[$this->role->slug] ?? '/';
    }

    /**
     * Vérifier si l'utilisateur est actif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Vérifier si l'utilisateur est un staff
     */
    public function isStaff()
    {
        return $this->user_type === 'staff';
    }

    /**
     * Vérifier si l'utilisateur est un customer
     */
    public function isCustomer()
    {
        return $this->user_type === 'customer';
    }
}
