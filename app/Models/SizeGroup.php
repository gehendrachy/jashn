<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display', 'created_by', 'updated_by'];

    public function sizes()
    {
    	return $this->hasMany(Size::class);
    }
}
