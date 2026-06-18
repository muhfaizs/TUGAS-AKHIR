<?php

namespace App\Mail;

use App\Models\IbuHamil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderPemeriksaanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ibuHamil;

    public $tanggalKembali;

    public $catatan;

    /**
     * Create a new message instance.
     */
    public function __construct(IbuHamil $ibuHamil, $tanggalKembali, $catatan = null)
    {
        $this->ibuHamil = $ibuHamil;
        $this->tanggalKembali = $tanggalKembali;
        $this->catatan = $catatan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Jadwal Pemeriksaan Kehamilan - SatuKIA',
            replyTo: [
                new Address('bidan.puskesmas.bojongsoang@gmail.com', 'Puskesmas Bojongsoang'),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder-pemeriksaan',
            text: 'emails.reminder-pemeriksaan-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
