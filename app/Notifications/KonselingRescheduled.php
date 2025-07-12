<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class KonselingRescheduled extends Notification
{
    use Queueable;

    protected $konseling;
    protected $reschedule;

    public function __construct($konseling, $reschedule)
    {
        $this->konseling = $konseling;
        $this->reschedule = $reschedule;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengajuan Perubahan Jadwal Konseling')
            ->line('Konselor mengajukan perubahan jadwal konseling:')
            ->line('Jadwal Lama:')
            ->line('Tanggal: ' . $this->reschedule->old_tanggal)
            ->line('Sesi: ' . $this->reschedule->oldSesi->name . ' (' . $this->reschedule->oldSesi->start_time . ' - ' . $this->reschedule->oldSesi->end_time . ')')
            ->line('Jadwal Baru:')
            ->line('Tanggal: ' . $this->reschedule->new_tanggal)
            ->line('Sesi: ' . $this->reschedule->newSesi->name . ' (' . $this->reschedule->newSesi->start_time . ' - ' . $this->reschedule->newSesi->end_time . ')')
            ->action('Lihat Detail', route('konseling-mahasiswa.show', $this->konseling->id));
    }
}