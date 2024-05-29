<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Color;
use App\Models\Size;
use App\Models\DiscountCoupon;
use App\Models\AppliedCoupon;
use App\Models\OnRoute;
use App\Models\OnRouteOrderedProduct;
use App\Models\Courier;
use App\Models\OrderedProductRTS;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\Offer;
use App\Services\ModelHelper;
use Illuminate\Database\Eloquent\Builder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at','desc')->get();
        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        return view('backend.orders.list-orders', compact('orders','order_status','payment_method'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = [];
        $checkout_details = [];
        $coupon_details = [];
        $cart_products = $request->product;
        foreach ($cart_products as $key => $item) {
            $product_size = ProductSize::findOrFail($item['product_size_id']);

            $product_price = 0;
            if ($product_size->price != NULL && $product_size->price != 0) {

                if ($product_size->offer_price != NULL || $product_size->offer_price != 0) {
                    $product_price = $product_size->offer_price;
                }else{
                    $product_price = $product_size->price;
                }
            }

            $item_sub_total = $product_price * (int)$item['ordered_qty'];

            $itemArray = [
                'cart_id' => $product_size->id,
                'product_id'  => $product_size->product_color->product->id,
                'product_title' => $product_size->product_color->product->title,
                'product_color_id' => $product_size->product_color->id,
                'color_name' => $product_size->product_color->color->title,
                'color_code' => $product_size->product_color->color->code,
                'product_size_id' => $product_size->id,
                'size_name' => $product_size->size->name,
                'ordered_qty' => $item['ordered_qty'],
                'sub_total' => $item_sub_total,
                'preorder' => $product_size->preorder
            ];

            array_push($cart, $itemArray);
        }

        // dd($cart);
        $shipping = [
            'name' => $request->shipping_name,
            'pan' => $request->shipping_pan,
            'phone' => $request->shipping_phone,
            'phone2' => $request->shipping_phone2,
            'email' => $request->shipping_email,
            'country_id' => $request->shipping_country_id,
            'country_name' => $request->shipping_country_name,
            'state_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_state_id,
            'state_name' => $request->shipping_state_name,
            'district_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_district_id,
            'district_name' => $request->shipping_district_name,
            'city_id' => $request->shipping_country_id == 0 ? 0 : $request->shipping_city_id,
            'city_name' => $request->shipping_city_name,
            'pin_code' => $request->shipping_pin_code,
            'street_address_1' => $request->shipping_street_address_1,
            'street_address_2' => $request->shipping_street_address_2
        ];

        if(isset($request->same_address) && $request->same_address == "1"){

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
                'state_id' => $request->billing_country_id == 0 ? 0 : $request->billing_state_id,
                'state_name' => $request->billing_state_name,
                'district_id' => $request->billing_country_id == 0 ? 0 : $request->billing_district_id,
                'district_name' => $request->billing_district_name,
                'city_id' => $request->billing_country_id == 0 ? 0 : $request->billing_city_id,
                'city_name' => $request->billing_city_name,
                'pin_code' => $request->billing_pin_code,
                'street_address_1' => $request->billing_street_address_1,
                'street_address_2' => $request->billing_street_address_2
            ];
        }

        $checkout_details['billing'] = $billing;
        $checkout_details['shipping'] = $shipping;


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
        $payment_status = $request->payment_status;
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
                        return redirect()->back()->with('stock_error', $item['product_title'] . ' is sold out!');
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
                
                // session()->put('cart', $cart);
                // session()->save();
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
        // dd($cart_total_price);

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
            'customer_id' => 0,
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
                            dd($item['product_title'] . ' is sold out!');
                            return redirect()->back()->with('stock_error', $item['product_title'] . ' is sold out!');
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
                    dd('size not found');
                    return redirect()->back()->with('status', 'Size not Found!');
                }
            } else {
                dd('color not found');
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

            foreach ($cart as $item) {


                // ==================================== Stock Calculations =======================================

                $product_size = ProductSize::where('id', $item['product_size_id'])->first();

                if ($product_size) {

                    if ($product_size->quantity >= $item['ordered_qty']) {

                        $rem_stock = $product_size->quantity - $item["ordered_qty"];
                        ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);
                    } else {

                        if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                            $rem_stock = $product_size->quantity - $item["ordered_qty"];
                            ProductSize::where('id', $item['product_size_id'])->update(['quantity' => $rem_stock]);

                            $rem_stock = $product_size->preorder_stock_limit - $item["ordered_qty"];
                            ProductSize::where('id', $item['product_size_id'])->update(['preorder_stock_limit' => $rem_stock]);
                        }
                    }
                }
            }


            // if (Auth::check() && isset($coupon_details['id'])) {

            //     $user = User::find(Auth::user()->id);

            //     $appliedCouponArray = array(
            //         'customer_id' => Auth::user()->id,
            //         'order_id' => $order->id,
            //         'discount_coupon_id' => $coupon_details['id'],
            //         'coupon_code' => $coupon_details['code'],
            //         'coupon_title' => $coupon_details['title'],
            //         'discount_amount' => $coupon_details['discount_amount']
            //     );

            //     AppliedCoupon::create($appliedCouponArray);
            // }
            // dd($order);

            return redirect()->route('admin.orders.index')->with('status', 'Order Created Successfully!');
        } else {
            return redirect()->back()->withInput()->with("error", "Sorry! Order Couldn't be Created.");
        }

        // dd($checkout_details);
        // dd($_POST);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order_no)
    {
        $order = Order::where('order_no', $order_no)->firstOrFail();
        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        $canceled_reasons = Order::canceled_reasons();
        $billing_details = json_decode($order->billing_details);
        $shipping_details = json_decode($order->shipping_details);
        
        return view('backend.orders.view-order-details', compact('order', 'order_status', 'payment_method', 'canceled_reasons', 'billing_details', 'shipping_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function save_order_note(Request $request)
    {
        $id = $request->id;
        $order_note = $request->order_note;

        $order = Order::find(base64_decode($id));

        if ($order) {
            
            $order->additional_message = $order_note;
            $noteSaved = $order->save();

            if ($noteSaved) {

                $data = array('status'=> 'success');
            }else{

                $data = array('status' => 'error');
            }

        }else{
            $data = array('status' => 'error');
        }

        echo json_encode($data);
    }

    public function change_payment_select(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $selected_value = $request->selected_value;

        $order = Order::find(base64_decode($id));

        if ($order) {
            if ($type == 'payment-mode') {
                $order->payment_method = $selected_value;
            }elseif ($type == 'payment-status') {
                $order->payment_status = $selected_value;
            }

            $updated = $order->save();

            if ($updated) {

                $data = array('status'=> 'success');
            }else{

                $data = array('status' => 'error');
            }

        }else{
            $data = array('status' => 'error');
        }

        echo json_encode($data);
    }

    public function change_order_status(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        
        $order->status = $request->status;
        $statusChanged = $order->save();

        if ($statusChanged) {
            
            $data = array('status'=> 'success');
            $ordered_products = $order->ordered_products()->update(['status' => $request->status]);

        }else{

            $data = array('status'=> 'error');
        }

        echo json_encode($data);

    }

    public function change_ordered_product_status(Request $request)
    {
        $ordered_product = OrderedProduct::where('id', $request->id)->first();

        if ($ordered_product) {

            $ordered_product->status = $request->status;
            $statusChanged = $ordered_product->save();

            if ($statusChanged) {
                
                $order = Order::where('id', $ordered_product->order_id)->first();

                $same_order_ordered_products = $order->ordered_products()->where('status', '!=', $request->status)->get();

                if ($same_order_ordered_products->count() == 0) {

                    $order->status = $request->status;
                    $order->save();
                }

                $data = array('status'=> 'success');
            }else{

                $data = array('status'=> 'error');
            }

        }else{
            $data = array('status'=> 'error');
        }

        echo json_encode($data);

    }

    public function cancel_ordered_product(Request $request)
    {
        // dd($_POST);
        $ordered_product = OrderedProduct::findOrFail($request->ordered_product_id);
        $canceled_reasons = Order::canceled_reasons();
        // dd($ordered_product->product_size);
        $ordered_product->status = $request->status;
        $ordered_product->remarks = $request->remarks;

        if (!in_array($request->remarks, array_values($canceled_reasons))) {
            return redirect()->back()->with('error', 'Please Select Canceled Reason from the List!');
        }

        // dd('test');
        $statusChanged = $ordered_product->save();

        if ($statusChanged) {
            
            if ($ordered_product->preorder_status == 1) {

                $new_quantity = $ordered_product->product_size->quantity + $ordered_product->quantity;

                if ($new_quantity <= 0) {

                    $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + $ordered_product->quantity;
                    
                    $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);

                }else{

                    if ($ordered_product->product_size->quantity < 0) {
                        $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + abs($ordered_product->product_size->quantity);
                    }else{
                        $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit;
                    }

                    $new_quantity = $ordered_product->quantity + $ordered_product->product_size->quantity;

                    
                    $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                }

            }else{

                $new_stock = $ordered_product->product_size->quantity + $ordered_product->quantity;
                $ordered_product->product_size()->update(['quantity' => $new_stock]);
            }

            $order = Order::where('id', $ordered_product->order_id)->first();

            $same_order_ordered_products = $order->ordered_products()->where('status', '!=', $request->status)->get();

            if ($same_order_ordered_products->count() == 0) {

                $order->status = $request->status;
                $order->save();
            }

            return redirect()->back()->with('status', 'Order is Canceled!');
        }else{

            return redirect()->back()->with('error', 'Something went Wrong!');
        }
    }

    public function change_selected_ordered_product_status(Request $request)
    {
        $statusChanged = OrderedProduct::whereIn('id', $request->ordered_product_ids)->update(['status' => $request->status]);

        if ($statusChanged) {

            $data = array('status'=> 'success');
        }else{

            $data = array('status'=> 'error');
        }
        

        echo json_encode($data);

    }

    // ============================================ ON ROUTE ORDERS FUNCTIONALITIES STARTS HERE ==================================

    public function on_route()
    {
        $on_route = OnRoute::find(1);
        // dd($on_route->ordered_products()->where('ordered_products.status', 3)->get());
        $on_routes = OnRoute::where('status',2)->orderBy('created_at', 'desc')->get();
        return view('backend.orders.list-on-routes', compact('on_routes'));

    }

    public function create_on_route()
    {
        $orders = Order::whereHas('ordered_products', function($query){
                                $query->where('preorder_status', 1)->whereIn('status', [0,1])->whereNotIn('status', [6,7]);
                            })->orderBy('created_at','desc')->get();

        $product_sizes = ProductSize::whereNotNull('sku')->get();

        return view('backend.orders.create-update-on-routes', compact('orders', 'product_sizes'));

    }

    public function store_on_route(Request $request)
    {   
        // dd($_POST);
        $insertArray = [
                        'name' => $request->name,
                        'status' => 2,
                        'created_by' => Auth::user()->name,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

        $on_route_created = OnRoute::create($insertArray);

        if ($on_route_created) {

            $on_route_orders = $request->on_route;
            $on_route_others = $request->on_route_other;

            

            foreach ($on_route_orders as $on_route_order) {
                
                $on_route_ordered_products = $on_route_order['ordered_product_id'];

                for ($i=0; $i < count($on_route_ordered_products); $i++) { 

                    $on_route_ordered_product_doesnt_exists =  OnRouteOrderedProduct::where([
                                                                        ['order_id', $on_route_order['order_id']],
                                                                        ['ordered_product_id', $on_route_ordered_products[$i]]
                                                                    ])->doesntExist();

                    if ($on_route_ordered_product_doesnt_exists) {

                        $ordered_product = OrderedProduct::where([
                                                                    ['order_id',$on_route_order['order_id']],
                                                                    ['id', $on_route_ordered_products[$i]]
                                                                ])->first();

                        if ($ordered_product) {

                            OnRouteOrderedProduct::create([
                                                        'on_route_id' => $on_route_created->id,
                                                        'order_id' => $on_route_order['order_id'], 
                                                        'ordered_product_id' => $on_route_ordered_products[$i],
                                                        'status' => 2
                                                    ]);

                            $ordered_product->status = 2;
                            $statusChanged = $ordered_product->save();

                            if ($statusChanged) {
                                
                                $order = Order::where('id', $ordered_product->order_id)->first();
                                $same_order_ordered_products = $order->ordered_products()->where('status', '!=', 2)->get();

                                if ($same_order_ordered_products->count() == 0) {
                                    $order->status = 2;
                                    $order->save();
                                }

                            }

                        }

                    }

                }
            }

            if(isset($on_route_others)){

                foreach ($on_route_others as $on_route_other) {
                    $on_route_created->on_route_product_sizes()->updateOrCreate(
                                                                    ['product_size_id' => $on_route_other['product_size_id']],
                                                                    ['quantity' => $on_route_other['quantity']]
                                                                );

                }
            }
            // dd('success');
            return redirect()->route('admin.orders.on-route')->with('status','On Route created Successfully!');
        }else{
            // dd('error');
            return redirect()->back()->with('error','Something went Wrong!');
        }

    }


    public function edit_on_route($id)
    {
        $orders = Order::whereHas('ordered_products', function($query){
                                $query->where('preorder_status', 1);
                            })->orderBy('created_at','desc')->get();

        $on_route = OnRoute::findOrFail($id);
        // dd($on_route->on_route_product_sizes);
        $db_on_route_ordered_products = $on_route->on_route_ordered_products->groupBy('order_id')->all();
        $product_sizes = ProductSize::whereNotNull('sku')->get();
        // dd($db_on_route_ordered_products);

        return view('backend.orders.create-update-on-routes', compact('orders', 'on_route', 'db_on_route_ordered_products', 'product_sizes'));

    }

    public function update_on_route(Request $request, OnRoute $on_route)
    {   
        // dd($_POST);
        // dd(collect($request->on_route_other)->pluck('product_size_id')->all());
        $updateArray = [
                        'name' => $request->name,
                        'updated_by' => Auth::user()->name,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

        $on_route_updated = $on_route->update($updateArray);

        if ($on_route_updated) {

            $on_route_orders = $request->on_route;
            $on_route_others = $request->on_route_other;

            foreach ($on_route_orders as $on_route_order) {
                
                $on_route_ordered_products = $on_route_order['ordered_product_id'];

                for ($i=0; $i < count($on_route_ordered_products); $i++) { 

                    $on_route_ordered_product_doesnt_exists =  OnRouteOrderedProduct::where([
                                                                        ['order_id', $on_route_order['order_id']],
                                                                        ['ordered_product_id', $on_route_ordered_products[$i]]
                                                                    ])->doesntExist();

                    if ($on_route_ordered_product_doesnt_exists) {

                        $ordered_product = OrderedProduct::where([
                                                                    ['order_id',$on_route_order['order_id']],
                                                                    ['id', $on_route_ordered_products[$i]]
                                                                ])->first();

                        if ($ordered_product) {

                            OnRouteOrderedProduct::create([
                                                        'on_route_id' => $on_route->id,
                                                        'order_id' => $on_route_order['order_id'], 
                                                        'ordered_product_id' => $on_route_ordered_products[$i],
                                                        'status' => 2
                                                    ]);

                            $ordered_product->status = 2;
                            $statusChanged = $ordered_product->save();

                            if ($statusChanged) {
                                
                                $order = Order::where('id', $ordered_product->order_id)->first();
                                $same_order_ordered_products = $order->ordered_products()->where('status', '!=', 2)->get();

                                if ($same_order_ordered_products->count() == 0) {
                                    $order->status = 2;
                                    $order->save();
                                }

                            }

                        }

                    } 

                }

                $on_route->on_route_ordered_products()->where('order_id', $on_route_order['order_id'])->whereNotIn('ordered_product_id', $on_route_order['ordered_product_id'])->delete();
            }
            
            if (isset($request->on_route_other)) {
        
                foreach ($on_route_others as $on_route_other) {
                    $on_route->on_route_product_sizes()->updateOrCreate(
                                                                    ['product_size_id' => $on_route_other['product_size_id']],
                                                                    ['quantity' => $on_route_other['quantity']]
                                                                );

                }
            }
            $product_size_ids = collect($request->on_route_other)->pluck('product_size_id')->all();
            $on_route->on_route_product_sizes()->wherenotIn('product_size_id', $product_size_ids)->delete();
            // dd('success');
            return redirect()->route('admin.orders.on-route')->with('status','On Route has been updated Successfully!');
        }else{
            // dd('error');
            return redirect()->back()->with('error','Something went Wrong!');
        }

    }

    public function view_on_route($id)
    {
        
        $orders = Order::whereHas('ordered_products', function($query){
                                $query->where('preorder_status', 1);
                            })->orderBy('created_at','desc')->get();

        $on_route = OnRoute::findOrFail($id);
        
        $db_on_route_ordered_products = $on_route->on_route_ordered_products->groupBy('order_id')->all();
        // $db_on_route_product_sizes = $on_route->on_route_product_sizes;
        // dd($db_on_route_ordered_products);

        return view('backend.orders.view-on-route-order-details', compact('orders', 'on_route', 'db_on_route_ordered_products'));

    }

    public function get_related_ordered_products(Request $request)
    {
        $order_id = $request->order_id;

        $order = Order::find($order_id);
        // $ordered_products = $order->ordered_products()->where('preorder_status', 1)->get();

        $response = '';
        $db_ordered_product_ids = [];

        if ($request->on_route_id != 0) {

            // $ordered_products = $order->ordered_products()->doesntHave('on_route_ordered_products')->orWhereHas('on_route_ordered_products', function(Builder $query) use ($request){
            //     $query->where('on_route_id', base64_decode($request->on_route_id));
            // })->where('preorder_status', 1)->get();

            $on_route = OnRoute::find(base64_decode($request->on_route_id));
            $db_ordered_product_ids = $on_route->on_route_ordered_products()->where('order_id', $order_id)->pluck('ordered_product_id')->all();

            $ordered_products = $order->ordered_products()->where('preorder_status',1)->doesntHave('on_route_ordered_products')->orWhere(function($query) use($db_ordered_product_ids){
                $query->whereIn('id', $db_ordered_product_ids)->where('preorder_status', 1);
            })->get();

        }else{

            $ordered_products = $order->ordered_products()->doesntHave('on_route_ordered_products')->whereNotIn('status', [6,7])->where('preorder_status', 1)->get();
        }

        foreach ($ordered_products as $key => $ordered_product) {

            $selected_status = in_array($ordered_product->id, $db_ordered_product_ids) ? 'selected' : '';

            $response .= '<option '.$selected_status.' value="'.$ordered_product->id.'">'.$ordered_product->product->title.' ( '.$ordered_product->product_size->sku.' ) </option>';

        }

        $response = array('ordered_products' => $response);

        echo json_encode($response);
    }

    public function add_more_orders(Request $request)
    {
        $key = $request->key;
        $orders = Order::whereHas('ordered_products', function($query){
                                $query->where('preorder_status', 1)->whereIn('status', [0,1]);
                            })->orderBy('created_at','desc')->get();

        $response = '';
        $response .= '<div class="card-body border on-route-orders mb-1" id="on-route-order-'.$key.'" data-cumulative-count="'.$key.'">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group input-group mb-0">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-shopping-bag"></i>&nbsp; Order</label>
                                    </span>
                                    <select name="on_route['.$key.'][order_id]" onchange="get_related_ordered_products(this)" data-ordered-product-select-id="ordered-products-'.$key.'" class="form-control select2" required>
                                        <option disabled selected>Select Order</option>';
                                        foreach($orders as $order){
                                            $response .= '<option value="'.$order->id.'">#'.$order->order_no.'</option>';
                                        }
                                        
                                    $response .= '</select>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="input-group input-group mb-0">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-shopping-cart"></i>&nbsp; Ordered Product</label>
                                    </span>
                                    <select name="on_route['.$key.'][ordered_product_id][]" id="ordered-products-'.$key.'" class="ordered-product form-control select2" multiple required>
                                        
                                    </select>

                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-outline-danger remove-on-route-order-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-order-'.$key.'">
                                            <i class="fa fa-trash m-0"></i>
                                        </button>
                                    </span></div>
                            </div>
                            
                        </div>
                    </div>';

        $response = array('response' => $response);

        echo json_encode($response);
    }

    public function add_more_products(Request $request)
    {
        $key = $request->key;
        $product_sizes = ProductSize::whereNotNull('sku')->get();

        $response = '';
        $response .= '<div class="col-md-4 on-route-others mb-1" id="on-route-other-'.$key.'" data-cumulative-count="'.$key.'">
                            <div class="card-body border">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group mb-1">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text">
                                                    <i class="ik ik-shopping-cart"></i>&nbsp; Product
                                                </label>
                                            </span>
                                            <select name="on_route_other['.$key.'][product_size_id]" class="form-control other-product select2" required>
                                                <option disabled selected>Select Product</option>';

                                                foreach($product_sizes as $product_size){
                                                    $response .= '<option value="'.$product_size->id.'">'.$product_size->sku.'</option>';
                                                }
                                                
                                            $response .= '</select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="input-group input-group mb-1">
                                            <span class="input-group-prepend">
                                                <label class="input-group-text">
                                                    <i class="ik ik-shopping-cart"></i>&nbsp; Quantity
                                                </label>
                                            </span>
                                            <input type="number" name="on_route_other['.$key.'][quantity]" class="form-control other-product" min="1" required>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-outline-danger remove-on-route-other-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-other-'.$key.'">
                                                    <i class="fa fa-trash m-0"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>';

        $response = array('response' => $response);

        echo json_encode($response);
    }


    public function change_on_route_status(Request $request)
    {
        $on_route = OnRoute::find($request->id);

        if (!in_array($request->status, [2,3])) {

            $data = array('status'=> 'error');
            echo json_encode($data);
            exit();

        }
        
        $on_route->status = $request->status;
        $statusChanged = $on_route->save();

        if ($statusChanged) {
            
            $data = array('status'=> 'success');

            $ordered_products = $on_route->on_route_ordered_products()->update(['status' => $request->status]);
            $on_route->ordered_products()->where('ordered_products.status', 2)->update(['ordered_products.status' => $request->status]);

            if ($request->status == 3) {

                // dd($on_route->on_route_ordered_products);
                // echo "<pre>";
                foreach ($on_route->on_route_ordered_products as $key => $on_route_ordered_product) {
                    // dd($on_route_ordered_product->ordered_product->product_size);
                    $ordered_quantity = $on_route_ordered_product->ordered_product->quantity;
                    $product_size = $on_route_ordered_product->ordered_product->product_size;

                    $new_quantity = $product_size->quantity + $ordered_quantity;

                    if ($new_quantity <= 0) {

                        $new_preorder_stock_limit = $product_size->preorder_stock_limit + $ordered_quantity;
                        // $tempArray = ['product_size_id' => $product_size->id, 'quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit];

                        // echo 'product_size_id ------>' . $product_size->id. ' quantity ---------> ' . $new_quantity, ' preorder_stock_limit -----> ' . $new_preorder_stock_limit.' ordered_quantity ------> '. $ordered_quantity. '<br>' ;
                        $product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);

                    }else{

                        $new_preorder_stock_limit = $product_size->quantity < 0 ? ($product_size->preorder_stock_limit + abs($product_size->quantity)) : $product_size->preorder_stock_limit;
                        $new_quantity = $ordered_quantity + $product_size->quantity;

                        // $tempArray = ['product_size_id' => $product_size->id, 'quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit];

                        // echo 'product_size_id ------>' . $product_size->id. ' quantity ---------> ' . $new_quantity, ' preorder_stock_limit -----> ' . $new_preorder_stock_limit.' ordered_quantity ------> '. $ordered_quantity. '<br>' ;
                        $product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                    }

                    // dd($new_quantity);
                    // $on_route_ordered_product->ordered_product->product_size->update(['preorder_price' => 1]);
                    // dd($on_route_ordered_product->ordered_product);
                    // var_dump($tempArray);
                }

                foreach ($on_route->on_route_product_sizes as $on_route_product_size) {
                    // dd($on_route_product_size);

                    $ordered_quantity = $on_route_product_size->quantity;
                    $product_size = $on_route_product_size->product_size;
                    // dd($ordered_quantity);

                    $new_quantity = $product_size->quantity + $ordered_quantity;
                    // dd($new_quantity);
                    if ($new_quantity <= 0) {

                        $new_preorder_stock_limit = $product_size->preorder_stock_limit + $ordered_quantity;
                        // dd($new_preorder_stock_limit);
                        $product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);

                    }else{

                        $new_preorder_stock_limit = $product_size->quantity < 0 ? ($product_size->preorder_stock_limit + abs($product_size->quantity)) : $product_size->preorder_stock_limit;
                        $new_quantity = $ordered_quantity + $product_size->quantity;
                        // dd(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                        $product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                    }

                }
            }


        }else{

            $data = array('status'=> 'error');
        }

        echo json_encode($data);

    }

    // Arrived Order starts here= =================================================================================================

    public function arrived()
    {
        $arrived = OnRoute::where('status',3)->orderBy('updated_at', 'desc')->get();
        return view('backend.orders.list-arrived', compact('arrived'));

    }
     public function canceled()
    {
        $canceled = Order::where('status', 6)->orderBy('created_at', 'desc')->get();
        // $canceled = OrderedProduct::where('status', 6)->orderBy('created_at', 'desc')->get();

        return view('backend.orders.list-canceled', compact('canceled'));
    }

    public function returned()
    {
        $returned = OrderedProduct::where('status', 7)->orderBy('created_at', 'desc')->get();
        // $returned = OrderedProduct::where('status', 6)->orderBy('created_at', 'desc')->get();

        return view('backend.orders.list-returned', compact('returned'));
    }
    public function view_arrived($id)
    {
        
        $orders = Order::whereHas('ordered_products', function($query){
                                $query->where('preorder_status', 1);
                            })->orderBy('created_at','desc')->get();

        $arrived = OnRoute::findOrFail($id);
           
        $arrived_ordered_products = $arrived->on_route_ordered_products->groupBy('order_id')->all();
        $failed_reasons = Order::failed_reasons();
        $canceled_reasons = Order::canceled_reasons();
        $order_status = Order::order_status();
        // dd($arrived_ordered_products);
        // $arrived_product_sizes = $arrived->on_route_product_sizes;
        // dd($arrived_ordered_products);

        return view('backend.orders.view-arrived-order-details', compact('orders', 'arrived', 'arrived_ordered_products', 'failed_reasons', 'canceled_reasons', 'order_status'));

    }

    public function change_arrived_product_status(Request $request)
    {   
        
        $on_route_id = $request->on_route_id;
        $order_id = $request->order_id;
        $status = $request->status;

        $on_route = OnRoute::find($on_route_id);
        

        if ($status == 4) {
            
            $on_route->on_route_ordered_products()->where('order_id', $order_id)->update(['status' => $request->status]);
            $on_route->ordered_products()->where('ordered_products.order_id', $order_id)->update(['ordered_products.status' => $request->status]);

            $data = array('status'=> 'success');
            echo json_encode($data);

        }elseif ($status == 6 || $status == 8) {

            $canceled_reasons = Order::canceled_reasons();
            $failed_reasons = Order::failed_reasons();

            if ($status == 6 && !in_array($request->remarks, array_values($canceled_reasons))) {
                return redirect()->back()->with('error', 'Please Select Canceled Reason from the List!');
            }elseif ($status == 8 && !in_array($request->remarks, array_values($failed_reasons))) {
                return redirect()->back()->with('error', 'Please Select Failed Reason from the List!');
            }
            
            $on_route->on_route_ordered_products()->where('order_id', $order_id)->update(['status' => $request->status]);
            $on_route->ordered_products()->where('ordered_products.order_id', $order_id)->update(['ordered_products.status' => $request->status, 'ordered_products.remarks' => $request->remarks]);

            $on_route_ordered_products = $on_route->ordered_products()->where('ordered_products.order_id', $order_id)->get();

            foreach ($on_route_ordered_products as $key => $ordered_product) {
                    
                if ($ordered_product->preorder_status == 1) {

                    $new_quantity = $ordered_product->product_size->quantity + $ordered_product->quantity;

                    if ($new_quantity <= 0) {

                        $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + $ordered_product->quantity;
                        
                        $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);

                    }else{

                        if ($ordered_product->product_size->quantity < 0) {
                            $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + abs($ordered_product->product_size->quantity);
                        }else{
                            $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit;
                        }

                        $new_quantity = $ordered_product->quantity + $ordered_product->product_size->quantity;

                        
                        $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                        // dd($ordered_product->product_size);
                    }

                }else{
                    
                    $new_stock = $ordered_product->product_size->quantity + $ordered_product->quantity;
                    $ordered_product->product_size()->update(['quantity' => $new_stock]);
                }


            }
            
            return redirect()->back()->with('status', 'Status changed Successfully!!');

        }

        // dd('test');

        // if (!in_array($status, [4])) {

        //     $data = array('status'=> 'error');
        //     echo json_encode($data);
        //     exit();

        // }

        

    }

    // RTS Starts HEre ==================================================================================================

    public function rts()
    {
        $ordered_products = OrderedProduct::where([['status', 4]])->whereDoesntHave('ordered_product_rts', function(Builder $query){
            $query->where('status', '!=', 0);
        })->orderBy('created_at','desc')->get()->groupBy('order_id','preorder_status')->all();
        // dd($ordered_products);

        // Order::whereHas('ordered_products', function($query){
        //                         $query->where([['status', 4],['is_shipped',0]]);
        //                     })->orderBy('created_at','desc')->get();

        // dd($orders);
        
        $couriers = Courier::where('display',1)->get();
        $payment_method = Order::payment_method();
        return view('backend.orders.list-rts', compact('ordered_products', 'couriers', 'payment_method'));

    }

    public function manifest(Request $request)
    {
        $request->validate([
            'rts' => 'required'
        ],
        [
            'rts.required' => 'Please Select at least one order!'
        ]);

        
        $rts = $request->rts;

        if (isset($request->manifest)) {
            $status = 1;
        }elseif(isset($request->save)){
            $status = 0;
        }

        foreach ($rts as $key => $row) {
            
            $ordered_product_ids = $row['ordered_product_id'];
            // dd($rts[36]);

            if (isset($request->manifest)) {
                OrderedProduct::whereIn('id', $ordered_product_ids)->update(['is_shipped' => 1]);
            }

            for ($i=0; $i < count($ordered_product_ids); $i++) { 

                OrderedProductRTS::updateOrCreate(
                    [
                        'order_id' => $row['order_id'], 
                        'ordered_product_id' => $ordered_product_ids[$i]
                    ],
                    [
                        'courier_id' => $row['courier_id'],
                        'tracking_no' => $row['tracking_no'],
                        'invoice_no' => $row['invoice_no'],
                        'status' => $status,
                    ]
                );
            }
        }
        // dd('success');
        return redirect()->back()->with('status', 'Selected Orders are ready for Shipment');
    }

    // Shipment Starts HEre ==================================================================================================

    public function shipment()
    {
        $ordered_product_shipments = OrderedProductRTS::where('status',1)->orderBy('updated_at', 'desc')->get()->groupBy('tracking_no')->all();
        // dd($ordered_product_shipments);
        $couriers = Courier::where('display',1)->get();
        $payment_method = Order::payment_method();
        $failed_reasons = Order::failed_reasons();
        return view('backend.orders.list-shipment', compact('ordered_product_shipments', 'couriers', 'payment_method', 'failed_reasons'));

    }

    public function change_shipment_status(Request $request)
    {
        $ordered_product_rts = OrderedProductRTS::where('tracking_no', $request->tracking_no)->get();

        foreach ($ordered_product_rts as $key => $rts) {
            $rts->ordered_product()->update(['status' => 5]);
        }

        $data = array('status'=> 'success');
        OrderedProductRTS::where('tracking_no', $request->tracking_no)->update(['status' => 2]);
        echo json_encode($data);
    }

    public function failed_shipment_ordered_product(Request $request)
    {

        $ordered_product_rts = OrderedProductRTS::where('tracking_no', $request->tracking_no)->get();
        $failed_reasons = Order::failed_reasons();

        if (!in_array($request->remarks, array_values($failed_reasons))) {
            return redirect()->back()->with('error', 'Please Select Canceled Reason from the List!');
        }

        foreach ($ordered_product_rts as $key => $rts) {

            $rts->ordered_product()->update(['status' => 8, 'remarks' => $request->remarks]);
            $ordered_product = $rts->ordered_product;

            if ($ordered_product->preorder_status == 1) {

                $new_quantity = $ordered_product->product_size->quantity + $ordered_product->quantity;

                if ($new_quantity <= 0) {

                    $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + $ordered_product->quantity;
                    
                    $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);

                }else{

                    if ($ordered_product->product_size->quantity < 0) {
                        $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit + abs($ordered_product->product_size->quantity);
                    }else{
                        $new_preorder_stock_limit = $ordered_product->product_size->preorder_stock_limit;
                    }

                    $new_quantity = $ordered_product->quantity + $ordered_product->product_size->quantity;

                    
                    $ordered_product->product_size->update(['quantity' => $new_quantity, 'preorder_stock_limit' => $new_preorder_stock_limit]);
                }

            }else{

                $new_stock = $ordered_product->product_size->quantity + $ordered_product->quantity;
                $ordered_product->product_size()->update(['quantity' => $new_stock]);
            }

            $order = Order::where('id', $ordered_product->order_id)->first();

            $same_order_ordered_products = $order->ordered_products()->where('status', '!=', $request->status)->get();

            if ($same_order_ordered_products->count() == 0) {

                $order->status = $request->status;
                $order->save();
            }

        }

        OrderedProductRTS::where('tracking_no', $request->tracking_no)->update(['status' => 2]);

        return redirect()->back()->with('status', 'Status Changed Successfully');
    }

    public function add_new_order()
    {
        $products = Product::where('display',1)->get();
        $product_sizes = ProductSize::has('product_color.product')->where(function(Builder $query){

                                $query->where([['display', 1],['quantity', '>',  0]])
                                      ->orWhere([['display', 1],['preorder',1],['preorder_stock_limit', '>', 0]]);

                            })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();

        $payment_method = Order::payment_method();
        $countries = Country::where('display',1)->get();
        return view('backend.orders.add-new-order', compact('products', 'product_sizes', 'payment_method', 'countries'));
    }

    public function addProduct($index)
    {
        $product_sizes = ProductSize::has('product_color.product')->where(function(Builder $query){

                                $query->where([['display', 1],['quantity', '>',  0]])
                                      ->orWhere([['display', 1],['preorder',1],['preorder_stock_limit', '>', 0]]);

                            })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();

        $responseText = '<tr class="product-items" id="product-item-'.$index.'" data-cumulative-count="'.$index.'">
                            <td>
                                <div class="input-group mb-1">
                                    <select name="product['.$index.'][product_size_id]" class="form-control product-size-select select2" onchange="call_product_function(this)" data-key="'.$index.'" required>
                                        <option selected disabled>Select Product</option>';

                                        foreach($product_sizes as $key => $product_size){
                                            
                                            $max_order_qty = $product_size->quantity > 0 ? $product_size->quantity : $product_size->preorder_stock_limit;
                                            

                                            $responseText .= '<option value="'.$product_size->id.'" 
                                                data-product-id="'.$product_size->product_color->product->id.'"
                                                data-product-color-id="'.$product_size->product_color->id.'"
                                                data-stock-count="'.$max_order_qty.'"
                                                data-final-price="'.$product_size->final_price.'"
                                                >

                                                '.$product_size->product_color->product->title.'
                                                
                                                <b>
                                                    ( '.$product_size->size->name.', 
                                                    '.$product_size->product_color->color->title.' )
                                                </b>
                                                - [ '.$product_size->sku.' ]
                                            </option>';
                                        }

                                    $responseText.= '</select>
                                </div>
                            </td>

                            <td>
                                <div class="input-group mb-1">
                                    <input id="ordered-qty-'.$index.'" class="form-control" type="number" name="product['.$index.'][ordered_qty]" value="1" min="1" max="" onchange="calculate_total_price(this)" data-key="'.$index.'" required>
                                </div>
                            </td>

                            <td>
                                <span id="product-item-price-'.$index.'">0</span>
                            </td>

                            <td>
                                <span class="sub-total-price" id="product-total-price-'.$index.'">0</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-product-button" onclick="removeProduct(this)" data-index="'.$index.'"><i class="fa fa-trash mr-0"></i></button>
                            </td>
                        </tr>';

        echo $responseText;
    }
}
