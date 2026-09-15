<?php
namespace App\Mail;
use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class VerifikasiLaporanMail extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(public Laporan $laporan, public string $token) {}
    public function envelope(): Envelope { return new Envelope(subject: 'Verifikasi laporan pengaduan Anda'); }
    public function content(): Content { return new Content(view: 'emails.laporan-verifikasi'); }
}
