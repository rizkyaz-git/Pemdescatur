<?php
namespace App\Services;

use App\Models\Laporan;
use App\Models\LoginToken;
use App\Models\Pelapor;
use Illuminate\Support\Str;

class MagicLinkService
{
    /** @return array{0: LoginToken, 1: string} */
    public function create(Pelapor $pelapor, string $purpose, int $minutes, ?Laporan $laporan = null): array
    {
        $token = Str::random(40);
        $record = LoginToken::create([
            'pelapor_id' => $pelapor->id,
            'email' => $pelapor->email,
            'token_hash' => hash('sha256', $token),
            'laporan_id' => $laporan?->id,
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes($minutes),
        ]);
        return [$record, $token];
    }
}
