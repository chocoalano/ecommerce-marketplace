<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'description',
        'price',
        'discount',
        'stock',
        'weight',
        'rating',
        'status',
        'payment_availablelity',
        'promotion_set',
        'promotion_get',
        'primary_image',
    ];

    const STATUS = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];
    const PAYMENT = [
        'credit_card' => 'Kartu kredit',
        'bank_transfer' => 'Transfer Bank',
        'e-wallet' => 'E-wallet',
        'cod' => 'Cash on delivery'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'order_id', 'product_id');
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }
}
