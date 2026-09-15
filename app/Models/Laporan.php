<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    use HasUuids;
    public const STATUSES = ['pending_verification', 'diterima', 'diproses', 'selesai', 'ditolak'];
    protected $fillable = ['pelapor_id', 'kategori', 'isi_laporan', 'lampiran', 'status', 'catatan_admin'];
    public function pelapor(): BelongsTo { return $this->belongsTo(Pelapor::class); }
    public function tanggapans(): HasMany { return $this->hasMany(LaporanTanggapan::class); }
    public function loginTokens(): HasMany { return $this->hasMany(LoginToken::class); }
}
