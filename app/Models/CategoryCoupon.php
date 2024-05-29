<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'discount_coupon_id'];
}
