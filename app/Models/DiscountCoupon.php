<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'discount_type', 'coupon_usage', 'coupon_usage_count', 'minimum_quantity', 'minimum_spend', 'maximum_discount', 'discount_percentage', 'start_date', 'expire_date', 'start_time', 'expire_time', 'discount_on', 'discount_items', 'display', 'created_by', 'updated_by'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at'];

    public function category_coupons()
    {
    	return $this->hasMany(CategoryCoupon::class, 'discount_coupon_id');
    }

    public function product_coupons()
    {
    	return $this->hasMany(ProductCoupon::class, 'discount_coupon_id');
    }
}
