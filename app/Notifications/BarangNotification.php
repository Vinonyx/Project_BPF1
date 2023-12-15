<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;

class BarangNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['database']; // Atau 'mail' atau cara lainnya jika diperlukan
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Barang baru telah ditambahkan!',
            'created_at' => now(),
            // Informasi lain yang ingin Anda tampilkan
        ];
    }
}
