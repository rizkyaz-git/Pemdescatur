<?php
namespace App\Listeners;
use App\Events\LaporanDiperbarui;
use App\Mail\MagicLoginMail;
use App\Models\LoginToken;
use App\Services\MagicLinkService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
class KirimNotifikasiEmailPelapor implements ShouldQueue
{
    public function handle(LaporanDiperbarui $event): void
    {
        $laporan = $event->laporan->fresh(['pelapor']);
        if (!$laporan || !$laporan->pelapor) return;
        [, $token] = app(MagicLinkService::class)->create($laporan->pelapor, LoginToken::NOTIFICATION_LOGIN, 15, $laporan);
        $excerpt = $event->tanggapan?->isi_tanggapan ? str($event->tanggapan->isi_tanggapan)->limit(160)->toString() : null;
        Mail::to($laporan->pelapor->email)->send(new MagicLoginMail($token, $laporan->status, $excerpt));
    }
}
