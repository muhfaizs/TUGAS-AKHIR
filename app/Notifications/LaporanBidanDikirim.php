<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaporanBidanDikirim extends Notification
{
    use Queueable;

    public $bidanName;

    public $periodeLaporan;

    /**
     * Create a new notification instance.
     */
    public function __construct($bidanName, $periodeLaporan)
    {
        $this->bidanName = $bidanName;
        $this->periodeLaporan = $periodeLaporan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'bidan_name' => $this->bidanName,
            'periode' => $this->periodeLaporan,
            'message' => 'Bidan '.$this->bidanName.' baru saja mengirimkan Laporan Dinkes ('.$this->periodeLaporan.')',
        ];
    }
}
