<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withPivot('restaurant_id');
    }

    public function restaurants()
    {
        return $this->belongsToMany(
            Restaurant::class,
            'user_roles',
            'user_id',
            'restaurant_id'
        )->distinct();
    }

    public function hasRestaurantRole(int $restaurantId, string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return $this->userRoles()
            ->where('restaurant_id', $restaurantId)
            ->whereHas('role', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })
            ->exists();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'created_by_user_id');
    }
}
