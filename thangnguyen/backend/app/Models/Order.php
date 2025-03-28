<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'stock_id', 'quantity', 'note', 'status',
    
    ];
        public function user() {
            return $this->belongsTo('App\Models\User');
        }
        public function stock() {
            return $this->belongsTo ('App\Models\Stock');
        }
        public function product() {
            return $this->hasOneThrough('App\Models\Product','App\Models\Stock');
        }

        protected $casts = [
            'items' => 'array',
        ];
 
        // Quan hệ với Address
        public function address()
        {
            return $this->belongsTo(Address::class);
        }
}