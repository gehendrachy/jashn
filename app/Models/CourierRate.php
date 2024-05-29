<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierRate extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'country_id', 'state_id', 'district_id', 'half_kg', 'one_kg', 'one_half_kg', 'two_kg', 'two_half_kg', 'three_kg', 'three_half_kg', 'four_kg', 'four_half_kg', 'five_kg', 'per_500g', 'display', 'created_by', 'updated_by'
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function country()
    {
        return $this->belongsTo(District::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
