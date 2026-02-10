<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'agency_id',
        'first_name',
        'last_name',
        'position',
        'employee_number',
        'hire_date',
        'base_salary',
        'id_card_number',
        'marital_status',
        'number_of_children',
        'emergency_contact',
        'address',
    ];

    /**
     * Related user account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Agency assignment
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Driver profile if this employee is a driver
     */
    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
}
