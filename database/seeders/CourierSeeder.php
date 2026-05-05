<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use App\Models\Shipment;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\Hash;

class CourierSeeder extends Seeder
{
    public function run()
    {
        // 1. Ambil atau Buat Branch
        $branchAsal = Branch::updateOrCreate(
            ['city' => 'Surabaya'],
            ['name' => 'Hub Surabaya', 'address' => 'Jl. Pahlawan No. 1', 'phone' => '031-123456']
        );

        $branchTujuan = Branch::updateOrCreate(
            ['city' => 'Jakarta'],
            ['name' => 'Hub Jakarta', 'address' => 'Jl. Gatot Subroto No. 10', 'phone' => '021-987654']
        );

        // 2. Ambil atau Buat Location & Subdistrict
        $locSurabaya = Location::updateOrCreate(['name' => 'Surabaya'], ['province' => 'Jawa Timur']);
        $subSurabaya = Subdistrict::updateOrCreate(['name' => 'Wonokromo'], ['location_id' => $locSurabaya->id]);

        $locJakarta = Location::updateOrCreate(['name' => 'Jakarta'], ['province' => 'DKI Jakarta']);
        $subJakarta = Subdistrict::updateOrCreate(['name' => 'Gambir'], ['location_id' => $locJakarta->id]);

        // ═══════════════════════════════════════
        // KURIR accounts
        // ═══════════════════════════════════════

        User::updateOrCreate(['email' => 'transit@expedisi.com'], [
            'name' => 'Transit Utama', 'password' => Hash::make('password'), 'role' => 'courier_transit', 'status' => 'active', 'branch_id' => $branchAsal->id,
        ]);
        User::updateOrCreate(['email' => 'delivery@expedisi.com'], [
            'name' => 'Delivery Utama', 'password' => Hash::make('password'), 'role' => 'courier_delivery', 'status' => 'active', 'branch_id' => $branchTujuan->id,
        ]);

        // ═══════════════════════════════════════
        // PAKET DUMMY
        // ═══════════════════════════════════════

        $transit  = User::where('email', 'transit@expedisi.com')->first();
        $kasir    = User::where('role', 'cashier')->first() ?? User::factory()->create(['role' => 'cashier', 'branch_id' => $branchAsal->id]);

        $baseShipment = [
            'origin_location_id' => $locSurabaya->id,
            'origin_subdistrict_id' => $subSurabaya->id,
            'destination_location_id' => $locJakarta->id,
            'destination_subdistrict_id' => $subJakarta->id,
            'item_name' => 'Paket Elektronik',
            'cashier_id' => $kasir->id,
        ];

        // Paket 4 — in_transit
        Shipment::updateOrCreate(['tracking_number' => 'EXP-2026-TRANS01'], array_merge($baseShipment, [
            'sender_name' => 'Pengirim Empat', 'sender_phone' => '08111111114',
            'receiver_name' => 'Penerima Empat', 'receiver_phone' => '08222222224',
            'receiver_address' => 'Jl. Kemang No. 3, Jakarta', 'weight' => 2, 'total_price' => 45000,
            'payment_method' => 'cash', 'payment_status' => 'paid', 'status' => 'in_transit',
            'branch_id' => $branchAsal->id, 'courier_id' => $transit->id, 'departed_at' => now()->subHours(4),
        ]));

        // Paket 5 — in_transit (COD)
        Shipment::updateOrCreate(['tracking_number' => 'EXP-2026-TRANS02'], array_merge($baseShipment, [
            'sender_name' => 'Pengirim Lima', 'sender_phone' => '08111111115',
            'receiver_name' => 'Penerima Lima', 'receiver_phone' => '08222222225',
            'receiver_address' => 'Jl. Blok M No. 7, Jakarta', 'weight' => 4, 'total_price' => 70000,
            'payment_method' => 'cod', 'payment_status' => 'unpaid', 'status' => 'in_transit',
            'branch_id' => $branchAsal->id, 'courier_id' => $transit->id, 'departed_at' => now()->subHours(4),
        ]));

        // Trip dummy
        $trip = Trip::updateOrCreate(['courier_id' => $transit->id, 'status' => 'on_the_way'], [
            'origin_branch_id' => $branchAsal->id,
            'destination_branch_id' => $branchTujuan->id,
            'total_packages' => 2,
            'total_received' => 0,
            'departed_at' => now()->subHours(4),
        ]);

        Shipment::whereIn('tracking_number', ['EXP-2026-TRANS01', 'EXP-2026-TRANS02'])->update(['trip_id' => $trip->id]);
    }
}
