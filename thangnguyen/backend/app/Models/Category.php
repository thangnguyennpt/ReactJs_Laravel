<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    use HasFactory;

    // Định nghĩa mối quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}