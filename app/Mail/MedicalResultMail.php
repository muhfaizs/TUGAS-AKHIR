<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicalResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pesan;

    public $pdfData;

    public $pdfName;

    /**
     * Create a new message instance.
     */
    public function __construct($pesan, $pdfData, $pdfName)
    {
        $this->pesan = $pesan;
        $this->pdfData = $pdfData;
        $this->pdfName = $pdfName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hasil Pemeriksaan / Imunisasi Anak',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.medical_result',
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
            Attachment::fromData(fn () => $this->pdfData, $this->pdfName)
                ->withMime('application/pdf'),
        ];
    }
}
