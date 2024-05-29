<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'pin_code',
        'district_id',
        'display',
        'created_by',
        'updated_by',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
