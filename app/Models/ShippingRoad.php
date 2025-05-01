<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRoad extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipping_id',
        'information',
    ];

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }
}
