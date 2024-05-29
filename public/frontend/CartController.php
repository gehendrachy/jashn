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
use App\Models\ProductVariation;
use App\Models\Country;
use App\Models\District;
use App\Models\Offer;
use App\Models\DiscountCoupon;
use App\Models\AppliedCoupon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Services\ModelHelper;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
    	$cart = (array)session()->get("cart");
    	$cart_total_price = (float)session()->get("total_price");

    	if (session()->get('coupon_details')) {
    		session()->forget('coupon_details');
    		session()->save();
    	}
    	

    	if ($request->product_id) {

            $product = Product::where("id", $request->product_id)->first();

            if (!$product) {
                $data = array('status'=> 'product_not_found');
                echo json_encode($data);
                exit();
            }
            // $product_price = $product->offer_price != NULL || $product->offer_price != 0 ? $product->offer_price : $product->price;

            $product_color = $product->product_colors()->where('id', $request->product_color_id)->first();

            if (!$product_color) {

                $data = array('status'=> 'error');
                echo json_encode($data);
                exit();
            }

            $product_size = $product_color->product_sizes()->where('id', $request->product_size_id)->first();

            if (!$product_size) {

                $data = array('status'=> 'error');
                echo json_encode($data);
                exit();
                
            }else{

                if ($product_size->quantity < 0 && $product_size->preorder == 0) {
                    
                    if($product_size->preorder == 1 && $product_size->preorder_stock_limit <= 0){

                        $data = array('status'=> 'outofstock');
                        echo json_encode($data);
                        exit();
                    }

                    $data = array('status'=> 'outofstock');
                    echo json_encode($data);
                    exit();

                }
                
                if ($product_size->price != NULL && $product_size->price != 0) {

                    if ($product_size->offer_price != NULL || $product_size->offer_price != 0) {
                        $product_price = $product_size->offer_price;
                    }else{
                        $product_price = $product_size->price;
                    }
                }
            }

            $cart_item_sub_total = $product_price * $request->ordered_qty;

            $max_order_qty = $product_size->quantity > 0 ? $product_size->quantity : $product_size->preorder_stock_limit;

            $cart_ids = array_column($cart, 'cart_id');
			$cart_key = (int)array_search($product_size->id, $cart_ids);

            // var_dump($cart_key);
            // exit();
            $in_cart = count($cart) == 0 ? 0 : $cart[$cart_key]['ordered_qty'];
            $availableStock = $max_order_qty - $in_cart;

            if ($max_order_qty >= $request->ordered_qty) {
            	
            	$cart_item_count = count($cart);

            	if ($cart_item_count == 0) {

            		$cartItem = array('cart_id' => $product_size->id,
            						  'product_id' => (int)$request->product_id, 
	                                  'product_title' => addslashes($product->title),
	                                  'product_color_id' => (int)$request->product_color_id, 
	                                  'color_name' => isset($product_color->color) ? $product_color->color->title : NULL,
	                                  'color_code' => isset($product_color->color) ? $product_color->color->code : NULL,
	                                  'product_size_id' => (int)$request->product_size_id, 
	                                  'size_name' => isset($product_size->size) ? $product_size->size->name : NULL,
	    							  'ordered_qty' =>(int)$request->ordered_qty,
	    							  'sub_total' => (float)$cart_item_sub_total
	    							);
            		// dd($cartItem);
            		$cart_total_price = $cart_total_price + $cart_item_sub_total;

    				session()->push("cart", $cartItem);
    				session()->put("total_price", $cart_total_price);
    				session()->save();

    				$data = array('status'=> 'success', 'total_qty'=>count(session()->get('cart')) , 'total_price' => $cart_total_price);
    				
    				echo json_encode($data);
    				exit();
            	}else{

            		
            		for($i=0; $i < $cart_item_count; $i++){

    					if ($product_size->id == $cart[$i]['cart_id'] && $product->id == $cart[$i]['product_id']) {
    						
    						$ordered_qty_temp = (int)$cart[$i]['ordered_qty'] + (int)$request->ordered_qty;
    						
                            if ($ordered_qty_temp > $max_order_qty) {

                                if ($product_size->preorder == 1) {
                                    
                                    $data = array('status'=> 'prestockerror', 'stock'=> $max_order_qty, 'in_cart' => $in_cart);
                                    echo json_encode($data);
                                    exit();
                                    
                                }else{

                                    $data = array('status'=> 'stockerror', 'stock'=> $availableStock, 'in_cart' => $in_cart);
                                    echo json_encode($data);
                                    exit();
                                }


                            }else{

                                $cart[$i]["ordered_qty"] = $ordered_qty_temp;
                                $cart[$i]['sub_total'] = (float)$cart[$i]['sub_total'] + (float)$cart_item_sub_total;

                                $cart_total_price = $cart_total_price + $cart_item_sub_total;

                                session()->put("cart", $cart);
                                session()->put("total_price", $cart_total_price);
                                session()->save();

                                $data = array('status'=> 'success', 'total_qty'=>count($cart) , 'total_price' => $cart_total_price);
                                echo json_encode($data);
                                exit();
                            }
    					}
    				}

    				$cartItem = array('cart_id' => $product_size->id,
                                      'product_id' => (int)$request->product_id, 
                                      'product_title' => addslashes($product->title),
                                      'product_color_id' => (int)$request->product_color_id, 
                                      'color_name' => isset($product_color->color) ? $product_color->color->title : NULL,
                                      'color_code' => isset($product_size->color) ? $product_size->color->code : NULL,
                                      'product_size_id' => (int)$request->product_size_id, 
                                      'size_name' => isset($product_size->size) ? $product_size->size->name : NULL,
                                      'ordered_qty' =>(int)$request->ordered_qty,
                                      'sub_total' => (float)$cart_item_sub_total
                                    );
    				$cart_total_price = $cart_total_price + $cart_item_sub_total;

    				session()->push("cart", $cartItem);
    				session()->put("total_price", $cart_total_price);
    				session()->save();

    				$data = array('status'=> 'success', 'total_qty'=>count(session()->get('cart')) , 'total_price' => $cart_total_price);

    				echo json_encode($data);
    				exit();
            	}


            }else{

                if ($product_size->preorder == 1) {

                    $data = array('status'=> 'prestockerror', 'stock'=> $availableStock, 'in_cart' => $in_cart);
                    echo json_encode($data);
                    exit();
                }else{
                    $data = array('status'=> 'stockerror', 'stock'=> $availableStock, 'in_cart' => $in_cart);
                    echo json_encode($data);
                    exit();
                }

            }

    	}
    }

    public function cart()
    {
    	$cart = (array)session()->get("cart");
        // dd($cart);
    	$cart_total_price = (float)session()->get("total_price");
    	// session()->flush();
    	// session()->save();
    	// dd($cart);

        if (session()->get('coupon_details')) {
            session()->forget('coupon_details');
            session()->save();
        }
    	return view('cart',compact('cart'));
    }

    public function update_cart(Request $request)
    {
    	// $cart_key = $request->cart_key;
    	$cart_id = $request->cart_id;
    	$ordered_qty = $request->ordered_qty;

    	$cart = (array)session()->get("cart");
    	$cart_total_price = (float)session()->get("total_price");

        if (session()->get('coupon_details')) {

            session()->forget('coupon_details');
            session()->save();
        }

    	$cart_ids = array_column($cart, 'cart_id');
		$cart_key = (int)array_search($cart_id, $cart_ids);

		$unit_price = $cart[$cart_key]['sub_total']/$cart[$cart_key]['ordered_qty'];
		$cart_item_sub_total = $unit_price * $ordered_qty;

		$cart[$cart_key]["ordered_qty"] = $ordered_qty;

		$old_sub_total = $cart[$cart_key]['sub_total'];
		$cart[$cart_key]['sub_total'] = (float)$cart_item_sub_total;

		$cart_total_price = $cart_total_price - $old_sub_total + $cart_item_sub_total;

		session()->put("cart", $cart);
		session()->put("total_price", $cart_total_price);
		session()->save();

		$data = array('status'=> 'success', 'total_qty'=>count($cart) , 'item_sub_total' => $cart_item_sub_total, 'total_price' => $cart_total_price);
		echo json_encode($data);
		exit();

    }

    public function delete_cart_item(Request $request)
    {
    	$cart_item_id = $request->item_id;

    	$cart = (array)session()->get("cart");
    	$cart_total_price = (float)session()->get("total_price");

    	$cart_ids = array_column($cart, 'cart_id');
		$cart_key = (int)array_search($cart_item_id, $cart_ids);

		if ($request->action == 'delete') {

            $cart_total_price = $cart_total_price - $cart[$cart_key]['sub_total'];

            unset($cart[$cart_key]);
            $cart = array_values($cart);

            $data = array('status' => 'deleted', 'total_qty' => count($cart), 'total_price' => $cart_total_price);

            session()->put("cart", $cart);
            session()->put("total_price", $cart_total_price);
            session()->save();

            echo json_encode($data);
        }

    }

    public function checkoutProcess(){
        if(auth()->user()){
            return redirect(route('checkout'));
        }
        $countries = Country::where('display',1)->get();
        return view('checkout-login', compact('countries'));
    }

    public function checkout()
    {
    	$cart = session()->get("cart");
        if ($cart == null) {
            return redirect('/')->with('error', 'Shopping Cart Empty!');
        }
        
        if (session()->get('coupon_details')) {
            session()->forget('coupon_details');
            session()->save();
        }

        $cart_total_weight = 0;
        $cart_total_offer_price = 0;
        foreach ($cart as $key => $item) {
            
            $product = Product::where('id', $item['product_id'])->first();

            if ($product) {
                $item_total_weight = $product->weight * $item['ordered_qty'];
                $cart_total_weight += $item_total_weight;
            }

            $offer_check = Offer::check_offer($item['ordered_qty'], ['sub_total'], $product->id);

            if ($offer_check['has_offer'] == 1) {
                $final_offer = $offer_check['offer'];

                $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage/100);
                $offer_amount = round($offer_amount);

                if ($offer_amount > $final_offer->maximum_discount) {

                    $offer_amount = $final_offer->maximum_discount;
                }
                // echo $offer_amount.'='.$final_offer->discount_percentage.' of '.$item['sub_total'].'<br>';
                $cart_total_offer_price += $offer_amount;
            }

        }

        // dd($cart_total_offer_price);
        
    	$cart_total_price = (float)collect($cart)->sum('sub_total');
        session()->put("total_price", $cart_total_price);
        session()->save();
        // dd($cart_total_price);

        if (Auth::check()) {

            $user = Auth::user();
            $billing_details = $user->customer_addresses()->where('is_billing_address', 1)->first();
            $shipping_details = $user->customer_addresses()->where('is_shipping_address', 1)->first();
        } else {

            $user = null;
            $billing_details = null;
            $shipping_details = null;
        }

        $coupon_details = (array)session()->get('coupon_details');
        $countries = Country::where('display',1)->get();

    	return view('checkoutnew', compact('cart', 'cart_total_price', 'user', 'billing_details', 'shipping_details', 'countries', 'cart_total_weight', 'coupon_details', 'cart_total_offer_price'));
    }

    public function checkoutConfirmation(Request $request){
        $this->validate($request, 
                    [
                        'shipping_name' => 'required|max:255',
                        'shipping_phone' => 'required|max:225',
                        'shipping_email' => 'required|email|max:225',
                        'shipping_country_name' => 'required_if:shipping_country_id,0|max:225',
                        'shipping_country_id' => 'required_unless:shipping_country_id,0|max:225',
                        'shipping_state_name' => 'required_if:shipping_country_id,0|max:225',
                        'shipping_state_id' => 'required_unless:shipping_country_id,0|max:225',
                        'shipping_district_name' => 'required_if:shipping_country_id,0|max:225',
                        'shipping_district_id' => 'required_unless:shipping_country_id,0|max:225',
                        'shipping_city_name' => 'required_if:shipping_country_id,0|max:225',
                        'shipping_city_id' => 'required_unless:shipping_country_id,0|max:225',
                        'shipping_street_address_1' => 'required|max:225',

                        'billing_name' => 'required_unless:same_address,1|max:225',
                        'billing_phone' => ':same_address,1|max:225',
                        'billing_email' => 'requiredrequired_unless_unless:same_address,1|email|max:225',
                        // 'billing_country_name' => 'max:225|'.
                        //                             Rule::requiredIf(function(){
                        //                                 return !isset($this->request->same_address);
                        //                             }),
                        'billing_country_id' => 'required_unless:same_address,1|max:225',
                        // 'billing_state_name' => 'max:225|'.
                        //                             Rule::requiredIf(function(){
                        //                                 return !isset($this->request->same_address);
                        //                             }),
                        'billing_state_id' => 'required_unless:same_address,1|max:225',
                        // 'billing_district_name' => 'max:225|'.
                        //                             Rule::requiredIf(function(){
                        //                                 return !isset($this->request->same_address);
                        //                             }),
                        'billing_district_id' => 'required_unless:same_address,1|max:225',
                        // 'billing_city_name' => 'max:225|'.
                        //                             Rule::requiredIf(function(){
                        //                                 return !isset($this->request->same_address);
                        //                             }),
                        'billing_city_id' => 'required_unless:same_address,1|max:225',
                        'billing_street_address_1' => 'required_unless:same_address,1|max:225',
                        'payment_method' => 'required'
                    ]);

        $shipping = [
            'name' => $request->shipping_name,
            'pan' => $request->shipping_pan,
            'phone' => $request->shipping_phone,
            'phone2' => $request->shipping_phone2,
            'email' => $request->shipping_email,
            'country_id' => $request->shipping_country_id,
            'country_name' => $request->shipping_country_name,
            'state_id' => $request->shipping_state_id,
            'state_name' => $request->shipping_state_name,
            'district_id' => $request->shipping_district_id,
            'district_name' => $request->shipping_district_name,
            'city_id' => $request->shipping_city_id,
            'city_name' => $request->shipping_city_name,
            'pin_code' => $request->shipping_pin_code,
            'street_address_1' => $request->shipping_street_address_1,
            'street_address_2' => $request->shipping_street_address_2
        ];

        if($request->same_address == "1"){

            $billing = $shipping;

        }else{
            $billing = [
                'name' => $request->billing_name,
                'pan' => $request->billing_pan,
                'phone' => $request->billing_phone,
                'phone2' => $request->billing_phone2,
                'email' => $request->billing_email,
                'country_id' => $request->billing_country_id,
                'country_name' => $request->billing_country_name,
                'state_id' => $request->billing_state_id,
                'state_name' => $request->billing_state_name,
                'district_id' => $request->district_id,
                'district_name' => $request->billing_district_name,
                'city_id' => $request->billing_city_id,
                'city_name' => $request->billing_city_name,
                'pin_code' => $request->billing_pin_code,
                'street_address_1' => $request->billing_street_address_1,
                'street_address_2' => $request->billing_street_address_2
            ];
        }

        if(session()->has('checkout_details')){
            session()->forget('checkout_details');
        }
        session()->put('checkout_details', array('shipping'=> $shipping, 'billing' => $billing));
        if($request->shipping_cost){
            session()->put('shipping_cost', $request->shipping_cost);
            $shipping_cost = session()->get('shipping_cost');
        }else{
            $shipping_cost = 0;
        }
        $details = session()->get('checkout_details');
        $cart = session()->get('cart');
        $cart_total = session()->get('total_price');
        $coupon_details = (array)session()->get('coupon_details');

        $cart_total_weight = 0;
        $cart_total_offer_price = 0;
        foreach ($cart as $key => $item) {
            
            $product = Product::where('id', $item['product_id'])->first();

            if ($product) {
                $item_total_weight = $product->weight * $item['ordered_qty'];
                $cart_total_weight += $item_total_weight;
            }

            $offer_check = Offer::check_offer($item['ordered_qty'], ['sub_total'], $product->id);

            if ($offer_check['has_offer'] == 1) {
                $final_offer = $offer_check['offer'];

                $offer_amount = $item['sub_total'] * ($final_offer->discount_percentage/100);
                $offer_amount = round($offer_amount);

                if ($offer_amount > $final_offer->maximum_discount) {

                    $offer_amount = $final_offer->maximum_discount;
                }
                // echo $offer_amount.'='.$final_offer->discount_percentage.' of '.$item['sub_total'].'<br>';
                $cart_total_offer_price += $offer_amount;
            }

        }

    	return view('checkout-confirmation', compact('details', 'cart', 'cart_total', 'cart_total_weight', 'coupon_details', 'cart_total_offer_price', 'shipping_cost'));
    }

    public function get_cities(Request $request)
    {
        $district_id = $request->district_id;
        $city_id = $request->city_id;

        $district = District::find($district_id);
        $cities = $district->cities;

        $responseText = "<option value='' disabled selected>Select City</option>";
        
        foreach ($cities as $city) {

            if ($city->id == $city_id) {

                $selectFlag = 'selected';
                $selectedPinCode = $city->pin_code;
            }else{
                $selectFlag = '';
                $selectedPinCode = '';
            }

            $responseText .= "<option ".$selectFlag." data-pin-code='".$city->pin_code."' value='".$city->id."' >".$city->name."</option>";
        }

        $shipping_cost = 0;
        $courier_rate = $district->courier_rate;

        $cart = (array)session()->get("cart");
        $cart_total_price = (float)session()->get("total_price");

        if ($courier_rate) {
            // $cart_total_weight = $request->total_weight;

            
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

                $shipping_cost = $price_upto_five_kg + $price_over_five_kg;

            }elseif($cart_total_weight > 4.5 && $cart_total_weight <= 5 ){

                $shipping_cost = $courier_rate->five_kg;

            }elseif($cart_total_weight > 4 && $cart_total_weight <= 4.5 ){

                $shipping_cost = $courier_rate->four_half_kg;

            }elseif($cart_total_weight > 3.5 && $cart_total_weight <= 4 ){

                $shipping_cost = $courier_rate->four_kg;

            }elseif($cart_total_weight > 3 && $cart_total_weight <= 3.5 ){

                $shipping_cost = $courier_rate->three_half_kg;

            }elseif($cart_total_weight > 2.5 && $cart_total_weight <= 3 ){

                $shipping_cost = $courier_rate->three_kg;

            }elseif($cart_total_weight > 2 && $cart_total_weight <= 2.5 ){

                $shipping_cost = $courier_rate->two_half_kg;

            }elseif($cart_total_weight > 1.5 && $cart_total_weight <= 2 ){

                $shipping_cost = $courier_rate->two_kg;

            }elseif($cart_total_weight > 1 && $cart_total_weight <= 1.5 ){

                $shipping_cost = $courier_rate->one_half_kg;

            }elseif($cart_total_weight > 0.5 && $cart_total_weight <= 1 ){

                $shipping_cost = $courier_rate->one_kg;

            }elseif($cart_total_weight > 0 $cart_total_weight <= 0.5){

                $shipping_cost = $courier_rate->half_kg;

            }else{
                $shipping_cost = 0;
            }
            
        }
        $discount_amount = 0;
        if (session()->get('coupon_details')) {
            $coupon_details = (array)session()->get('coupon_details');
            $discount_amount = $coupon_details['discount_amount'];
        }

        $total_price = $cart_total_price + $shipping_cost - $discount_amount;

        $data = ['shipping_cost' => (int)$shipping_cost, 'responseText' => $responseText, 'total_price' => (int)$total_price];

        echo json_encode($data);
    }


    public function apply_coupon(Request $request){
        
        if (!Auth::check()) {

            $data = array('status' => 'auth_failed');
            echo json_encode($data);
            exit();
        }

        $cart = (array)session()->get('cart');
        // $cart_total_price = $request->sub_total;
        $cart_total_price = (float)session()->get("total_price");
        $shipping_cost = $request->shipping_cost;
        $coupon_details = (array)session()->get('coupon_details');

        if ($request->action == 'apply_coupon') {

            $code = strtolower($request->code);
            $coupon = DiscountCoupon::where('code', $code)->first();
            
            $todayDate = date('Y-m-d');

            if ($coupon) {

                if ($todayDate >= $coupon->start_date && $todayDate <= $coupon->expire_date ) {

                    if ($coupon->discount_type == 1) {

                        $user = User::find(Auth::user()->id);
                        $orders_count = $user->customer_orders()->count();

                        if ($orders_count > 0) {

                            $data = array('status' => 'first_invalid');
                            echo json_encode($data);
                            exit();
                        }

                        $alreadyApplied = AppliedCoupon::where([['customer_id', Auth::user()->id],['discount_coupon_id', $coupon->id]])->exists();

                        if ($alreadyApplied) {
                            $data = array('status' => 'already_used');
                            echo json_encode($data);
                            exit();
                        }                    
                    }else{

                        $applied_coupon_usage_count = AppliedCoupon::where([['customer_id', Auth::user()->id],['discount_coupon_id', $coupon->id]])->count();

                        if ($applied_coupon_usage_count >= $coupon->coupon_usage) {
                            $data = array('status' => 'applied_maximum');
                            echo json_encode($data);
                            exit();
                        }
                    }

                    if ($cart_total_price < $coupon->minimum_spend) {

                        $data = array('status' => 'min_spend_invalid', 'min_spend' => $coupon->minimum_spend);
                        echo json_encode($data);
                        exit();
                    }

                    $total_order_quantity = collect($cart)->sum('ordered_qty');

                    if ($total_order_quantity < $coupon->minimum_quantity) {

                        $data = array('status' => 'min_quantity_invalid', 'min_quantity' => $coupon->minimum_quantity);
                        echo json_encode($data);
                        exit();
                    }

                    $user = User::find(Auth::user()->id);
                    $alreadyApplied = AppliedCoupon::where([['customer_id', $user->id],['discount_coupon_id', $coupon->id]])->exists();

                    if ($alreadyApplied) {
                        
                        $data = array('status' => 'already_used');
                        echo json_encode($data);
                        exit();
                    }

                    $discount_amount = $cart_total_price * ($coupon->discount_percentage/100);

                    if ($discount_amount > $coupon->maximum_discount) {

                        $discount_amount = $coupon->maximum_discount;
                    }

                    $cart_total_price = $cart_total_price - $discount_amount + $shipping_cost;
                    $couponDiscount = $coupon->discount_percentage."% off (upto Nrs.".$coupon->maximum_discount.")";

                    session()->put("coupon_details", array(
                                                            "id" => $coupon->id, 
                                                            "code" => $coupon->code, 
                                                            "title" => $coupon->name." - ".$couponDiscount, 
                                                            "discount_amount" => $discount_amount
                                                        ));

                    $data = array('status' => 'calculated', 'title' => $coupon->name." - ".$couponDiscount, 'discount_amount' => $discount_amount, 'total_price' => round($cart_total_price, 2));
                }else{

                    $data = array('status' => 'invalid_date');

                }
            }else{
                $data = array('status' => 'invalid_code');
            }

            // echo $cart_total_price;
            // exit();
            // session()->put("total_price", $cart_total_price);
            // session()->save();
            
            echo json_encode($data);
        }

    }
}
