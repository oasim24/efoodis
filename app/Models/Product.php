<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'old_price',
        'new_price',
        'stock',
        'description',
        'thumbnail_image',
        'feature_image',
        'slug',
        'code',
        'status',
        'category_id', 
        'brand_id', 
    ];


public function category()
{
    return $this->belongsTo(Categories::class);
}




}
