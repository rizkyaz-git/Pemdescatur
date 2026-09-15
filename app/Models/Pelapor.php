<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelapor extends Authenticatable
{
    use HasUuids;
    protected $fillable = ['nama', 'nik_hash', 'email'];
    protected $hidden = ['nik_hash'];
    public function laporans(): HasMany { return $this->hasMany(Laporan::class); }
    public function loginTokens(): HasMany { return $this->hasMany(LoginToken::class); }
}
