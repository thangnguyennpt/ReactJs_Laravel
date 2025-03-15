<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    use HasFactory;

    // Định nghĩa mối quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Định nghĩa mối quan hệ với Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}