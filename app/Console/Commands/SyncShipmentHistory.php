<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shipment;
use App\Models\ShipmentTracking;
use App\Models\User;

class SyncShipmentHistory extends Command
{
    protected $signature = 'shipment:sync-history';
    protected $description = 'Sync missing shipment history for existing records';

    public function handle()
    {
        $shipments = Shipment::all();
        $count = 0;

        foreach ($shipments as $shipment) {
            // Check if already has any tracking
            if ($shipment->trackings()->count() === 0) {
                // Create Initial Tracking (Pending)
                ShipmentTracking::create([
                    'shipment_id' => $shipment->id,
                    'status' => 'pending',
                    'location' => $shipment->originLocation->name ?? 'Origin',
                    'description' => 'Paket telah diterima di cabang pengirim.',
                    'created_at' => $shipment->created_at,
                    'user_id' => $shipment->cashier_id ?? User::first()->id
                ]);

                // If status is already beyond pending, add current status history
                if ($shipment->status !== 'pending') {
                    ShipmentTracking::create([
                        'shipment_id' => $shipment->id,
                        'status' => $shipment->status,
                        'location' => $shipment->branch->city ?? 'Transit',
                        'description' => $this->getStatusDescription($shipment->status),
                        'created_at' => $shipment->updated_at,
                        'user_id' => $shipment->courier_id ?? $shipment->cashier_id ?? User::first()->id
                    ]);
                }
                $count++;
            }
        }

        $this->info("Successfully synced history for {$count} shipments.");
    }

    private function getStatusDescription($status)
    {
        return match ($status) {
            'ready_to_ship'  => 'Paket siap diberangkatkan ke kota tujuan.',
            'in_transit'     => 'Paket sedang dalam perjalanan (Transit).',
            'arrived_at_hub' => 'Paket telah sampai di pusat transit/hub.',
            'arrived_at_branch' => 'Paket telah sampai di cabang tujuan.',
            'out_for_delivery'=> 'Paket sedang dibawa kurir menuju alamat Anda.',
            'delivered'      => 'Paket telah berhasil diterima.',
            'failed_delivery'=> 'Gagal dalam pengiriman paket.',
            'returned_to_warehouse' => 'Paket dikembalikan ke gudang.',
            default          => 'Status pengiriman diperbarui.',
        };
    }
}
