<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    protected $table = 'checkout';
    use HasFactory;
    protected $fillable =  [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'address',
        'payment_method',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
