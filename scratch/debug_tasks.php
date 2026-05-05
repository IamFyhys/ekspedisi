<?php
use App\Models\PickupRequest;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;

// Assuming we want to check for courier with ID 1 or the first courier found
$courier = \App\Models\User::whereIn('role', ['courier_delivery', 'courier_pickup'])->first();

if (!$courier) {
    echo "No courier found\n";
    exit;
}

echo "Courier: " . $courier->name . " (ID: " . $courier->id . ")\n";

$deliveries = Shipment::where('courier_id', $courier->id)
    ->whereIn('status', ['assigned', 'out_for_delivery'])
    ->count();

$pickups = PickupRequest::where('courier_id', $courier->id)
    ->whereIn('status', ['assigned_pickup', 'on_the_way', 'picked_up'])
    ->count();

echo "Deliveries: " . $deliveries . "\n";
echo "Pickups: " . $pickups . "\n";

$allPickups = PickupRequest::all()->count();
echo "Total Pickups in DB: " . $allPickups . "\n";

$unassignedPickups = PickupRequest::where('status', 'pending')->count();
echo "Unassigned Pickups: " . $unassignedPickups . "\n";
