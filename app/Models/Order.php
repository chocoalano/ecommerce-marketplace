<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'buyer_id',
        'payment_id',
        'total_price',
        'status',
    ];
    const STATUS = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'shipped' => 'Shipped',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
    public function item()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class, 'order_id', 'id');
    }
}
