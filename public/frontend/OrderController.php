<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\Offer;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Color;
use App\Models\Size;
use App\Models\DiscountCoupon;
use App\Models\AppliedCoupon;
use App\Models\District;
use App\Models\CourierRate;
use App\Models\OrderedProductOffer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Services\ModelHelper;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function place_order(StoreOrderRequest $request)
    {
        
    	$cart = session()->get('cart');
        $total_price = session()->get('total_price');
        $coupon_details = (array)session()->get('coupon_details');
        // dd(array('checkout_details' => $_POST, 'cart' => $cart, 'total_price' => $total_price, 'coupon_details' => $coupon_details));

        // dd($cart);

        $billing_details = array(
            'billing_name' => $request->billing_name,
            'billing_pan' => $request->billing_pan,
            'billing_phone' => $request->billing_phone,
            'billing_phone2' => $request->billing_phone2,
            'billing_email' => $request->billing_email,
            'billing_country_id' => $request->billing_country_id,
            'billing_country_name' => $request->billing_country_name,
            'billing_state_id' => $request->billing_country_id == 0 ? 0 : $request->billing_state_id,
            'billing_state_name' => $request->billing_state_name,
            'billing_district_id' => $request->billing_country_id == 0 ? 0 : $request->billing_district_id,
            'billing_district_name' => $request->billing_district_name,
            'billing_city_id' => $request->billing_country_id == 0 ? 0 : $request->billing_city_id,
            'billing_city_name' => $request->billing_city_name,
            'billing_pin_code' => $request->billing_pin_code,
            'billing_street_address_1' => $request->billing_street_address_1,
            'billing_street_address_2' => $request->billing_street_address_2
        );

        if (isset($request->same_address)) {

        	$shipping_details = array(
                'shipping_name' => $request->billing_name,
                'shipping_pan' => $request->billing_pan,
                'shipping_phone' => $request->billing_phone,
                'shipping_phone2' => $request->billing_phone2,
                'shipping_email' => $request->billing_email,
                'shipping_country_id' => $request->billing_country_id,
                'shipping_country_name' => $request->billing_country_name,
                'shipping_state_id' => $request->billing_country_id == 0 ? 0 : $request->billing_state_id,
                'shipping_state_name' => $request->billing_state_name,
                'shipping_district_id' => $request->billing_country_id == 0 ? 0 : $request->billing_district_id,
                'shipping_district_name' => $request->billing_district_name,
                'shipping_city_id' => $request->billing_country_id == 0 ? 0 : $request->billing_city_id,
                'shipping_city_name' => $request->billing_city_name,
                'shipping_pin_code' => $request->billing_pin_code,
                'shipping_street_address_1' => $request->billing_street_address_1,
                'shipping_street_address_2' => $request->billing_street_address_2
	        );

        }else{

	        $shipping_details = array(
                'shipping_name' => $request->shipping_name,
                'shipping_pan' => $request->shipping_pan,
                'shipping_phone' => $request->shipping_phone,
                'shipping_phone2' => $request->shipping_phone2,
                'shipping_email' => $request->shipping_email,
                'shipping_country_id' => $request->shipping_country_id,
                'shipping_country_name' => $request->shipping_country_name,
                'shipping_state_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_state_id,
                'shipping_state_name' => $request->shipping_state_name,
                'shipping_district_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_district_id,
                'shipping_district_name' => $request->shipping_district_name,
                'shipping_city_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_city_id,
                'shipping_city_name' => $request->shipping_city_name,
                'shipping_pin_code' => $request->shipping_pin_code,
                'shipping_street_address_1' => $request->shipping_street_address_1,
                'shipping_street_address_2' => $request->shipping_street_address_2
	        );
	    }

	    $order_status = $request->payment_method == 1 ? 0 : 1;
        $payment_status = $request->payment_method == 1 ? 0 : 1;
        $shipping_charge = 0;
        // Shipping Charge Calculation

        $district = District::find($shipping_details['shipping_district_id']);

        if ($district ) {

            $shipping_charge = 0;
            $courier_rate = $district->courier_rate;

            if ($courier_rate) {
                
                // dd($cart);
                $cart_total_weight = 0;
                foreach ($cart as $key => $item) {

                    $product = Product::where('id', $item['product_id'])->first();

                    if ($product) {
                        $item_total_weight = $product->weight * $item['ordered_qty'];
                        $cart_total_weight += $item_total_weight;
                    }
                }

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

                }elseif($cart_total_weight > 0.5 && $cart_total_weight <= 1 ){

                    $shipping_charge = $courier_rate->one_kg;

                }elseif($cart_total_weight < 1 ){

                    $shipping_charge = $courier_rate->half_kg;

                }else{
                    $shipping_charge = 0;
                }
                
            }
        }

        // dd($shipping_charge);
        $cart_sub_total = collect($cart)->sum('sub_total');
        $discount_coupon_amount = 0;
        if (Auth::check() && isset($coupon_details['id'])) {

            $discount_coupon_amount = $coupon_details['discount_amount'];

            // AppliedCoupon::create($appliedCouponArray);
        }

        $cart_total_offer_price = 0;
        foreach ($cart as $key => $item) {
            
            $product = Product::where('id', $item['product_id'])->first();

            $offer_check = Offer::check_offer($item['ordered_qty'], ['sub_total'], $product->id);

            if ($offer_check['has_offer'] == 1) {

                $final_offer = $offer_check['offer'];

                $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage/100);
                $offer_amount = round($offer_amount);

                if ($offer_amount > $final_offer->maximum_discount) {

                    $offer_amount = $final_offer->maximum_discount;
                }

                $cart_total_offer_price += $offer_amount;
            }

        }

        $cart_grand_total_price = $cart_sub_total + $shipping_charge - $discount_coupon_amount - $cart_total_offer_price;

        $max_id = Order::max('id');
        $order_no = (date('Y')*10000)+$max_id+1;

        $orderArray = array('order_no' => $order_no,
                            'customer_id' => Auth::check() ? Auth::user()->id : 0,
                            'customer_name' => $request->billing_name,
                            'customer_email' => $request->billing_email,
                            'customer_phone' => $request->billing_phone,
                            'billing_details' => json_encode($billing_details),
                            'shipping_details' => json_encode($shipping_details),
                            'coupon_details' => json_encode($coupon_details),
                            'status' => $order_status,
                            'delivery_charge' => $shipping_charge,
                            'total_offer_amount' => $cart_total_offer_price,
                            'total_price' => $cart_grand_total_price,
                            'payment_status' => $payment_status,
                            'payment_method' => $request->payment_method,
                            'payment_id' => $order_no,
                            'order_json' => json_encode($cart),
                            'additional_message' => $request->additional_message,
                            'created_by' => "Customer",
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => NULL
                        );

        // dd($orderArray);

        $orderedProductArray = array();

        foreach ($cart as $key => $item) {
        	
            $product = Product::where('id', $item["product_id"])->first();
            $product_color = $product->product_colors()->where('id', $item['product_color_id'])->first();

            if ($product_color) {
                
                $product_size = $product_color->product_sizes()->where('id', $item['product_size_id'])->first();

                if ($product_size) {
                    
                    if ($product_size->quantity >= $item['ordered_qty']) {
                        
                        $preorder_status = 0;

                    }else{

                        if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                            $preorder_status = 1;

                        }else{

                            return redirect()->route('cart')->with('stock_error', $item['product_title'].' is sold out!');
                        }
                    }

                    $product_price = $item['sub_total']/$item['ordered_qty'];

                    $productArray = array(  'product_id' => $item['product_id'],
                                            'product_title' => $item['product_title'],
                                            'product_price' => $product_price,
                                            'preorder_status' => $preorder_status,
                                            'product_color_id' => $item['product_color_id'],
                                            'color_id' => $product_color->color_id,
                                            'color_name' => isset($product_color->color) ? $product_color->color->name : NULL,
                                            'color_code' => isset($product_color->color) ? $product_color->color->code : NULL,
                                            'product_size_id' => $item['product_size_id'],
                                            'size_id' => $product_size->size_id,
                                            'size_name' => isset($product_size->size) ? $product_size->size->name : NULL,
                                            'quantity' => $item['ordered_qty'],
                                            'sub_total' => $item['sub_total'],
                                            'status' => $order_status,
                                            'created_by' => "Customer"
                                        );

                    array_push($orderedProductArray, $productArray);

                }else{
                    return redirect()->back()->with('status', 'Size not Found!');
                }


            }else{
                return redirect()->back()->with('status', 'Color not Found!');
                
            }

        }


        $order = Order::create($orderArray);
        
        if ($order) {

	        $order->ordered_products()->createMany($orderedProductArray);

	        // dd('success');

        	foreach ($cart as $item) {

            	$product = Product::where('id', $item["product_id"])->first();

                $offer_check = Offer::check_offer($item['ordered_qty'], ['sub_total'], $product->id);

                if ($offer_check['has_offer'] == 1) {

                    $final_offer = $offer_check['offer'];

                    $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage/100);
                    $offer_amount = round($offer_amount);
                    if ($offer_amount > $final_offer->maximum_discount) {

                        $offer_amount = $final_offer->maximum_discount;
                    }
                    $ordered_product = $order->ordered_products()->where('product_size_id', $item['product_size_id'])->first();
                    OrderedProductOffer::create(['ordered_product_id' => $ordered_product->id, 'offer_id' => $final_offer->id, 'discount_amount' => $offer_amount]);

                }

                $product_size = ProductSize::where('id', $item['product_size_id'])->first();

            	if ($product_size) {

                    if ($product_size->quantity >= $item['ordered_qty']) {

                        $rem_stock = $product_size->quantity - $item["ordered_qty"];
                        ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);

                    }else{

                        if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                            $rem_stock = $product_size->quantity - $item["ordered_qty"];
                            ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);

                            $rem_stock = $product_size->preorder_stock_limit - $item["ordered_qty"];
                            ProductSize::where('id', $item['product_size_id'])->update(['preorder_stock_limit' => $rem_stock]);
                        }
                    }
            		
            	}

            }

            
            if (Auth::check() && isset($coupon_details['id'])) {

        	    $user = User::find(Auth::user()->id);

        	    $appliedCouponArray = array(
        	    							'customer_id' => Auth::user()->id,
        	    							'order_id' => $order->id,
        	    							'discount_coupon_id' => $coupon_details['id'],
        	    							'coupon_code' => $coupon_details['code'],
        	    							'coupon_title' => $coupon_details['title'],
        	    							'discount_amount' => $coupon_details['discount_amount']
        	    						);

        	    AppliedCoupon::create($appliedCouponArray);
        	}
        	dd('success');
            session()->forget('cart');
            session()->forget('total_price');
            session()->forget('coupon_details');

            session()->save();


            return view('checkout-success')->with('status','Your order has been placed Successfully!');

	    }else{
	    	return redirect()->back()->withInput()->with("error","Sorry! Order Couldn't be Created.");
	    }
    	
    }
}
