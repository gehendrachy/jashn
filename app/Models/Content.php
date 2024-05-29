<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'slug',
    	'image',
    	'display',
    	'excerpt',
    	'content',
    	'order_item',
    	'child',
    	'parent_id',
    	'created_by',
    	'updated_by'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'created_by', 'updated_by',
    ];
}
