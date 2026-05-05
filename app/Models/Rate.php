<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_location_id',
        'destination_location_id',
        'price_per_kg',
        'estimated_days'
    ];

    public function origin() { return $this->belongsTo(Location::class, 'origin_location_id'); }
    public function destination() { return $this->belongsTo(Location::class, 'destination_location_id'); }
}
