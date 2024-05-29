<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function districts()
    {
        return $this->hasMany('App\Models\District');
    }

    protected $fillable = [
        'name',
        'country_id',
        'display',
        'created_by',
        'updated_by',
    ];
}
