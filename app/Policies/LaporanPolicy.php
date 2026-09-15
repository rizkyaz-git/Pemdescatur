<?php
namespace App\Policies;

use App\Models\Laporan;
use App\Models\Pelapor;

class LaporanPolicy
{
    /** The session-authenticated pelapor is the sole public-side owner. */
    public function view(Pelapor $pelapor, Laporan $laporan): bool
    {
        return hash_equals((string) $pelapor->id, (string) $laporan->pelapor_id);
    }
}
