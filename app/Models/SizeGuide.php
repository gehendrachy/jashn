<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeGuide extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size_group_id', 'display', 'units', 'sizes', 'created_by', 'updated_by'];

    public function size_group()
    {
    	return $this->belongsTo(SizeGroup::class);
    }
}
