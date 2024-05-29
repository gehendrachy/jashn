<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnRouteProductSize extends Model
{
    use HasFactory;

    protected $fillable = ['on_route_id', 'product_size_id', 'quantity', 'status'];

    public function product_size()
    {
    	return $this->belongsTo(ProductSize::class, 'product_size_id');
    }
}
