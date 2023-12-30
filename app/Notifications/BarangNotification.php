<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;

class BarangNotification extends Notification
{
    use Queueable;

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }


    public function via($notifiable)
    {
        return ['database']; // Atau 'mail' atau cara lainnya jika diperlukan
    }

    public function toDatabase($notifiable)
    {
        $message = '';

        if ($this->type === 'barang') {
            $message = 'Barang baru telah ditambahkan!';
        } elseif ($this->type === 'barang_masuk') {
            $message = 'Ada barang masuk!';
        } elseif ($this->type === 'barang_keluar') {
            $message = 'Ada barang keluar!';
        }

        return [
            'message' => $message,
            'created_at' => now(),
        ];
    }
}
