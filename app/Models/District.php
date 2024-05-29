<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'state_id',
        'country_id',
        'display',
        'created_by',
        'updated_by',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }    

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function courier_rate()
    {
        return $this->hasOne(CourierRate::class);
    }
}
