<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * USER ATTRIBUTES
     *
     * $this->attributes['id'] - int - contains the user primary key (id)
     * $this->attributes['name'] - string - contains the user name
     * $this->attributes['email'] - string - contains the user email
     * $this->attributes['password'] - string - contains the user password
     * $this->attributes['role'] - string - contains the user role
     * $this->attributes['is_admin'] - bool - contains the user admin status
     *
     * RELATIONSHIPS
     *
     * Review - hasMany
     * Order - hasMany
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // GETTERS & SETTERS

    public function getReviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getOrders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = $password;
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->attributes['is_admin'] = $isAdmin;
    }

    public function getIsAdmin(): bool
    {
        return $this->attributes['is_admin'];
    }
}
