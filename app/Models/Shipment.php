<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ShipmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ShipmentObserver::class)]
class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'sender_name',
        'sender_phone',
        'origin_location_id',
        'origin_subdistrict_id',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'destination_location_id',
        'destination_subdistrict_id',
        'item_name',
        'weight',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'branch_id',
        'cashier_id',
        'courier_id',
        'delivered_at',
        'received_by',
        'receiver_relation',
        'delivery_note',
        'proof_photo',
        'digital_signature',
        'trip_id',
        'assigned_at',
        'failed_reason',
        'failed_note',
        'failed_photo',
        'failed_at',
        'scheduled_date'
    ];

    public function originLocation() { return $this->belongsTo(Location::class, 'origin_location_id'); }
    public function destinationLocation() { return $this->belongsTo(Location::class, 'destination_location_id'); }
    public function originSubdistrict() { return $this->belongsTo(Subdistrict::class, 'origin_subdistrict_id'); }
    public function destinationSubdistrict() { return $this->belongsTo(Subdistrict::class, 'destination_subdistrict_id'); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function cashier() { return $this->belongsTo(User::class, 'cashier_id'); }
    public function courier() { return $this->belongsTo(User::class, 'courier_id'); }
    public function trackings() { return $this->hasMany(ShipmentTracking::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function trip() { return $this->belongsTo(Trip::class); }
}
