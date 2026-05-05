<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Shipment;

class PackageReturnedNotification extends Notification
{
    use Queueable;

    public function __construct(public Shipment $shipment) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title'   => 'Paket Dikembalikan ke Gudang',
            'message' => 'Paket ' . $this->shipment->tracking_number .
                         ' milik ' . $this->shipment->receiver_name .
                         ' dikembalikan ke gudang oleh kurir ' .
                         auth()->user()->name,
            'url'     => '/manager/gudang',
            'type'    => 'warning',
        ];
    }
}
