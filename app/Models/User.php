<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'type',
        'profile_picture',
        'ewallet_balance',
        'activation',
        'full_address',
        'raja_ongkir_city_id',
        'raja_ongkir_province_id',
    ];

    const TYPE = [
        'buyer' => 'Buyer',
        'seller' => 'Seller',
        // 'admin' => 'Admin'
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
            'ewallet_balance' => 'decimal:2',
            'activation' => 'boolean',
        ];
    }
    public function ewalletTransactions()
    {
        return $this->hasMany(EwalletTransaction::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'buyer_id');
    }
}
