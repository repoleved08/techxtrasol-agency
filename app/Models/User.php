<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_EDITOR = 'EDITOR';
    const ROLE_USER = 'USER';
    // Define roles as constants
    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_USER => 'User',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin(); // or $this->can('viewAdmin');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added role attribute
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
