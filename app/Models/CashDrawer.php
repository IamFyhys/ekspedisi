<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDrawer extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'date',
        'starting_balance',
        'current_balance',
        'closing_balance',
        'status',
        'closed_at',
        'closed_by'
    ];

    protected $casts = [
        'date' => 'date',
        'closed_at' => 'datetime',
        'starting_balance' => 'float',
        'current_balance' => 'float',
        'closing_balance' => 'float',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function closedBy() { return $this->belongsTo(User::class, 'closed_by'); }
}
