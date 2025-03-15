<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    use HasFactory;

    // Định nghĩa mối quan hệ với Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}