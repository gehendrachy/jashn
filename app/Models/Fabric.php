<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'slug', 'image', 'display', 'created_by', 'updated_by'];

    public function products()
    {
    	return $this->belongsTo(Product::class, 'occassion_products');
    }

    public function fabric_products()
    {
    	return $this->hasOne(FabricProduct::class);
    }
}
