<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class MagicLoginMail extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(public string $token, public ?string $status = null, public ?string $excerpt = null) {}
    public function envelope(): Envelope { return new Envelope(subject: $this->status ? 'Pembaruan laporan pengaduan' : 'Tautan masuk Cek Laporan Saya'); }
    public function content(): Content { return new Content(view: 'emails.magic-login'); }
}
