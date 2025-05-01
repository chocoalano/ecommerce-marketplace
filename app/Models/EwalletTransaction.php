<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EwalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'balance',
        'transaction_at',
    ];

    const TYPE = [
        'credit'=> 'Credit',
        'debit'=> 'Debit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
