<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'item_price',
        'total_price',
        'total_weight',
        'province_store',
        'city_store',
        'province_id_ro_shipping',
        'city_id_ro_shipping',
        'courier_ro_shipping',
        'packet_ro_shipping',
        'cost_ro_shipping',
        'list_ro_shipping_option',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'order_item_id', 'id');
    }
}