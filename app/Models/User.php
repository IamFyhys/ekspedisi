<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'status',
        'branch_id',
        'sub_role',
        'phone',
        'birth_date',
        'address',
        'experience',
        'ktp_photo',
        'selfie_photo',
        'created_by',
        'reviewed_by',
        'approved_by',
        'rejected_by',
        'reviewed_at',
        'approved_at',
        'manager_note',
        'rejected_reason',
        'province_id',
        'province_name',
        'regency_id',
        'regency_name',
        'district_id',
        'district_name',
        'address_detail',
        'sim_type',
        'sim_photo',
        'vehicle_type',
        'vehicle_plate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'reviewed_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function courierShipments()
    {
        return $this->hasMany(Shipment::class, 'courier_id');
    }

    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
    public function rejecter() { return $this->belongsTo(User::class, 'rejected_by'); }

    /**
     * Check if user has any of the given roles.
     */
    public function hasRole(...$roles)
    {
        return in_array($this->role, $roles);
    }
}
