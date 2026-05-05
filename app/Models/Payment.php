<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'external_id',
        'amount',
        'status',
        'payment_method',
        'snap_token'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
