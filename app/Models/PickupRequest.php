<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_code',
        'sender_name',
        'sender_phone',
        'sender_address',
        'sender_city',
        'sender_lat',
        'sender_lng',
        'estimated_weight',
        'goods_type',
        'goods_description',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'receiver_city',
        'pickup_date',
        'pickup_time',
        'branch_id',
        'customer_id',
        'courier_id',
        'assigned_by',
        'processed_by',
        'status',
        'actual_weight',
        'pickup_photo',
        'pickup_note',
        'picked_up_at',
        'arrived_at',
        'cancel_reason',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'picked_up_at' => 'datetime',
        'arrived_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
