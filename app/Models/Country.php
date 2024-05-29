<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_code',
        'display',
        'created_by',
        'updated_by',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, District::class);
    }
}
