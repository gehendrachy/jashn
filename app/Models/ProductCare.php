<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCare extends Model
{
    use HasFactory;

    protected $fillable = [
					    	'title',
							'slug',
							'image',
							'display',
							'description',
							'created_by',
							'updated_by',
						];
}
