<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnRoute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    protected $hidden = ['created_at', 'updated_at', 'created_by', 'updated_by'];

    // public function ordered_products()
    // {
    // 	return $this->belongsToMany(OrderedProduct::class, 'ordered_products');
    // }

    public function on_route_ordered_products()
    {
    	return $this->hasMany(OnRouteOrderedProduct::class);
    }

    public function ordered_products()
    {
    	return $this->belongsToMany(OrderedProduct::class, 'on_route_ordered_products');
        // return $this->hasManyThrough(OrderedProduct::class, OnRouteOrderedProduct::class, 'on_route_id', 'ordered_product_id');
    }

    public function on_route_product_sizes()
    {
    	return $this->hasMany(OnRouteProductSize::class);
    }

    public function product_sizes()
    {
    	return $this->belongsToMany(ProductSize::class, 'on_route_product_sizes');
    }
}
