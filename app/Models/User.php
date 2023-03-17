<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use
        // HasApiTokens, 
        HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'address',
        'role',
        'phone',
        'password',
        'appointment_letter',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ROLE_CUSTOMER = 'customer';
    const ROLE_ADMIN = 'admin';
    const ROLE_OPD = 'opd';
    const ROLE_REGENT = 'regent';

    const GENDER_PRIA = 'PRIA';
    const GENDER_WANITA = 'WANITA';

    const ACCOUNT_STATUS_ACTIVE = 'ACTIVE';
    const ACCOUNT_STATUS_INACTIVE = 'INACTIVE';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userAddressDetail()
    {
        return $this->hasOne(UserAddressDetail::class, 'user_id', 'id');
    }

    public function customerPosition()
    {
        return $this->hasOne(CustomerPosition::class, 'customer_id', 'id');
    }
    public function bearerDuration()
    {
        return $this->hasOne(BearerDuration::class, 'customer_id');
    }
}
