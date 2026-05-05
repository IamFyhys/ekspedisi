<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Shipment;
use App\Models\User;

$couriers = User::whereIn('role', ['courier_delivery', 'courier'])->get();
echo "=== COURIERS ===\n";
foreach ($couriers as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Role: {$c->role}\n";
}

echo "\n=== RETURNED TO WAREHOUSE ===\n";
$returned = Shipment::where('status', 'returned_to_warehouse')->get();
echo "Total returned: " . $returned->count() . "\n";
foreach ($returned as $s) {
    echo "Shipment ID: {$s->id} | tracking: {$s->tracking_number} | courier_id: {$s->courier_id} | failed_at: {$s->failed_at} | failed_reason: {$s->failed_reason}\n";
}

echo "\n=== ALL STATUS SUMMARY ===\n";
$all = Shipment::selectRaw('status, courier_id, COUNT(*) as total')
    ->groupBy('status', 'courier_id')
    ->get();
foreach ($all as $row) {
    echo "Status: {$row->status} | courier_id: {$row->courier_id} | count: {$row->total}\n";
}
