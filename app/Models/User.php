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
        'role',
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

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin module
     */
    public function isAdminModul(): bool
    {
        return $this->role === 'admin_modul';
    }

    /**
     * Check if user is admin PPK Ormawa
     */
    public function isAdminPppOrmawa(): bool
    {
        return $this->role === 'admin_ppp_ormawa';
    }

    /**
     * Check if user is warga (citizen)
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    /**
     * Check if user is admin (any admin role)
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_modul', 'admin_ppp_ormawa']);
    }

    /**
     * Get user role label in Indonesian
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'admin_modul' => 'Admin Modul',
            'admin_ppp_ormawa' => 'Admin PPK Ormawa',
            'warga' => 'Warga',
            default => 'Unknown'
        };
    }
}
