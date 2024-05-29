<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'display', 'featured', 'content', 'order_item', 'child', 'parent_id', 'created_by', 'updated_by'];

    public function products()
    {
    	return $this->hasMany(Product::class);
    }

    public function product_variations()
    {
        return $this->hasManyThrough(ProductVariation::class, Product::class, 'category_id', 'product_id');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'category_offers');
    }

    public function category_offers()
    {
        return $this->hasMany(CategoryOffer::class);
    }
}
