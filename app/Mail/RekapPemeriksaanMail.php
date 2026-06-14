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

class RekapPemeriksaanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ibuHamil;

    public $pdfContent;
    
    public $tanggalBerikutnya;

    /**
     * Create a new message instance.
     */
    public function __construct(IbuHamil $ibuHamil, $pdfContent, $tanggalBerikutnya = null)
    {
        $this->ibuHamil = $ibuHamil;
        $this->pdfContent = $pdfContent;
        $this->tanggalBerikutnya = $tanggalBerikutnya;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Hasil Rekapitulasi Pemeriksaan Kehamilan (ANC) - SatuKIA',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rekap-pemeriksaan',
            text: 'emails.rekap-pemeriksaan-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => base64_decode($this->pdfContent), 'Rekap_Pemeriksaan_ANC_'.str_replace(' ', '_', $this->ibuHamil->nama_lengkap).'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
