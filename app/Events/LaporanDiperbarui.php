<?php
namespace App\Events;
use App\Models\Laporan;
use App\Models\LaporanTanggapan;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class LaporanDiperbarui
{
    use Dispatchable, SerializesModels;
    public function __construct(public Laporan $laporan, public ?LaporanTanggapan $tanggapan = null) {}
}
