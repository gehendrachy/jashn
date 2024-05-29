<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
            'order_no', 'customer_id', 'customer_name', 'customer_email', 'customer_phone', 'billing_details', 'shipping_details', 'coupon_details', 'status', 'delivery_charge', 'total_offer_amount', 'total_discount_amount', 'total_price', 'payment_status', 'payment_method', 'delivery_method', 'payment_id', 'paid_date', 'order_json', 'is_new', 'additional_message', 'created_by', 'updated_by'
        ];

    protected $hidden = [
        'customer_id', 'created_by', 'updated_by','created_at', 'updated_at', 'order_json', 'coupon_details'
    ];

    public function ordered_products()
    {
        return $this->hasMany(OrderedProduct::class, 'order_id');
    }

    public static function order_status()
    {
        $order_status = [   
                            '0' => ['Order Received', 'warning'],
                            '1' => ['Processed', 'info'],
                            '2' => ['On Route', 'primary'],
                            '3' => ['Arrived', 'success'],
                            '4' => ['RTS', 'dark'],
                            '5' => ['Delivered', 'success'],
                            '6' => ['Canceled', 'danger'],
                            '7' => ['Returned', 'secondary'],
                            '8' => ['Failed', 'danger']
                        ];

        return $order_status;
    }

    public static function payment_method()
    {
        $payment_method = [   
                            '1' => 'Cash on Delivery',
                            '2' => 'Debit/Credit Cart',
                            '3' => 'E-sewa',
                            '4' => 'Fone Pay',
                            
                        ];

        return $payment_method;
    }

    public static function canceled_reasons()
    {
        $canceled_reasons = [
            '1' => 'Product has gone out of stock',
            '2' => 'Time taken is more than stated',
            '3' => 'Product is different',
            '4' => 'Product is damaged',
            '5' => 'Size does not fit',
            '6' => 'Spam or Fake order'
        ];

        return $canceled_reasons;
    }

    public static function failed_reasons()
    {
        $failed_reasons = [
            '1' => 'Not Available at the Time of Delivery',
            '2' => 'Phone not received'
        ];

        return $failed_reasons;
    }

    public function applied_coupon()
    {
        return $this->hasOne(AppliedCoupon::class);
    }    

    public function ordered_product_offers()
    {
        return $this->hasManyThrough(OrderedProductOffer::class, OrderedProduct::class, 'order_id', 'ordered_product_id');
    }

    public function ordered_product_rts()
    {
        return $this->hasManyThrough(OrderedProductRTS::class, OrderedProduct::class, 'order_id', 'ordered_product_id');
    }

    public static function calculate_delivery_charge($district_id, $weight)
    {
        $shipping_charge = 0;
        // Shipping Charge Calculation

        $district = District::find($district_id);

        if ($district ) {

            $shipping_charge = 0;
            $courier_rate = $district->courier_rate;

            if ($courier_rate) {
                
                // dd($cart);
                $cart_total_weight = $weight;

                if ($cart_total_weight > 5) {

                    $price_upto_five_kg = $courier_rate->five_kg;
                    $weight = $cart_total_weight - 5;
                    $price_over_five_kg = ceil($weight * 2) * $courier_rate->per_500g;

                    $shipping_charge = $price_upto_five_kg + $price_over_five_kg;

                }elseif($cart_total_weight > 4.5 && $cart_total_weight <= 5 ){

                    $shipping_charge = $courier_rate->five_kg;

                }elseif($cart_total_weight > 4 && $cart_total_weight <= 4.5 ){

                    $shipping_charge = $courier_rate->four_half_kg;

                }elseif($cart_total_weight > 3.5 && $cart_total_weight <= 4 ){

                    $shipping_charge = $courier_rate->four_kg;

                }elseif($cart_total_weight > 3 && $cart_total_weight <= 3.5 ){

                    $shipping_charge = $courier_rate->three_half_kg;

                }elseif($cart_total_weight > 2.5 && $cart_total_weight <= 3 ){

                    $shipping_charge = $courier_rate->three_kg;

                }elseif($cart_total_weight > 2 && $cart_total_weight <= 2.5 ){

                    $shipping_charge = $courier_rate->two_half_kg;

                }elseif($cart_total_weight > 1.5 && $cart_total_weight <= 2 ){

                    $shipping_charge = $courier_rate->two_kg;

                }elseif($cart_total_weight > 1 && $cart_total_weight <= 1.5 ){

                    $shipping_charge = $courier_rate->one_half_kg;

                } elseif ($cart_total_weight > 0.5 && $cart_total_weight <= 1) {

                    $shipping_charge = $courier_rate->one_kg;

                } elseif($cart_total_weight > 0 && $cart_total_weight <= 0.5 ){

                    $shipping_charge = $courier_rate->half_kg;

                } else{

                    $shipping_charge = 0;
                }
                
            }
        }

        return $shipping_charge;
    }
}
