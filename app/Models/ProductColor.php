<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color_id', 'image', 'status', 'sku'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color()
    {
    	return $this->belongsTo(Color::class);
    }

    public function product_sizes()
    {
    	return $this->hasMany(ProductSize::class);
    }

    public function occassion()
    {
        return $this->belongsTo(Occassion::class);
    }
}
