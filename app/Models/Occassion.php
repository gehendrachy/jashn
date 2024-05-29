<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occassion extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'image', 'display', 'created_by', 'updated_by'];

    public function products()
    {
    	return $this->belongsToMany(Product::class, 'occassion_products');
    }

    public function occassion_products()
    {
    	return $this->hasMany(OccassionProduct::class);
    }
}
