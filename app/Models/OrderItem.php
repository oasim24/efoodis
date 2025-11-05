<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
     protected $fillable = [
        'order_id','name','price','image', 'quantity', 'amount'
        
    ];

 public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
