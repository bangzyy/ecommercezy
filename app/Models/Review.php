<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    protected $table = 'reviews';
    use HasFactory;
    protected $fillable =  [
        'user_id',
        'product_id',
        'checkout_id',
        'rating',
        'review',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }
}
