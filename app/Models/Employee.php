<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $casts = [
        'hire_date' => 'date',
        'base_salary' => 'decimal:2',
        'number_of_children' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
}
