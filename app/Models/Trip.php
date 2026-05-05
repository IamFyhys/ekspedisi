<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'courier_id',
        'origin_branch_id',
        'destination_branch_id',
        'total_packages',
        'total_received',
        'departed_at',
        'arrived_at',
        'status',
        'missing_note',
    ];

    protected $casts = [
        'departed_at' => 'datetime',
        'arrived_at' => 'datetime',
    ];

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function originBranch()
    {
        return $this->belongsTo(Branch::class, 'origin_branch_id');
    }

    public function destinationBranch()
    {
        return $this->belongsTo(Branch::class, 'destination_branch_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'trip_id');
    }
}
