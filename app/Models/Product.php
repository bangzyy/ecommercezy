<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'image',
        'product_name',
        'price',
        'category_id',
        'description',
    ];
    // Relasi: satu product dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relasi: satu product punya satu category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }
}
