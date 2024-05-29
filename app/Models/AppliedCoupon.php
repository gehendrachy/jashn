<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_id', 'discount_coupon_id', 'coupon_code', 'coupon_title', 'discount_amount'];
}
