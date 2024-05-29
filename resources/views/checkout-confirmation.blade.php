@extends('layouts.app')
@section('title', 'Checkout Confirmation')
@section('content')

    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        CheckOut Review
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Checkout Confirmation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="checkout-wrapper pt40 pb40">
            <form action="{{ route('place-order') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-8">

                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Shipping Address</strong></p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12" style="line-height: 1.4;">

                                                <strong>{{ $details['shipping']['name'] }}</strong>

                                                @if($details['shipping']['pan'] !== null)
                                                    <small>(PAN - {{ $details['shipping']['pan'] }})</small>
                                                @endif
                                                <br>

                                                {{ $details['shipping']['email'] }}<br>

                                                <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $details['shipping']['phone'])}}">{{ $details['shipping']['phone'] }}</a>

                                                @if($details['shipping']['phone2'] != NULL)
                                                    <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $details['shipping']['phone2'])}}">{{ $details['shipping']['phone2'] }}</a>
                                                @endif
                                                <br>

                                                {{ $details['shipping']['street_address_1'] }}, {{ $details['shipping']['street_address_2'] }}<br>

                                                @php
                                                    $shipping_city = \App\Models\City::where('id', $details['shipping']['city_id'])->first();

                                                    if ($shipping_city) {
                                                        $shipping_city_name = $shipping_city->name;
                                                    }else{
                                                        $shipping_city_name = $details['shipping']['city_name'];
                                                    }

                                                    $shipping_district = \App\Models\District::where('id',$details['shipping']['district_id'])->first();

                                                    if ($shipping_district) {
                                                        $shipping_district_name = $shipping_district->name;
                                                    }else{
                                                        $shipping_district_name = $details['shipping']['district_name'];
                                                    }

                                                    $shipping_state = \App\Models\State::where('id',$details['shipping']['state_id'])->first();

                                                    if ($shipping_state) {
                                                        $shipping_state_name = $shipping_state->name;
                                                    }else{
                                                        $shipping_state_name = $details['shipping']['state_name'];
                                                    }

                                                    $shipping_country = \App\Models\Country::where('id',$details['shipping']['country_id'])->first();

                                                    if ($shipping_country) {
                                                        $shipping_country_name = $shipping_country->name;
                                                    }else{
                                                        $shipping_country_name = $details['shipping']['country_name'];
                                                    }

                                                @endphp

                                                {!! isset($shipping_city_name) ? $shipping_city_name : '<span style="color:red;">N-A</span>' !!}

                                                {!! isset($shipping_district_name) ? $shipping_district_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($shipping_state_name) ? $shipping_state_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {{ $details['shipping']['pin_code'] }}<br>
                                                
                                                {!! isset($shipping_country_name) ? $shipping_country_name : '<span style="color:red;">N-A</span>' !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Billing Address</strong></p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12" style="line-height: 1.4;">

                                                <strong>{{ $details['billing']['name'] }}</strong>
                                                @if($details['billing']['pan'] !== null)
                                                    <small>(PAN - {{ $details['billing']['pan'] }})</small>
                                                @endif
                                                <br>
                                                {{ $details['billing']['email'] }}<br>
                                                <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $details['billing']['phone'])}}">{{ $details['billing']['phone'] }}</a>
                                                @if($details['billing']['phone2'] != NULL)
                                                    <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $details['billing']['phone2'])}}">{{ $details['billing']['phone2'] }}</a>
                                                @endif
                                                <br>
                                                {{ $details['billing']['street_address_1'] }}, {{ $details['billing']['street_address_2'] }}<br>
                                                @php
                                                    $billing_city = \App\Models\City::where('id', $details['billing']['city_id'])->first();

                                                    if ($billing_city) {
                                                        $billing_city_name = $billing_city->name;
                                                    }else{
                                                        $billing_city_name = $details['billing']['city_name'];
                                                    }

                                                    $billing_district = \App\Models\District::where('id',$details['billing']['district_id'])->first();

                                                    if ($billing_district) {
                                                        $billing_district_name = $billing_district->name;
                                                    }else{
                                                        $billing_district_name = $details['billing']['district_name'];
                                                    }

                                                    $billing_state = \App\Models\State::where('id',$details['billing']['state_id'])->first();

                                                    if ($billing_state) {
                                                        $billing_state_name = $billing_state->name;
                                                    }else{
                                                        $billing_state_name = $details['billing']['state_name'];
                                                    }

                                                    $billing_country = \App\Models\Country::where('id',$details['billing']['country_id'])->first();

                                                    if ($billing_country) {
                                                        $billing_country_name = $billing_country->name;
                                                    }else{
                                                        $billing_country_name = $details['billing']['country_name'];
                                                    }

                                                @endphp

                                                {!! isset($billing_city_name) ? $billing_city_name : '<span style="color:red;">N-A</span>' !!}
                                                {!! isset($billing_district_name) ? $billing_district_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($billing_state_name) ? $billing_state_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {{ $details['billing']['pin_code'] }}<br>
                                                
                                                {!! isset($billing_country_name) ? $billing_country_name : '<span style="color:red;">N-A</span>' !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="mb-0"><strong>Cart Review</strong></p>
                        <div class="table-wrapper">
                            <table id="check-out">
                                <tr>
                                    <th style="font-size: 10px;">Product</th>
                                    <th style="font-size: 10px;">Size</th>
                                    <th style="font-size: 10px;">Quantity</th>
                                    <th style="font-size: 10px;">MRP</th>
                                    <th style="font-size: 10px;">Offer Price</th>
                                    <th style="font-size: 10px;">Total</th>
                                    <th style="font-size: 10px;">Estimated Delivery Date</th>
                                </tr>
                                @php
                                    $total_price = 0;
                                @endphp
                                @foreach($cart as $key => $item)
                                @php
                                    $cProd = \App\Models\Product::where("id", $item["product_id"])->first();
                                    $total_price += $item['sub_total'];
                                    $product_color = \App\Models\ProductColor::where('id', $item['product_color_id'])->first();
                                    $product_size = \App\Models\ProductSize::where('id', $item['product_size_id'])->first();
                                    if ($product_size) {

                                        if ($product_size->quantity >= $item['ordered_qty']) {

                                            $out_of_stock = 0;
                                        } else {

                                            if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                                                $out_of_stock = 0;
                                            } else {
                                                
                                                $out_of_stock = 1;
                                            }
                                        }
                                    }

                                @endphp
                                <tr class="cart-item-{{ $item['cart_id'] }}" style="{{ $out_of_stock == 1 ? 'background-color: #ffd8d8;' : '' }}">
                                    <td>
                                        <div class="list">
                                            <div>
                                                @if($product_color->image != NULL)
                                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                                @else
                                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                                @endif
                                            </div>
                                            <div class="detail">
                                                <p><a href="{{ route('product-details',['slug' => $cProd->slug, 'c' => $product_color->color->code]) }}">{{ $cProd->title }}</a></p>
                                                <p>{{ $product_size->sku }}</p>
                                                @if($out_of_stock == 1)
                                                <i style="font-size: 10px; color: red;">Out of Stock</i>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mx-auto">
                                            {{-- <p>{{ $product_color->color->title }}</p> --}}
                                            <p>{{ $product_size->size->name }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item['ordered_qty'] }} 
                                        
                                    </td>
                                    <td>
                                        <div class="mrp">
                                            <p>
                                                Nrs.
                                                <span class="price-{{ $key }}">
                                                    
                                                    {{ $product_size->price }}
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="offer-price">
                                            @if($product_size->price != '' || $product_size->price != 0)
                                                @if($product_size->offer_price != '' || $product_size->offer_price != 0)
                                                    <p>
                                                        Nrs.
                                                        <span class="offer-price-{{ $key }}">
                                                            {{ $product_size->offer_price }}
                                                        </span>
                                                    </p>
                                                @endif
                                            @else
                                                @if($cProd->offer_price != '' || $cProd->offer_price != 0)
                                                <p>
                                                    Nrs.
                                                    <span class="offer-price-{{ $key }}"> 
                                                        {{ $cProd->offer_price }}
                                                    </span>
                                                </p>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="total-price">
                                            <p>
                                                Nrs.
                                                <span class="sub-total-{{ $key }}">
                                                    {{ $item['sub_total'] }}
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="delivery">
                                            <p>{{$product_size->quantity <= 0 &&  $product_size->preorder == 1 ? '10-15 Days' : '2-5 Days'}}</p>

                                            @if($product_size->quantity <= 0 && $product_size->preorder == 1)
                                                <p style="font-size: 10px;">
                                                    {{ 
                                                        \Carbon\Carbon::today()->addDays(10)->format('jS') 
                                                        . ' - '. 
                                                        \Carbon\Carbon::today()->addDays(15)->format('jS M, Y') 
                                                    }}
                                                </p>
                                            @else
                                                <p style="font-size: 10px;">
                                                    {{ 
                                                        \Carbon\Carbon::today()->addDays(2)->format('jS') 
                                                        . ' - '. 
                                                        \Carbon\Carbon::today()->addDays(5)->format('jS M, Y') 
                                                    }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="checkout-cart">
                            <h6>Cart Details</h6>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p>Cart Total</p>
                                </div>
                                <div class="col-6 text-right">
                                    <p><strong>Nrs. {{ $cart_total }}</strong></p>
                                </div>

                                <div class="col-6">
                                    <p>Offer</p>
                                </div>
                                <div class="col-6 text-right">
                                    @php
                                        $cart_total = $cart_total - $cart_total_offer_price;
                                    @endphp
                                    <input type="hidden" id="totalOfferPrice" value="{{ $cart_total_offer_price == NULL ? 0 : $cart_total_offer_price }}">
                                    <p><strong>- Nrs. {{ $cart_total_offer_price == NULL ? 0 : $cart_total_offer_price }}</strong></p>
                                </div>


                                <div class="col-6 coupon-details" style="display: none">
                                    <p id="couponTitle"></p>
                                </div>
                                <div class="col-6 text-right coupon-details" style="display: none">
                                    <p><strong>- Nrs. <span id="discountAmount">0</span></strong></p>
                                    <input type="hidden" id="discountAmount" value="0">
                                </div>

                                <input type="hidden" id="totalWeight" value="0.7">

                                <div class="col-6">
                                    <p>Shipping Cost <small>({{ $cart_total_weight }} Kg)</small></p>
                                </div>
                                <div class="col-6 text-right">
                                    @php
                                        $cart_total = $cart_total + $shipping_cost;
                                    @endphp
                                    <input type="hidden" id="totalbillingCost" value="{{ $shipping_cost }}">
                                    <p>+ <strong>Nrs. <span id="billingCost">{{ $shipping_cost }}</span></strong>
                                    </p>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <p>Grand Total</p>
                                </div>
                                <div class="col-6 text-right">
                                    <p><strong>Nrs. <span id="totalPrice">{{ $cart_total }}</span></strong></p>
                                </div>
                                <div class="col-12 form-inline">
                                    <input id="couponCode" class="input-text"  placeholder="Coupon code" type="text">
                                    <input id="applyCoupon" class="main-button colored"  value="Apply coupon" type="button">
                                </div>
                            </div>
                        </div>
                        <div class="checkout-left">
                            <h6>Payment Options</h6>
                            <hr>
                            @if(isset($success_rate) && $success_rate >75 || $success_rate==0)
                            
                            <div class="col-sm-12" id="cashOnDelivery">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="cash-input" value="1" checked>
                                    <label for="cash-input">Cash On Delivery</label>
                                </div>
                                <div class="cash-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="card" value="2">
                                    <label for="card">Pay Using Debit/Credit Card</label>
                                </div>
                                <div class="card-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>

                            {{-- <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="esewa" value="3" disabled>
                                    <label for="esewa">Pay Via Esewa <small>(coming soon)</small></label>
                                </div>
                                <div class="esewa-show pay-details">
                                    <img src="./images/qr-code.png" alt="" class="qr-code img-fluid">
                                    <p>Upload the Screenshot after scanning the code.</p>
                                    <input type="file">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="fone" value="4" disabled>
                                    <label for="fone">Fone Pay <small>(coming soon)</small></label>
                                </div>
                                <div class="fone-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div> --}}
                            <hr>
                            <button id="placeOrder" type="submit" class="main-button colored">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <section>
        <div id="toogle">
            <h3>See more about Jashn</h3>
            <i class="fa fa-chevron-down arrow" style="padding: 8px;"></i>
        </div>
    </section>
@endsection
@push('post-scripts')
<script>
    $('#applyCoupon').click(function (e) {
            e.preventDefault();

            if ($("#couponCode").val() == '') {
                toastr['error']('Please enter valid Coupon Code!');
                return;
            }

            $.ajax({
                url : "{{ URL::route('apply-coupon') }}",
                type: "POST",
                data: {
                        '_token' : '{{ csrf_token() }}',
                        code : $("#couponCode").val(),
                        shipping_cost : $("#totalbillingCost").val(),
                        offer_price : $("#totalOfferPrice").val(),
                        action: 'apply_coupon'
                    },
                beforeSend: function () {
                    $('#modal-loader').show();
                },
                success: function (response) {
                    $('#modal-loader').hide();
                    console.log("success");
                    console.log("response " + response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.status == 'calculated') {   

                        toastr['success']('Coupon Code Applied Successfully!');

                        $('#couponTitle').html(obj.title);
                        $('#discountAmount').html(obj.discount_amount);
                        $('#totalPrice').html(obj.total_price);
                        $(".coupon-details").show();
                        // $("#couponCode").prop('disabled', 'true');
                        // $("#applyCoupon").prop('disabled', 'true');
                        
                    }else if(obj.status == 'invalid_date'){

                        toastr['error']('Coupon is already expired!');
                    }else if(obj.status == 'invalid_code'){
                        
                        toastr['error']('Invalid Coupon Code');
                    }else if(obj.status == 'none'){
                        
                        toastr['error']('None of the cart Items are eligible for this Coupon Code!');
                    }else if(obj.status == 'already_used'){
                        
                        toastr['error']('Coupon Already Used!');
                    }else if(obj.status == 'no_coupons'){
                        
                        toastr['error']('Sorry! All the Coupons have been Used up!');
                    }else if(obj.status == 'auth_failed'){
                        
                        toastr['error']('Please Login to Apply Coupon!');
                    }else if(obj.status == 'applied_maximum'){
                        
                        toastr['error']('You have applied this Coupon code to maximum limit!');
                    }else if(obj.status == 'first_invalid'){
                        
                        toastr['error']('You are not eligible for this Coupon!');
                    }else if(obj.status == 'min_spend_invalid'){
   
                        toastr['error']('Please Spend upto Nrs.'+obj.min_spend +' to apply this code!');
                    }else if(obj.status == 'min_quantity_invalid'){
   
                        toastr['error']('You must buy '+obj.min_quantity +' items in total to apply this code!');
                    };
                }
            });

        });
</script>
@endpush