<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['size_group_id', 'name', 'display'];

    public function size_group()
    {
    	return $this->BelongsTo(SizeGroup::class, 'size_group_id');
    }

}
