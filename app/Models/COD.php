<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COD extends Model
{

    use HasFactory;
    protected $fillable = [
        'state_id',
        'district_id',
        'city_id',
        'status',
        'display',
        'created_by',
        'updated_by',
    ];
}
