<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginToken extends Model
{
    public const VERIFY_LAPORAN = 'verify_laporan';
    public const MAGIC_LOGIN = 'magic_login';
    public const NOTIFICATION_LOGIN = 'notification_login';
    protected $fillable = ['pelapor_id', 'email', 'token_hash', 'laporan_id', 'purpose', 'expires_at', 'is_used', 'used_at'];
    protected $hidden = ['token_hash'];
    protected function casts(): array { return ['expires_at' => 'datetime', 'used_at' => 'datetime', 'is_used' => 'boolean']; }
    public function pelapor(): BelongsTo { return $this->belongsTo(Pelapor::class); }
    public function laporan(): BelongsTo { return $this->belongsTo(Laporan::class); }
}
