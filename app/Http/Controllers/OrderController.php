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
use App\Models\City;
use App\Models\District;
use App\Models\State;
use App\Models\Country;
use App\Models\CourierRate;
use App\Models\OrderedProductOffer;
use App\Models\OrderedProductDiscountCoupon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\File;
use App\Services\ModelHelper;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function place_order(Request $request)
    {

        $request->validate(['payment_method' => 'required'], ['payment_method.required' => 'Please Select Paymet Method to place your order!']);

        $cart = session()->get('cart');
        if ($cart == null) {
            return redirect('/')->with('error', 'Shopping Cart Empty!');
        }

        $total_price = session()->get('total_price');
        $coupon_details = (array)session()->get('coupon_details');
        $checkout_details = session()->get('checkout_details');
        // dd(array('request' => $_POST , 'checkout_details' => $checkout_details, 'cart' => $cart, 'total_price' => $total_price, 'coupon_details' => $coupon_details));

        // dd($cart);

        $shipping_details = array(
            'shipping_name' => $checkout_details['shipping']['name'],
            'shipping_pan' => $checkout_details['shipping']['pan'],
            'shipping_phone' => $checkout_details['shipping']['phone'],
            'shipping_phone2' => $checkout_details['shipping']['phone2'],
            'shipping_email' => $checkout_details['shipping']['email'],
            'shipping_country_id' => $checkout_details['shipping']['country_id'],
            'shipping_country_name' => $checkout_details['shipping']['country_name'],
            'shipping_state_id' => $checkout_details['shipping']['country_id'] == 0 ? 0 : $checkout_details['shipping']['state_id'],
            'shipping_state_name' => $checkout_details['shipping']['state_name'],
            'shipping_district_id' => $checkout_details['shipping']['country_id'] == 0 ? 0 : $checkout_details['shipping']['district_id'],
            'shipping_district_name' => $checkout_details['shipping']['district_name'],
            'shipping_city_id' => $checkout_details['shipping']['country_id'] == 0 ? 0 : $checkout_details['shipping']['city_id'],
            'shipping_city_name' => $checkout_details['shipping']['city_name'],
            'shipping_pin_code' => $checkout_details['shipping']['pin_code'],
            'shipping_street_address_1' => $checkout_details['shipping']['street_address_1'],
            'shipping_street_address_2' => $checkout_details['shipping']['street_address_2']
        );

        $billing_details = array(
            'billing_name' => $checkout_details['billing']['name'],
            'billing_pan' => $checkout_details['billing']['pan'],
            'billing_phone' => $checkout_details['billing']['phone'],
            'billing_phone2' => $checkout_details['billing']['phone2'],
            'billing_email' => $checkout_details['billing']['email'],
            'billing_country_id' => $checkout_details['billing']['country_id'],
            'billing_country_name' => $checkout_details['billing']['country_name'],
            'billing_state_id' => $checkout_details['billing']['country_id'] == 0 ? 0 : $checkout_details['billing']['state_id'],
            'billing_state_name' => $checkout_details['billing']['state_name'],
            'billing_district_id' => $checkout_details['billing']['country_id'] == 0 ? 0 : $checkout_details['billing']['district_id'],
            'billing_district_name' => $checkout_details['billing']['district_name'],
            'billing_city_id' => $checkout_details['billing']['country_id'] == 0 ? 0 : $checkout_details['billing']['city_id'],
            'billing_city_name' => $checkout_details['billing']['city_name'],
            'billing_pin_code' => $checkout_details['billing']['pin_code'],
            'billing_street_address_1' => $checkout_details['billing']['street_address_1'],
            'billing_street_address_2' => $checkout_details['billing']['street_address_2']
        );

        $order_status = $request->payment_method == 1 ? 0 : 1;
        $payment_status = 0;
        $shipping_charge = 0;

        // =================================== Shipping Charge Calculation ===================================

        $cart_total_weight = 0;
        $instock_cart_total_weight = 0;
        $preorder_cart_total_weight = 0;

        foreach ($cart as $key => $item) {

            $product = Product::where('id', $item['product_id'])->first();
            $product_size = $product->product_sizes()->where('product_sizes.id', $item['product_size_id'])->first();

            if ($product_size) {

                if ($product_size->quantity >= $item['ordered_qty']) {

                    $preorder_status = 0;
                } else {

                    if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                        $preorder_status = 1;

                    } else {

                        // dd($item['product_title'] . ' is sold out!');
                        return redirect()->route('cart')->with('stock_error', $item['product_title'] . ' is sold out!');
                    }
                }

                $offer_check = Offer::check_shipping_offer($item['ordered_qty'], $item['sub_total'], $product->id);
                // echo $offer_check['has_offer'].'<br>';
                
                $item_total_weight = $product->weight * $item['ordered_qty'];
                $cart_total_weight += $item_total_weight;

                $item['weight'] = $item_total_weight;
                $item['preorder'] = $preorder_status;


                // echo "string";
                if ($offer_check['has_offer'] != 1) {

                    $item['has_free_shipping'] = 0;

                    if ($preorder_status == 1) {

                        $preorder_cart_total_weight += $item_total_weight;

                    }else{

                        $instock_cart_total_weight += $item_total_weight;
                    }

                }else{

                    $item['has_free_shipping'] = 1;

                }

                $cart[$key] = $item;
                
                session()->put('cart', $cart);
                session()->save();
            }
        }



        $district = District::find($shipping_details['shipping_district_id']);

        if ($district) {

            // $cart_total_weight = $instock_cart_total_weight + $preorder_cart_total_weight;

            $instock_cart_delivery_charge = Order::calculate_delivery_charge($district->id, $instock_cart_total_weight);
            $preorder_cart_delivery_charge = Order::calculate_delivery_charge($district->id, $preorder_cart_total_weight);

            $total_delivery_charge = $instock_cart_delivery_charge + $preorder_cart_delivery_charge;

        }else{

            $total_delivery_charge = 0;

        }

        
        // dd($cart);
        // $cart_total_weight = session()->get('cart_total_weight');
        $shipping_charge = $total_delivery_charge;

        // dd($shipping_charge);
        
        $cart_total_price = collect($cart)->sum('sub_total');

        // Discount Coupon Calculation
        $discount_coupon_amount = 0;
        $filtered_products = [];
        if (Auth::check() && isset($coupon_details['id'])) {

            $code = strtolower($coupon_details['code']);
            $coupon = DiscountCoupon::where('code', $code)->first();
            
            $todayDate = date('Y-m-d');

            if ($coupon) {

                if ($todayDate >= $coupon->start_date && $todayDate <= $coupon->expire_date ) {

                    if ($coupon->discount_type == 1) {

                        $user = User::find(Auth::user()->id);
                        $orders_count = $user->customer_orders()->count();

                        if ($orders_count > 0) {

                            return redirect()->back()->with('error', 'You are not eligible for this Coupon!');

                        }

                        $alreadyApplied = AppliedCoupon::where([['customer_id', Auth::user()->id], ['discount_coupon_id', $coupon->id]])->exists();

                        if ($alreadyApplied) {

                            return redirect()->back()->with('error', 'You have already used this Coupon!');
                        }                    
                    }else{

                        $applied_coupon_usage_count = AppliedCoupon::where([['customer_id', Auth::user()->id],['discount_coupon_id', $coupon->id]])->count();

                        if ($applied_coupon_usage_count >= $coupon->coupon_usage) {

                            return redirect()->back()->with('error', 'You have applied this Coupon code to maximum limit!');

                        }
                    }

                    if ($cart_total_price < $coupon->minimum_spend) {

                        return redirect()->back()->with('error', 'Please Spend upto Nrs. '.$coupon->minimum_spend.' to apply this code!');
                    }

                    $total_order_quantity = collect($cart)->sum('ordered_qty');

                    if ($total_order_quantity < $coupon->minimum_quantity) {

                        return redirect()->back()->with('error', 'You must buy '.$coupon->minimum_quantity.' items in total to apply this code!');
                    }

                    
                    switch($coupon->discount_on){
                        case "1":

                            // selected categories
                            foreach($cart as $cart_product){

                                $product = Product::findOrFail($cart_product['product_id']);
                                if(in_array($product->category->id, $coupon->category_coupons->pluck('category_id')->toArray())){
                                    array_push($filtered_products, $cart_product);
                                }

                            }
                            break;

                        case "2":

                            // selected products
                            foreach($cart as $cart_product){

                                if(in_array($cart_product['product_id'], $coupon->product_coupons->pluck('product_id')->toArray())){
                                    array_push($filtered_products, $cart_product);
                                }

                            }
                            break;

                        case "3":

                            $filtered_products = $cart;
                            break;

                        default:

                            return redirect()->back()->with('error', 'Invalid Coupon Code');
                    }

                    // if(count($filtered_products) == 0){
                    //     return redirect()->back()->with('error', 'Invalid Coupon Code');
                    // }
                    
                    $valid_sub_total_price = collect($filtered_products)->pluck('sub_total')->sum();

                    $discount_amount = $valid_sub_total_price * ($coupon->discount_percentage/100);
                    $discount_amount = round($discount_amount);

                    if ($discount_amount > $coupon->maximum_discount) {

                        $discount_amount = $coupon->maximum_discount;
                    }

                    // dd($discount_amount);
                    // $cart_total_price = $cart_total_price - $discount_amount + $shipping_charge;
                    $couponDiscount = $coupon->discount_percentage."% off (upto Nrs.".$coupon->maximum_discount.")";
                    $coupon_details = [
                                        "id" => $coupon->id, 
                                        "code" => $coupon->code, 
                                        "title" => $coupon->name." - ".$couponDiscount, 
                                        "discount_amount" => $discount_amount
                                    ];
                    session()->put("coupon_details", $coupon_details);

                }else{

                    return redirect()->back()->with('error', 'Coupon is already expired!');
                }
            }


            $discount_coupon_amount = $coupon_details['discount_amount'];

            // AppliedCoupon::create($appliedCouponArray);
        }


        // ====================================== Offer Price Calculation ===================================

        $cart_total_weight = 0;
        $cart_total_offer_price = 0;
        $cart_offers = [];
        $temp =[];

        foreach ($cart as $key => $item) {
            
            $product = Product::where('id', $item['product_id'])->first();

            if ($product) {
                $item_total_weight = $product->weight * $item['ordered_qty'];
                $cart_total_weight += $item_total_weight;
            }

            $offer_check = Offer::check_offer($item['ordered_qty'], $item['sub_total'], $product->id);

            if ($offer_check['has_offer'] == 1) {

                $final_offer = $offer_check['offer'];

                $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage/100);
                $offer_amount = round($offer_amount);

                if ($offer_amount > $final_offer->maximum_discount) {

                    $offer_amount = $final_offer->maximum_discount;
                }

                if (collect($cart_offers)->where('id', $final_offer->id)->count() == 0) {
                    
                    $temp[$final_offer->id] = [['product_id' => $item['product_id'], 'product_size_id' => $item['product_size_id'], 'ordered_qty' => $item['ordered_qty']]];

                    array_push($cart_offers, $final_offer);
                    $final_offer->calculated_offer_amount = $offer_amount;

                }else{

                    array_push($temp[$final_offer->id], ['product_id' => $item['product_id'], 'product_size_id' => $item['product_size_id'], 'ordered_qty' => $item['ordered_qty']]);

                    $final_offer = collect($cart_offers)->where('id', $final_offer->id)->first();
                    $final_offer->calculated_offer_amount = $final_offer->calculated_offer_amount + $offer_amount;
                }
                
                $cart_total_offer_price += $offer_amount;
            }

        }

        
        foreach ($cart_offers as $cart_offer) {

            $cart_offer->ordered_products = $temp[$cart_offer->id];

            if ($cart_offer->maximum_discount < $cart_offer->calculated_offer_amount) {
                $cart_offer->calculated_offer_amount = $cart_offer->maximum_discount;
            }

        }

        $cart_total_offer_price = collect($cart_offers)->sum('calculated_offer_amount');

        // ============================================

        $cart_grand_total_price = $cart_total_price + $shipping_charge - $discount_coupon_amount - $cart_total_offer_price;


        $max_id = Order::max('id');
        $order_no = (date('Y') * 10000) + $max_id + 1;

        $orderArray = array(
            'order_no' => $order_no,
            'customer_id' => Auth::check() ? Auth::user()->id : 0,
            'customer_name' => $billing_details['billing_name'],
            'customer_email' => $billing_details['billing_email'],
            'customer_phone' => $billing_details['billing_phone'],
            'billing_details' => json_encode($billing_details),
            'shipping_details' => json_encode($shipping_details),
            'coupon_details' => json_encode($coupon_details),
            'status' => $order_status,
            'delivery_charge' => $shipping_charge,
            'total_offer_amount' => $cart_total_offer_price,
            'total_discount_amount' => $discount_coupon_amount,
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
                    } else {

                        if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                            $preorder_status = 1;
                        } else {
                            // dd($item['product_title'] . ' is sold out!');
                            return redirect()->route('cart')->with('stock_error', $item['product_title'] . ' is sold out!');
                        }
                    }

                    $product_price = $item['sub_total'] / $item['ordered_qty'];

                    $productArray = array(
                        'product_id' => $item['product_id'],
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
                        'weight' => $item['weight'],
                        'has_free_shipping' => $item['has_free_shipping'],
                        'created_by' => "Customer"
                    );

                    array_push($orderedProductArray, $productArray);
                } else {
                    return redirect()->back()->with('status', 'Size not Found!');
                }
            } else {
                return redirect()->back()->with('status', 'Color not Found!');
            }
        }

        // dd($orderedProductArray);
        // dd($cart_offers);
        // dd($cart_total_offer_price != 0 && count($cart_offers) != 0);
        // dd("im out");

        $order = Order::create($orderArray);

        if ($order) {

            $order->ordered_products()->createMany($orderedProductArray);


            if ($discount_coupon_amount != 0 && count($filtered_products) != 0) {

                $valid_total_ordered_qty = collect($filtered_products)->pluck('ordered_qty')->sum();
                $per_quantity_discount_amount = $discount_coupon_amount / $valid_total_ordered_qty;
                
                foreach ($filtered_products as $key => $item) {

                    $item_discount_amount = $item['ordered_qty'] * $per_quantity_discount_amount;
                    $ordered_product = $order->ordered_products()->where('product_size_id', $item['product_size_id'])->first();

                    OrderedProductDiscountCoupon::create([
                                                'ordered_product_id' => $ordered_product->id, 
                                                'discount_coupon_id' => $coupon_details['id'], 
                                                'discount_amount' => $item_discount_amount
                                            ]);

                    // echo $item['ordered_qty']*$per_quantity_discount_amount.'<br>';
                }
            }

            if ($cart_total_offer_price != 0 && count($cart_offers) != 0) {
                foreach ($cart_offers as $cart_offer) {

                    $valid_ordered_products = $cart_offer->ordered_products;
                    $valid_total_ordered_qty = collect($valid_ordered_products)->pluck('ordered_qty')->sum();
                    $per_quantity_offer_amount = $cart_offer->calculated_offer_amount / $valid_total_ordered_qty;

                    foreach ($valid_ordered_products as $valid_offer_product) {
                        
                        $item_discount_amount = $valid_offer_product['ordered_qty'] * $per_quantity_offer_amount;
                        $ordered_product = $order->ordered_products()->where('product_size_id', $valid_offer_product['product_size_id'])->first();

                        OrderedProductOffer::create([
                                                'ordered_product_id' => $ordered_product->id, 
                                                'offer_id' => $cart_offer->id, 
                                                'discount_amount' => $item_discount_amount
                                            ]);

                        // echo $valid_offer_product['ordered_qty'] * $per_quantity_offer_amount.'<br>';
                    }
                }
            }

            // foreach ($cart as $item) {

            //     // $product = Product::where('id', $item["product_id"])->first();

            //     // $offer_check = Offer::check_offer($item['ordered_qty'], ['sub_total'], $product->id);

            //     // if ($offer_check['has_offer'] == 1) {

            //     //     $final_offer = $offer_check['offer'];

            //     //     $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage / 100);
            //     //     $offer_amount = round($offer_amount);
            //     //     if ($offer_amount > $final_offer->maximum_discount) {

            //     //         $offer_amount = $final_offer->maximum_discount;
            //     //     }

            //     //     $ordered_product = $order->ordered_products()->where('product_size_id', $item['product_size_id'])->first();
            //     //     OrderedProductOffer::create(['ordered_product_id' => $ordered_product->id, 'offer_id' => $final_offer->id, 'discount_amount' => $offer_amount]);
            //     // }


            //     // ==================================== Stock Calculations =======================================

            //     $product_size = ProductSize::where('id', $item['product_size_id'])->first();

            //     if ($product_size) {

            //         if ($product_size->quantity >= $item['ordered_qty']) {

            //             $rem_stock = $product_size->quantity - $item["ordered_qty"];
            //             ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);
            //         } else {

            //             if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

            //                 $rem_stock = $product_size->quantity - $item["ordered_qty"];
            //                 ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);

            //                 $rem_stock = $product_size->preorder_stock_limit - $item["ordered_qty"];
            //                 ProductSize::where('id', $item['product_size_id'])->update(['preorder_stock_limit' => $rem_stock]);
            //             }
            //         }
            //     }
            // }


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
            // dd($order);
            // dd('success');
            // session()->forget('cart');
            // session()->forget('total_price');
            // session()->forget('coupon_details');

            session()->put("order_no_for_nic", $order->order_no);

            if ($request->payment_method == 2) {

                /*------------------ NIC ASIA PAYMENT FUNCTIONALITIES ------------------*/

                $uniq = uniqid();
                $date = gmdate("Y-m-d\TH:i:s\Z");

                $billNameArray = explode(' ', $billing_details['billing_name']);

                $bill_to_last_name = end($billNameArray);
                array_pop($billNameArray);
                $bill_to_first_name = implode(' ', $billNameArray);

                $shipNameArray = explode(' ', $shipping_details['shipping_name']);

                $ship_to_last_name = end($shipNameArray);
                array_pop($shipNameArray);
                $ship_to_first_name = implode(' ', $shipNameArray);

                if( $billing_details['billing_country_id'] == 0){

                    $billing_city_name = $billing_details['billing_city_name'];
                    $billing_state_name = $billing_details['billing_state_name'];
                    $billing_country_name = $billing_details['billing_country_name'];
                }else{

                    $city = City::find($billing_details['billing_city_id']);
                    $state = State::find($billing_details['billing_state_id']);
                    $country = Country::find($billing_details['billing_country_id']);

                    $billing_city_name = isset($city) ? $city->name : 'N/A';
                    $billing_state_name = isset($state) ? $state->name : 'N/A';
                    $billing_country_name = isset($country) ? $country->name : 'N/A';
                    
                }

                if( $shipping_details['shipping_country_id'] == 0){

                    $shipping_city_name = $shipping_details['shipping_city_name'];
                    $shipping_state_name = $shipping_details['shipping_state_name'];
                    $shipping_country_name = $shipping_details['shipping_country_name'];
                }else{

                    $city = City::find($shipping_details['shipping_city_id']);
                    $state = State::find($shipping_details['shipping_state_id']);
                    $country = Country::find($shipping_details['shipping_country_id']);

                    $shipping_city_name = isset($city) ? $city->name : 'N/A';
                    $shipping_state_name = isset($state) ? $state->name : 'N/A';
                    $shipping_country_name = isset($country) ? $country->name : 'N/A';
                    
                }

                $testValues = array(
                    'access_key' => 'db5ff28911b9380e88d8745d5ad3acab',
                    'profile_id' =>  '24278DDF-212B-4A9E-B5C9-EA233FADBF5A',
                    'transaction_uuid' => $uniq,
                    'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,ship_to_forename,ship_to_surname,ship_to_email,ship_to_phone,ship_to_address_line1,ship_to_address_city,ship_to_address_state,ship_to_address_country',
                    'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
                    'signed_date_time' => $date,
                    'locale' => 'en',
                    'amount' => $cart_grand_total_price.'.00',
                    'bill_to_forename' => $bill_to_first_name,
                    'bill_to_surname' => $bill_to_last_name,
                    'bill_to_email' => $billing_details['billing_email'],
                    'bill_to_phone' => $billing_details['billing_phone'],
                    'bill_to_address_line1' => $billing_details['billing_street_address_1'],
                    'bill_to_address_city'=> $billing_city_name,
                    'bill_to_address_state'=> $billing_state_name,
                    'bill_to_address_country' => 'NP',
                    'ship_to_forename' => $ship_to_first_name,
                    'ship_to_surname' => $ship_to_last_name,
                    'ship_to_email' => $shipping_details['shipping_email'],
                    'ship_to_phone' => $shipping_details['shipping_phone'],
                    'ship_to_address_line1' => $shipping_details['shipping_street_address_1'],
                    'ship_to_address_city'=> $shipping_city_name,
                    'ship_to_address_state'=> $shipping_state_name,
                    'ship_to_address_country' => 'NP',
                    'transaction_type' => 'sale',
                    'reference_number' => $order_no,
                    'currency' => 'NPR',
                    'payment_method' => 'card'
                );
                $fieldValues = array();

                foreach(explode(',', $testValues['signed_field_names']) as $test){
                    $text = $test . "=" . $testValues[$test];
                    array_push($fieldValues, $text);
                }
                // dd(join(',', $fieldValues));
                $joinedValue = join(',', $fieldValues);

                $hash = base64_encode(hash_hmac('sha256', $joinedValue, '59a829a47af34eacb304ec884b669665f6d358e66d1246d69f2cdbc038d90779147bd6c5fabd4f6d9f63a6133a1a701f97eff1cb4ad548c3b34b55ec702d006010ecce1630eb40b3bde0adbe914c38e9c74931a73a224216bc38d05ec5e4a2d6ee4ea2089be6480cb8d23e77191c0bb6107f7725f79245888f74c322dad0729f', true));

                $nica_url = "https://testsecureacceptance.cybersource.com/pay";
                $data =[
                    'access_key' => 'db5ff28911b9380e88d8745d5ad3acab',
                    'profile_id' =>  '24278DDF-212B-4A9E-B5C9-EA233FADBF5A',
                    'transaction_uuid' => $uniq,
                    'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,ship_to_forename,ship_to_surname,ship_to_email,ship_to_phone,ship_to_address_line1,ship_to_address_city,ship_to_address_state,ship_to_address_country',
                    'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
                    'signed_date_time' => $date,
                    'locale' => 'en',
                    'amount' => $cart_grand_total_price.'.00',
                    'bill_to_forename' => $bill_to_first_name,
                    'bill_to_surname' => $bill_to_last_name,
                    'bill_to_email' => $billing_details['billing_email'],
                    'bill_to_phone' => $billing_details['billing_phone'],
                    'bill_to_address_line1' => $billing_details['billing_street_address_1'],
                    'bill_to_address_city'=> $billing_city_name,
                    'bill_to_address_state'=> $billing_state_name,
                    'bill_to_address_country' => 'NP',
                    'ship_to_forename' => $ship_to_first_name,
                    'ship_to_surname' => $ship_to_last_name,
                    'ship_to_email' => $shipping_details['shipping_email'],
                    'ship_to_phone' => $shipping_details['shipping_phone'],
                    'ship_to_address_line1' => $shipping_details['shipping_street_address_1'],
                    'ship_to_address_city'=> $shipping_city_name,
                    'ship_to_address_state'=> $shipping_state_name,
                    'ship_to_address_country' => 'NP',
                    'transaction_type' => 'sale',
                    'reference_number' => $order_no,
                    'currency' => 'NPR',
                    'payment_method' => 'card',
                    'signature' => $hash,
                    'card_type' => '001',
                    'card_number' => '',
                    'card_expiry_date' => ''
                ];
                // dd(Auth::user());
                // dd($data);
                
                return view('nic-asia-payment', compact('data', 'nica_url'));
            }

            return redirect()->route('checkout-success', base64_encode($order->order_no))->with('status', 'Your order has been placed Successfully!');
        } else {
            return redirect()->back()->withInput()->with("error", "Sorry! Order Couldn't be Created.");
        }
    }
    
    public function checkout_success($order_no)
    {

        $order_no = base64_decode($order_no);
        // dd($order_no);

        if (Auth::check()) {
            
            $order = Order::where([['customer_id', Auth::user()->id],['order_no', $order_no]])->first();
        }else{

            $order = Order::where('order_no', $order_no)->first();
        }
        
        // dd($order);
        if (!$order) {
            return redirect()->route('home')->with('error','Order Detail Not Found.');
        }

        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        $canceled_reasons = Order::canceled_reasons();
        $billing_details = json_decode($order->billing_details);
        $shipping_details = json_decode($order->shipping_details);
        
        return view('checkout-success', compact('order', 'order_status', 'payment_method', 'canceled_reasons', 'billing_details', 'shipping_details'));
    }
}
