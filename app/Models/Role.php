<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the users for the role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the permissions for the role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()
            ->where('name', $permissionName)
            ->exists();
    }

    /**
     * Assign permission to role
     */
    public function givePermission(Permission $permission)
    {
        return $this->permissions()->syncWithoutDetaching($permission);
    }

    /**
     * Remove permission from role
     */
    public function revokePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}