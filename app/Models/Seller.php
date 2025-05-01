<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'description',
        'logo',
        'store_address',
        'rating',
        'store_status',
        'store_type',
        'store_time_opened',
        'store_time_closed',
        'province',
        'city',
    ];

    const STORE_TYPE = [
        'electronic' => 'Elektronik',
        'grocery' => 'Makanan & Minuman',
        'fashion' => 'Pakaian',
        'property' => 'Properti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
