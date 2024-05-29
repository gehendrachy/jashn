<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricProduct extends Model
{
    use HasFactory;
    
      protected $fillable = ['fabric_id', 'product_id'];
}
