<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class KonselingRequested extends Notification
{
    use Queueable;

    protected $konseling;

    public function __construct($konseling)
    {
        $this->konseling = $konseling;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengajuan Konseling Baru')
            ->line('Ada pengajuan konseling baru:')
            ->line('Mahasiswa: ' . $this->konseling->mahasiswa->name)
            ->line('Tanggal: ' . $this->konseling->tanggal)
            ->line('Sesi: ' . $this->konseling->sesi->name . ' (' . $this->konseling->sesi->start_time . ' - ' . $this->konseling->sesi->end_time . ')')
            ->line('Topik: ' . $this->konseling->topik)
            ->action('Lihat Detail', route('konseling-konselor.index'));
    }
}