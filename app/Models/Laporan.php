<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_whatsapp',
        'kategori',
        'isi_laporan',
        'lampiran',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get status label dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'baru'     => 'Baru',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => 'Tidak Diketahui',
        };
    }

    /**
     * Get CSS class for status badge
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'baru'     => 'bg-rose-50 text-rose-700 border-rose-200/60',
            'diproses' => 'bg-amber-50 text-amber-800 border-amber-200/60',
            'selesai'  => 'bg-green-50 text-green-700 border-green-200/60',
            'ditolak'  => 'bg-slate-100 text-slate-600 border-slate-200/60',
            default    => 'bg-slate-100 text-slate-600',
        };
    }
}
