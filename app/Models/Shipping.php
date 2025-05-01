<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'tracking_number',
        'shipping_status',
        'notes',
    ];

    const STATUS = [
        'pending' => 'Pending',
        'shipped' => 'Dikirim',
        'delivered' => 'Diterima',
        'canceled' => 'Dibatalkan',
    ];

    /**
     * Relasi ke OrderItem.
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
    public function road()
    {
        return $this->hasMany(ShippingRoad::class);
    }
}
