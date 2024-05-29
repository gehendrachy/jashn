<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'category_id', 'display', 'featured', 'stock_status', 'price', 'fabric', 'offer_price', 'gender', 'highlights', 'description', 'image', 'video_link', 'size_guide_id', 'size_group_id', 'warranty', 'weight', 'product_cares', 'views', 'created_by', 'updated_by','deleted_at'];

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at'];

    // public static $genders = [1 => 'Male', 2 => 'Female', 3 => 'Gay', 4 => 'Bisexual', 5 => 'Unisexual', 6 => 'Not Available'];
    public static $genders = [1 => 'Male', 2 => 'Female', 3 => 'Unisexual'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function product_colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function product_sizes()
    {
        return $this->hasManyThrough(ProductSize::class, ProductColor::class, 'product_id', 'product_color_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductVariation::class, 'color_id');
    }

    public function occassions()
    {
        return $this->belongsToMany(Occassion::class, 'occassion_products');
    }

    public function occassion_products()
    {
        return $this->hasMany(OccassionProduct::class);
    }

    public function fabrics()
    {
        return $this->belongsToMany(Fabric::class, 'fabric_products');
    }

    public function fabric_products()
    {
        return $this->hasOne(FabricProduct::class);
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'product_offers');
    }

    public function product_offers()
    {
        return $this->hasMany(ProductOffer::class);
    }
}
