<?php

namespace App\Models;

use App\Helpers\WhatsappHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    /**
     * Pengaduan uses the canonical table introduced by the public-service
     * refactor; keep the mapping explicit for the admin and public flows.
     */
    protected $table = 'laporans';

    /**
     * Kategori pengaduan yang sah beserta label Bahasa Indonesia.
     * Dipakai bersama oleh filter dan tampilan panel admin.
     *
     * @var array<string, string>
     */
    public const KATEGORI_LABELS = [
        'infrastruktur' => 'Infrastruktur & Fasilitas',
        'kependudukan' => 'Administrasi & Kependudukan',
        'keamanan' => 'Keamanan & Ketertiban',
        'lingkungan' => 'Lingkungan & Kebersihan',
        'layanan_publik' => 'Layanan Publik',
        'lainnya' => 'Lainnya',
    ];

    /**
     * Nilai status lama yang sudah menutup pengaduan.
     *
     * Alur admin saat ini hanya "Baru" dan "Riwayat", sehingga hanya dua nilai
     * lama ini yang diperlakukan sebagai selesai. Nilai lain ('baru', 'diproses')
     * tetap dibaca sebagai pengaduan yang belum diselesaikan supaya data lama tidak
     * hilang dari tab Baru.
     *
     * @var list<string>
     */
    public const COMPLETED_STATUSES = ['selesai', 'ditolak'];

    /**
     * Nilai status yang dipakai ketika pengaduan ditandai selesai.
     */
    public const COMPLETED_STATUS = 'selesai';

    protected $fillable = [
        'nama',
        'no_whatsapp',
        'kategori',
        'isi_laporan',
        'lampiran',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Daftar key kategori yang valid.
     *
     * @return list<string>
     */
    public static function kategoriList(): array
    {
        return array_keys(self::KATEGORI_LABELS);
    }

    /**
     * Pengaduan pada tab "Baru": belum ditandai selesai oleh admin.
     */
    public function scopeUnfinished(Builder $query): Builder
    {
        return $query->whereNotIn('status', self::COMPLETED_STATUSES);
    }

    /**
     * Pengaduan pada tab "Riwayat": sudah ditandai selesai oleh admin.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIn('status', self::COMPLETED_STATUSES);
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, self::COMPLETED_STATUSES, true);
    }

    /**
     * Tandai pengaduan selesai sehingga berpindah dari tab "Baru" ke "Riwayat".
     */
    public function markCompleted(): void
    {
        $this->forceFill(['status' => self::COMPLETED_STATUS])->save();
    }

    /**
     * Label kategori dalam Bahasa Indonesia.
     */
    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI_LABELS[$this->kategori]
            ?? ucfirst(str_replace('_', ' ', (string) $this->kategori));
    }

    /**
     * Nomor WhatsApp pelapor dalam format internasional (62xxxxxxxxxx).
     */
    public function getWhatsappNumberAttribute(): ?string
    {
        return WhatsappHelper::normalize($this->no_whatsapp);
    }

    /**
     * Tautan wa.me untuk menghubungi pelapor.
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        return WhatsappHelper::link($this->no_whatsapp);
    }
}
