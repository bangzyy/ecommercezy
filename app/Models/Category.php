<?php
namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
     use HasFactory;
    protected $fillable = [
        'category_name',
        'slug',
        'image',
        'description',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Event listener pas create & update
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });
    }
}
