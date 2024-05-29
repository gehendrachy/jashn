<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnRouteOrderedProduct extends Model
{
    use HasFactory;

    protected $fillable = ['on_route_id', 'order_id', 'ordered_product_id', 'status'];

    public function ordered_product()
    {
    	return $this->belongsTo(OrderedProduct::class, 'ordered_product_id');
    }

    public function order()
    {
    	return $this->belongsTo(Order::class, 'order_id');
    }
}
