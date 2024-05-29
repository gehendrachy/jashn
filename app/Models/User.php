<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_id',
        'country_name',
        'state_id',
        'state_name',
        'district_id',
        'district_name',
        'city_id',
        'city_name',
        'address',
        'get_updates_via_sms',
        'get_updates_via_email',
        'get_updates_on_chrome',
        'password',
        'email_verified_at',
        'otp',
        'provider',
        'provider_id',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customer_addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function customer_orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    
    public function ordered_products()
    {
        return $this->hasManyThrough(OrderedProduct::class, Order::class, 'customer_id', 'order_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function applied_coupons()
    {
        return $this->hasMany(AppliedCoupon::class, 'customer_id');
    }

    // public function return_requests()
    // {
    //     return $this->hasMany(ReturnRequest::class, 'customer_id');
    // }

    public function return_request_products()
    {
        return $this->hasMany(ReturnRequestProduct::class, 'customer_id');
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReview::class, 'customer_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
