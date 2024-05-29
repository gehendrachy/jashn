<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = ['product_color_id', 'size_id', 'display', 'quantity', 'price', 'offer_price', 'sku', 'preorder', 'preorder_stock_limit', 'preorder_price'];

    public function size()
    {
    	return $this->belongsTo(Size::class);
    }

    public function product_color()
    {
    	return $this->belongsTo(ProductColor::class, 'product_color_id');
    }
}
