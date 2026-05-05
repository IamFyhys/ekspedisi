<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'position',
        'status', // pending, reviewed, accepted, rejected
        'reviewed_by',
        'reviewed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
