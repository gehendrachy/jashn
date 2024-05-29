<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProductDiscountCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['ordered_product_id', 'discount_coupon_id', 'discount_amount'];

    public function ordered_product()
    {
    	return $this->belongsTo(OrderedProduct::class, 'ordered_product_id');
    }
}
