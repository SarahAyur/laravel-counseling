<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RescheduleResponsed extends Notification
{
    use Queueable;

    protected $konseling;
    protected $reschedule;
    protected $action;

    public function __construct($konseling, $reschedule, $action)
    {
        $this->konseling = $konseling;
        $this->reschedule = $reschedule;
        $this->action = $action;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Respon Pengajuan Reschedule')
            ->line('Mahasiswa telah merespon pengajuan reschedule:')
            ->line('Status: ' . ($this->action === 'approved' ? 'Disetujui' : 'Ditolak'))
            ->line('Mahasiswa: ' . $this->konseling->mahasiswa->name)
            ->when($this->action === 'approved', function ($message) {
                return $message
                    ->line('Jadwal yang disetujui:')
                    ->line('Tanggal: ' . $this->reschedule->new_tanggal)
                    ->line('Sesi: ' . $this->reschedule->newSesi->name . ' (' . $this->reschedule->newSesi->start_time . ' - ' . $this->reschedule->newSesi->end_time . ')');
            })
            ->action('Lihat Detail', route('konseling-konselor.show', $this->konseling->id));
    }
}