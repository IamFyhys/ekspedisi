<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Location;
use App\Models\Subdistrict;
use App\Models\Rate;
use App\Models\User;
use App\Models\Shipment;
use App\Models\ShipmentTracking;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExpeditionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Branches
        $jakarta = Branch::create(['name' => 'Cabang Jakarta Pusat', 'city' => 'Jakarta', 'address' => 'Jl. Thamrin No. 1', 'phone' => '021-1234567']);
        $surabaya = Branch::create(['name' => 'Cabang Surabaya', 'city' => 'Surabaya', 'address' => 'Jl. Tunjungan No. 10', 'phone' => '031-7654321']);
        $bandung = Branch::create(['name' => 'Cabang Bandung', 'city' => 'Bandung', 'address' => 'Jl. Asia Afrika No. 5', 'phone' => '022-1112223']);

        // 2. Locations & Subdistricts
        $locJakarta = Location::create(['name' => 'Jakarta', 'province' => 'DKI Jakarta']);
        $locSurabaya = Location::create(['name' => 'Surabaya', 'province' => 'Jawa Timur']);
        $locBandung = Location::create(['name' => 'Bandung', 'province' => 'Jawa Barat']);

        $subGambir = Subdistrict::create(['location_id' => $locJakarta->id, 'name' => 'Gambir']);
        $subMenteng = Subdistrict::create(['location_id' => $locJakarta->id, 'name' => 'Menteng']);
        $subTegalsari = Subdistrict::create(['location_id' => $locSurabaya->id, 'name' => 'Tegalsari']);
        $subSumur = Subdistrict::create(['location_id' => $locBandung->id, 'name' => 'Sumur Bandung']);

        // 3. Rates
        Rate::create(['origin_location_id' => $locJakarta->id, 'destination_location_id' => $locSurabaya->id, 'price_per_kg' => 15000, 'estimated_days' => 3]);
        Rate::create(['origin_location_id' => $locJakarta->id, 'destination_location_id' => $locBandung->id, 'price_per_kg' => 8000, 'estimated_days' => 1]);
        Rate::create(['origin_location_id' => $locSurabaya->id, 'destination_location_id' => $locJakarta->id, 'price_per_kg' => 15000, 'estimated_days' => 3]);
        
        // 4. USERS FOR EACH ROLE
        // ADMIN
        User::create([
            'name' => 'Admin Pusat',
            'email' => 'admin@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active'
        ]);

        // MANAGER
        $manager = User::create([
            'name' => 'Manager Jakarta',
            'email' => 'manager@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'branch_id' => $jakarta->id,
            'status' => 'active'
        ]);

        // CASHIER
        $cashier = User::create([
            'name' => 'Kasir Jakarta',
            'email' => 'cashier@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'branch_id' => $jakarta->id,
            'status' => 'active'
        ]);

        // COURIER TRANSIT
        $courierTransit = User::create([
            'name' => 'Kurir Transit JKT-SBY',
            'email' => 'transit@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'courier_transit',
            'branch_id' => $jakarta->id,
            'status' => 'active'
        ]);

        // COURIER DELIVERY
        $courierDelivery = User::create([
            'name' => 'Kurir Delivery SBY',
            'email' => 'delivery@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'courier_delivery',
            'branch_id' => $surabaya->id,
            'status' => 'active'
        ]);

        // CUSTOMER
        User::create([
            'name' => 'Budi Customer',
            'email' => 'customer@expedisi.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'status' => 'active'
        ]);

        // 5. STAFF APPLICATIONS (DUMMY FOR MANAGER REVIEW)
        User::create([
            'name' => 'Pelamar Baru',
            'email' => 'pelamar@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'courier_delivery',
            'branch_id' => $jakarta->id,
            'status' => 'pending', // Waiting for Manager Jakarta
            'phone' => '08123456780',
            'address' => 'Jl. Pelamar No. 1',
            'experience' => 'Pernah kerja di JNE 2 tahun',
            'ktp_photo' => 'staff-documents/ktp/dummy.jpg',
            'selfie_photo' => 'staff-documents/selfie/dummy.jpg'
        ]);

        User::create([
            'name' => 'Pelamar Direview',
            'email' => 'review@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'branch_id' => $jakarta->id,
            'status' => 'review', // Forwarded by Manager to Admin
            'reviewed_by' => $manager->id,
            'reviewed_at' => now(),
            'phone' => '08123456781',
            'address' => 'Jl. Review No. 2',
        ]);

        // 6. SHIPMENTS WORKFLOW DATA
        // Shipment A: Just created (at Jakarta, target Surabaya)
        $shipmentA = Shipment::create([
            'tracking_number' => 'EXP-JKT-001',
            'sender_name' => 'Budi Jakarta',
            'sender_phone' => '0811111111',
            'origin_location_id' => $locJakarta->id,
            'origin_subdistrict_id' => $subGambir->id,
            'receiver_name' => 'Ani Surabaya',
            'receiver_phone' => '0822222222',
            'receiver_address' => 'Jl. Tunjungan No. 5',
            'destination_location_id' => $locSurabaya->id,
            'destination_subdistrict_id' => $subTegalsari->id,
            'item_name' => 'Buku Pelajaran',
            'weight' => 2000,
            'total_price' => 30000,
            'status' => 'pending',
            'payment_status' => 'paid',
            'branch_id' => $jakarta->id,
            'cashier_id' => $cashier->id,
            'payment_method' => 'cash'
        ]);

        ShipmentTracking::create([
            'shipment_id' => $shipmentA->id,
            'status' => 'pending',
            'location' => 'Cabang Jakarta Pusat',
            'description' => 'Paket telah diterima di Cabang Jakarta.',
            'user_id' => $cashier->id
        ]);

        // Shipment B: In Transit (on the way to Surabaya)
        $shipmentB = Shipment::create([
            'tracking_number' => 'EXP-JKT-002',
            'sender_name' => 'Dedi Jakarta',
            'sender_phone' => '0811111112',
            'origin_location_id' => $locJakarta->id,
            'origin_subdistrict_id' => $subGambir->id,
            'receiver_name' => 'Rina Surabaya',
            'receiver_phone' => '0822222223',
            'receiver_address' => 'Jl. Surabaya No. 10',
            'destination_location_id' => $locSurabaya->id,
            'destination_subdistrict_id' => $subTegalsari->id,
            'item_name' => 'Pakaian Elektronik',
            'weight' => 1000,
            'total_price' => 15000,
            'status' => 'in_transit',
            'payment_status' => 'paid',
            'branch_id' => $jakarta->id,
            'cashier_id' => $cashier->id,
            'payment_method' => 'cash'
        ]);

        ShipmentTracking::create(['shipment_id' => $shipmentB->id, 'status' => 'pending', 'location' => 'Jakarta', 'description' => 'Paket diterima.']);
        ShipmentTracking::create([
            'shipment_id' => $shipmentB->id,
            'status' => 'in_transit',
            'location' => 'Dalam Perjalanan JKT-SBY',
            'description' => 'Paket sedang dibawa oleh Kurir Transit.',
            'user_id' => $courierTransit->id
        ]);

        // Shipment C: Arrived at Surabaya (Waiting for Delivery)
        $shipmentC = Shipment::create([
            'tracking_number' => 'EXP-JKT-003',
            'sender_name' => 'Eko Jakarta',
            'sender_phone' => '0811111113',
            'origin_location_id' => $locJakarta->id,
            'origin_subdistrict_id' => $subGambir->id,
            'receiver_name' => 'Siti Surabaya',
            'receiver_phone' => '0822222224',
            'receiver_address' => 'Jl. Surabaya Indah No. 1',
            'destination_location_id' => $locSurabaya->id,
            'destination_subdistrict_id' => $subTegalsari->id,
            'item_name' => 'Sepatu Olahraga',
            'weight' => 1000,
            'total_price' => 15000,
            'status' => 'arrived',
            'payment_status' => 'paid',
            'branch_id' => $surabaya->id, // Now at Surabaya branch
            'cashier_id' => $cashier->id,
            'payment_method' => 'cash'
        ]);

        ShipmentTracking::create(['shipment_id' => $shipmentC->id, 'status' => 'pending', 'location' => 'Jakarta', 'description' => 'Paket diterima.']);
        ShipmentTracking::create(['shipment_id' => $shipmentC->id, 'status' => 'in_transit', 'location' => 'Transit', 'description' => 'Dalam perjalanan.']);
        ShipmentTracking::create([
            'shipment_id' => $shipmentC->id,
            'status' => 'arrived',
            'location' => 'Cabang Surabaya',
            'description' => 'Paket telah sampai di Cabang Surabaya.',
        ]);

        // 7. CASH DRAWER & SHIFTS
        \App\Models\CashDrawer::create([
            'branch_id' => $jakarta->id,
            'date' => now()->toDateString(),
            'starting_balance' => 1000000,
            'current_balance' => 1045000,
            'status' => 'open'
        ]);

        \App\Models\Shift::create([
            'user_id' => $cashier->id,
            'branch_id' => $jakarta->id,
            'start_time' => now()->subHours(2),
            'status' => 'active'
        ]);
    }
}
