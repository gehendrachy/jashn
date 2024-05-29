<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'name',
    	'pan',
    	'phone',
    	'phone2',
    	'email',
    	'country_id',
        'country_name',
    	'state_id',
        'state_name',
    	'district_id',
        'district_name',
    	'city_id',
        'city_name',
    	'pin_code',
    	'street_address_1',
    	'street_address_2',
    	'is_billing_address',
    	'is_shipping_address'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
