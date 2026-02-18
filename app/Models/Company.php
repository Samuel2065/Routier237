<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'director_id',
        'manager_id',
        'name',
        'acronym',
        'slug',
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

    protected static function booted()
    {
        static::creating(function (Company $company) {
            if (!empty($company->slug)) {
                return;
            }

            $baseSlug = Str::slug($company->name);
            $slug = $baseSlug;
            $suffix = 1;

            while (DB::table('companies')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $suffix;
                $suffix++;
            }

            $company->slug = $slug;
        });
    }

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
