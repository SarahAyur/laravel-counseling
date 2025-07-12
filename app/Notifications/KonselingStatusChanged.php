<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class KonselingStatusChanged extends Notification
{
    use Queueable;

    protected $konseling;
    protected $status;

    public function __construct($konseling, $status)
    {
        $this->konseling = $konseling;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusMessage = $this->getStatusMessage();

        return (new MailMessage)
            ->subject('Status Konseling Diperbarui')
            ->line('Status konseling Anda telah diperbarui:')
            ->line($statusMessage)
            ->line('Tanggal: ' . $this->konseling->tanggal)
            ->line('Sesi: ' . $this->konseling->sesi->name . ' (' . $this->konseling->sesi->start_time . ' - ' . $this->konseling->sesi->end_time . ')')
            ->line('Konselor: ' . $this->konseling->konselor->name)
            ->action('Lihat Detail', route('konseling-mahasiswa.show', $this->konseling->id));
    }

    private function getStatusMessage()
    {
        switch($this->status) {
            case 'approved':
                return 'Konseling Anda telah disetujui.';
            case 'canceled':
                return 'Konseling Anda telah dibatalkan.';
            // case 'reschedule':
            //     return 'Konselor mengajukan perubahan jadwal konseling.';
            default:
                return 'Status konseling: ' . ucfirst($this->status);
        }
    }
}