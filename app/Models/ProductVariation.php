<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color_id', 'size_id', 'display', 'quantity', 'price', 'offer_price', 'sku', 'preorder', 'preorder_stock_limit', 'preorder_price'];

    protected $hidden = ['created_at', 'updated_at'];

    public function color()
    {
    	return $this->belongsTo(Color::class);
    }

    public function size()
    {
    	return $this->belongsTo(Size::class);
    }

    // public function color_variations()
    // {
    // 	return $this->hasMany(ProductVariation::class,'color_id','id');
    // }
}
