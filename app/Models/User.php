<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    // The professor's schema has no updated_at column.
    public $timestamps = false;

    protected $fillable = [
        'username',
        'full_name',
        'password',
        'avatar',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'created_at' => 'datetime',
    ];

    // Sales recorded by this staff member
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'sold_by');
    }

    // Use full_name instead of Laravel's default name field
    public function getNameAttribute(): string
    {
        return $this->full_name;
    }
}
