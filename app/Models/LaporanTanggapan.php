<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class LaporanTanggapan extends Model
{
    protected $fillable = ['laporan_id', 'admin_id', 'isi_tanggapan', 'status_baru'];
    public function laporan(): BelongsTo { return $this->belongsTo(Laporan::class); }
    public function admin(): BelongsTo { return $this->belongsTo(User::class, 'admin_id'); }
}
