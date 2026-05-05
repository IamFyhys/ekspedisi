<?php

namespace App\Observers;

use App\Models\Shipment;
use App\Models\ShipmentTracking;
use Illuminate\Support\Facades\Auth;

class ShipmentObserver
{
    public function created(Shipment $shipment): void
    {
        ShipmentTracking::create([
            'shipment_id' => $shipment->id,
            'status' => 'pending',
            'location' => $shipment->branch?->city ?? 'Origin',
            'description' => 'Paket telah diterima di cabang pengirim.',
            'user_id' => Auth::id()
        ]);
    }

    public function updated(Shipment $shipment): void
    {
        if ($shipment->isDirty('status')) {
            ShipmentTracking::create([
                'shipment_id' => $shipment->id,
                'status' => $shipment->status,
                'location' => Auth::user()?->branch?->city ?? 'Transit',
                'description' => $this->getStatusDescription($shipment->status),
                'user_id' => Auth::id()
            ]);
        }
    }

    private function getStatusDescription($status)
    {
        return match ($status) {
            'pending' => 'Paket telah diterima di cabang pengirim.',
            'ready_to_ship' => 'Paket siap diberangkatkan ke kota tujuan.',
            'in_transit' => 'Paket sedang dalam perjalanan (Transit).',
            'arrived_at_hub' => 'Paket telah sampai di pusat transit/hub.',
            'arrived_at_branch' => 'Paket telah sampai di cabang tujuan.',
            'out_for_delivery' => 'Paket sedang dibawa kurir menuju alamat Anda.',
            'delivered' => 'Paket telah berhasil diterima.',
            'failed_delivery' => 'Gagal dalam pengiriman paket.',
            'returned_to_warehouse' => 'Paket dikembalikan ke gudang.',
            'assigned' => 'Kurir telah ditugaskan untuk mengantar paket.',
            'cancelled' => 'Pengiriman dibatalkan.',
            default => 'Status pengiriman diperbarui.',
        };
    }
}
