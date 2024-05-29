<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProductRTS extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'ordered_product_id', 'courier_id', 'tracking_no', 'invoice_no', 'status', 'created_by', 'updated_by'];

    public function ordered_product()
    {
    	return $this->belongsTo(OrderedProduct::class, 'ordered_product_id');
    }

    public function courier()
    {
    	return $this->belongsTo(Courier::class, 'courier_id');
    }
}
