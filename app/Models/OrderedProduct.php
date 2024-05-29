<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
		    'order_id', 'product_id', 'product_title', 'product_price', 'preorder_status', 'product_color_id', 'color_id', 'color_name', 'color_code', 'product_size_id', 'size_id', 'size_name', 'quantity', 'sub_total', 'status', 'remarks', 'weight', 'has_free_shipping', 'is_shipped', 'created_by', 'updated_by'
		];

	protected $hidden = [
        'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function product_size()
	{
		return $this->belongsTo(ProductSize::class, 'product_size_id');
	}

	public function on_route_ordered_products()
    {
    	return $this->hasOne(OnRouteOrderedProduct::class, 'ordered_product_id');
    }

    public function ordered_product_offer()
    {
    	return $this->hasOne(OrderedProductOffer::class, 'ordered_product_id');
    }

    public function ordered_product_discount_coupon()
    {
        return $this->hasOne(OrderedProductDiscountCoupon::class, 'ordered_product_id');
    }

    public function ordered_product_rts()
    {
    	return $this->hasOne(OrderedProductRTS::class, 'ordered_product_id');
    }

    public function return_request_product()
    {
        return $this->hasOne(ReturnRequestProduct::class, 'ordered_product_id');
    }
}
