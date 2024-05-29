<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProductOffer extends Model
{
    use HasFactory;

    protected $fillable = ['ordered_product_id', 'offer_id', 'discount_amount'];

    public function ordered_product()
    {
    	return $this->belongsTo(OrderedProduct::class, 'ordered_product_id');
    }
}
