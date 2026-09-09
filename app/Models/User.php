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
        'avatar',
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
     * Check if user is admin pemdes
     */
    public function isAdminPemdes(): bool
    {
        return $this->role === 'admin_pemdes' || $this->role === 'admin_modul';
    }

    /**
     * Check if user is admin PPK Ormawa
     */
    public function isPpkOrmawa(): bool
    {
        return $this->role === 'ppk_ormawa' || $this->role === 'admin_ppp_ormawa';
    }

    /**
     * Backward compatibility aliases
     */
    public function isAdminModul(): bool
    {
        return $this->isAdminPemdes();
    }

    public function isAdminPppOrmawa(): bool
    {
        return $this->isPpkOrmawa();
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
        return in_array($this->role, ['super_admin', 'admin_pemdes', 'ppk_ormawa', 'admin_modul', 'admin_ppp_ormawa']);
    }

    /**
     * Permission helpers
     */
    public function canManageSettings(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canAccessVillageProfile(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminPemdes();
    }

    public function canAccessOfficials(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminPemdes();
    }

    public function canAccessGalleries(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminPemdes();
    }

    public function canAccessPublicServices(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminPemdes();
    }

    public function canAccessPpko(): bool
    {
        return $this->isSuperAdmin() || $this->isPpkOrmawa();
    }

    public function canAccessNews(): bool
    {
        return $this->isSuperAdmin() || $this->isAdminPemdes() || $this->isPpkOrmawa();
    }

    /**
     * Get avatar url
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }
        return null;
    }

    /**
     * Get user role label in Indonesian
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'admin_pemdes' => 'Admin Pemdes',
            'ppk_ormawa' => 'PPK Ormawa',
            'admin_modul' => 'Admin Pemdes',
            'admin_ppp_ormawa' => 'PPK Ormawa',
            'warga' => 'Warga',
            default => 'Operator'
        };
    }
}
