<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['buyer_id', 'total_price', 'product_id', 'qty', 'ispay'];

    protected $casts = [
        'ispay'=> 'boolean',
    ];
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
