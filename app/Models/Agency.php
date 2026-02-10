<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'city_id',
        'manager_id',
        'name',
        'district',
        'full_address',
        'phone',
        'email',
        'agency_code',
        'type',
        'status',
        'approval_status',
    ];

    protected static function booted()
    {
        static::creating(function (Agency $agency) {
            if (empty($agency->slug)) {
                $baseSlug = Str::slug($agency->name);
                $slug = $baseSlug;
                $suffix = 1;

                while (DB::table('agencies')->where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $suffix;
                    $suffix++;
                }

                $agency->slug = $slug;
            }

            if (empty($agency->city_id)) {
                $defaultCityId = DB::table('cities')
                    ->where('status', 'active')
                    ->orderBy('id')
                    ->value('id');

                if ($defaultCityId) {
                    $agency->city_id = $defaultCityId;
                }
            }
        });
    }

    /**
     * Company that owns this agency
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * City where this agency is located
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Manager of this agency
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Trips operated by this agency
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Alias for trips used in some controllers
     */
    public function departureTrips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Reservations sold by this agency
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'sales_agency_id');
    }

    /**
     * Employees working at this agency
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Cash registers for this agency
     */
    public function cashRegisters()
    {
        return $this->hasMany(CashRegister::class);
    }

    /**
     * Expenses for this agency
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
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
}
