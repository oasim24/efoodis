<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $fillable = [
        'customer_id','invoice','delivary' , 'payment',  'quantity', 'amount', 'status',
        
    ];


 /**
     * An order belongs to a customer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * An order has many order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
