@extends('layouts.app')
@section('title', "CheckOut Success")
@push('post-css')
    <style type="text/css">
        .text-italic{
            font-style: italic;
        }
    </style>
@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Checkout Success
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{route('home')}}">Home /</a></li>
                            <li>Checkout Success</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="checkout-wrapper pt40 pb40">


            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <div class="checkout-message">
                        <img src="./success.png" alt="" class="checkout-image">

                        <h3 class="text-center"><strong>Your Order was placed successfully.</strong></h3>
                        <br>

                        @if(isset($status) && $status == 'success')
                            <h5 class="text-center text-italic">Payment has been approved. We will get back to you with further instructions.</h5>
                        @elseif(isset($status) && $status == 'failed')
                            <h5 class="text-center text-italic">Payment failed. You can pay from your Order History if you are logged in.</h5>
                        @elseif(isset($status) && $status == 'canceled')
                            <h5 class="text-center text-italic">Payment has been canceled. Please Pay to confirm your order from your Order History if you are logged in.</h5>
                        @endif

                        <h6 class="text-center">
                            Thank you for shopping with Jashn. You can track your order from your account if you are logged in.
                        </h6>

                    </div>
                </div>
            </div>
            <hr>
            <div id="order-summary-page">
                <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-1">
                            <span class="input-group-prepend">
                                <label class="input-group-text" style="min-width: 170px; background-color: #6b3d18; color: white;">
                                    <i class="ik ik-shopping-bag"></i>&nbsp; Order Number 
                                </label>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                    <strong style="color: #dfa855;">#{{ $order->order_no }}</strong>
                                </span>
                            </span>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-prepend">
                                <label class="input-group-text" style="min-width: 170px; background-color: #6b3d18; color: white;">
                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Ordered Date 
                                </label>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                    
                                    {{ date('jS F Y', strtotime($order->created_at)) }}
                                </span>
                            </span>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-prepend">
                                <label class="input-group-text" style="min-width: 170px; background-color: #6b3d18; color: white;">
                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Mode 
                                </label>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                    {{ $payment_method[$order->payment_method] }}
                                </span>
                            </span>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-prepend">
                                <label class="input-group-text" style="min-width: 170px; background-color: #6b3d18; color: white;">
                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Status 
                                </label>
                            </span>
                            <span class="input-group-append">
                                <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                    {{ $order->payment_status == 0 ? 'Payment Pending' : 'Payment Received' }}
                                </span>
                            </span>

                        </div>

                        {{-- <h3 class="mb-0">
                            <span style="min-width: 150px; display: inline-block;">Order No</span> : &nbsp;
                            <strong style="color: #dfa855;">#{{ $order->order_no }}</strong>
                        </h3>
                        <p class="mb-0">
                            <span style="min-width: 150px; display: inline-block;">Ordered Date</span> : &nbsp;&nbsp; 
                            {{ date('jS F Y', strtotime($order->created_at)) }}
                        </p>
                        <p class="mb-0">
                            <span style="min-width: 150px; display: inline-block;">Payment Mode</span> : &nbsp;&nbsp; 
                            {{ $payment_method[$order->payment_method] }}
                        </p>
                        <p class="mb-0">
                            <span style="min-width: 150px; display: inline-block;">Payment Status</span> : &nbsp;&nbsp; 
                            {{ $order->payment_status == 0 ? 'Payment Pending' : 'Payment Received' }}   
                        </p> --}}
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="table header-border table-hover" id="check-out">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th></th>
                                <th><strong>Product Name</strong></th>
                                <th><strong>Qty</strong></th>
                                <th class="text-right"><strong>MRP <small>(NRs.)</small></strong></th>
                                {{-- <th class="text-right"><strong>Offer</strong></th> --}}
                                <th class="text-right"><strong>Total <small>(NRs.)</small></strong></th>
                                <th>Weight</th>
                                <th style="font-size: 10px;">Delivery Due On</th>
                                <th class="text-center"><strong>Status</strong></th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalPrice = 0;
                            $total_quantity = 0;
                            $total_weight = 0;
                            $preorder_total_weight = 0;
                            $instock_total_weight = 0;
                            $total_mrp = 0;
                            $calculated_offer_price = 0;
                            $calculated_discount_price = 0;
                            $total_offer_price = $order->total_offer_amount;
                        @endphp
                        @foreach($order->ordered_products as $key => $ordered_product)
                            @php
                            
                            $product = \App\Models\Product::withTrashed()->where("id", $ordered_product->product_id)->first();

                            $product_color = $product->product_colors()->where('id', $ordered_product->product_color_id)->first();

                            $product_size = $product_color->product_sizes()->where('id', $ordered_product->product_size_id)->first();

                            if (!in_array($ordered_product->status, [6, 7, 8])) {
                                $totalPrice += $ordered_product->sub_total;

                                $total_mrp = $total_mrp + ($ordered_product->sub_total/$ordered_product->quantity);

                                $total_quantity = $total_quantity + $ordered_product->quantity;
                                $total_weight += ($ordered_product->quantity * $product->weight);
                                
                                if ($ordered_product->has_free_shipping == 0) {

                                    if ($ordered_product->preorder_status == 0) {
                                        
                                        $instock_total_weight = $instock_total_weight + ($ordered_product->quantity * $product->weight);
                                    }else{

                                        $preorder_total_weight = $preorder_total_weight + ($ordered_product->quantity * $product->weight);
                                    }
                                }

                                

                                $calculated_offer_price += (isset($ordered_product->ordered_product_offer) ? $ordered_product->ordered_product_offer->discount_amount : 0);

                                $calculated_discount_price += (isset($ordered_product->ordered_product_discount_coupon) ? $ordered_product->ordered_product_discount_coupon->discount_amount : 0);
                            }

                            @endphp

                            <tr id="ordered-product-row-{{ $ordered_product->id }}" style="{{ !isset($product) || in_array($ordered_product->status, [6,7,8]) ? 'background-color: #ffd7d7;' : '' }}">
                                
                                <td><strong>{{ $key+1 }}</strong>.</td>
                                <td class="text-center">

                                    <a href="{{ route('product-details',['slug' => $product->slug, 'c' => $product_color->color->code]) }}">

                                        @if(isset($product_color) && $product_color->image != NULL)
                                            <img src="{{ asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/thumb_'.$product_color->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                        @else
                                            <img src="{{ asset('storage/products/'.$product_color->product->slug.'/thumbs/thumb_'.$product_color->product->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                        @endif
                                    </a>

                                    {{-- @if(isset($product_color) && $product_color->image != NULL)
                                    
                                        <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug]) }}" >

                                            <img src="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/thumb_'.$product_color->image) }}" class="img-thumbnail" alt="{{ $product->slug }}" width="50">

                                        </a>

                                    @else

                                        <img src="https://place-hold.it/100x100/eeeef5?text=Image%20Unavailable&fontsize=8&italic&bold" width="50">

                                    @endif --}}
                                </td>
                                
                                <td class="text-left" >


                                    @if(isset($product))

                                        <a target="_blank" href="{{ url('product/'.$product->slug) }}">
                                            {{ $product->title }}
                                        </a>
                                        
                                        @if(isset($product_size) && $product_size->sku != NULL)
                                            <br>
                                            <strong style="color: #dfa855;">{{ $product_size->sku }}</strong>
                                        @endif

                                    @else
                                        <b>{{ $ordered_product->product_title }}</b> 

                                    @endif
                                    
                                    <br>
                                    @if($ordered_product->size_id != 0)
                                        <p style="display: inline-block;">
                                            Size : {{ strtoupper($ordered_product->size_name) }}

                                        </p>
                                        
                                    @endif

                                    {{-- @if($ordered_product->color_id != 0)
                                        Color : 
                                        <p style="margin-bottom: 0; display: inline-block; height: 16px; width: 16px; background: {{ $ordered_product->color_code }};"></p>

                                        <small style="display: inline-block; color: #778787; ">
                                            {{ strtoupper($ordered_product->color_name) }}
                                        </small>
                                    @endif
                                    <br> --}}

                                    @if(!isset($product))
                                        <br>
                                        <i style="font-size: 11px;">Product has been Deleted</i>
                                    @endif
                                    
                                    @if(in_array($ordered_product->status, [6,7,8]) && $ordered_product->remarks != NULL)
                                        <br>
                                        <strong style="color: red; font-size: 11px; text-decoration: underline;">
                                            {{ $ordered_product->remarks }}
                                        </strong>
                                    @endif

                                    @if($ordered_product->ordered_product_offer()->count() > 0)
                                        <br><i style="font-size: 11px;">Offer Applied*</i>
                                    @endif

                                    @if($ordered_product->ordered_product_discount_coupon()->count() > 0)
                                        <br><i style="font-size: 11px;">Coupon Applied*</i>
                                    @endif

                                    @if($ordered_product->has_free_shipping == 1)
                                        <br><small class="badge badge-primary" style="font-size: 10px;"><i class="ik ik-truck"></i></i> Free Shipping</small>
                                    @endif

                                    <!--<br>Offer - {{ isset($ordered_product->ordered_product_offer) ? $ordered_product->ordered_product_offer->discount_amount : 0 }}-->
                                    <!--<br>Coupon - {{ (isset($ordered_product->ordered_product_discount_coupon) ? $ordered_product->ordered_product_discount_coupon->discount_amount : 0) }}-->

                                </td>

                                <td class="text-center" >
                                    <b>{{(int)$ordered_product->quantity}}</b>
                                </td>

                                <td class="text-right" >
                                    <strong>
                                        {{ $ordered_product->sub_total/$ordered_product->quantity }}
                                    </strong>
                                </td>

                                {{-- <td class="text-right" >
                                    @if($ordered_product->ordered_product_offer()->count() > 0)
                                    <strong>
                                        {{ $ordered_product->ordered_product_offer->discount_amount }}
                                    </strong>
                                    @endif
                                </td> --}}
                                
                                <td class="text-right" >
                                    <strong>
                                        {{ $ordered_product->sub_total }}

                                    </strong>
                                </td>

                                <td class="text-center" >
                                    {{ $ordered_product->quantity * $product->weight }} Kg
                                </td>

                                <td class="text-center">
                                    <p>{{ $ordered_product->preorder_status == 1 ? '10-15 Days' : '2-5 Days'}}</p>
                                    @if($ordered_product->preorder_status == 1)
                                    <p class="mb-0" style="font-size: 10px;">
                                        {!! 
                                            \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($order->created_at)))->addDays(10)->format('jS M, Y') 
                                            . '<br> to <br>'. 
                                            \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($order->created_at)))->addDays(15)->format('jS M, Y') 
                                        !!}
                                    </p>
                                    @else
                                    <p style="font-size: 10px;">
                                        {!! 
                                            \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($order->created_at)))->addDays(2)->format('jS M, Y') 
                                            . '<br> to <br>'. 
                                            \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($order->created_at)))->addDays(5)->format('jS M, Y') 
                                        !!}
                                    </p>
                                    @endif
                                </td>

                                <td class="ordered-product-status text-center" id="orderedProductStatus{{ $ordered_product->id }}" width="10%">

                                    <small class="badge badge-{{ $order_status[$ordered_product->status][1] }}" >
                                        {{ $order_status[$ordered_product->status][0] }}
                                    </small>
                                </td>

                                <td class="text-center">
                                    @php
                                        $today_date = \Carbon\Carbon::now();

                                        $updated_date = \Carbon\Carbon::parse($ordered_product->updated_at);

                                        $hour_diff = $updated_date->diffInHours($today_date, false).'<br>';
                                        
                                    @endphp

                                    @if($ordered_product->status == 5 && $hour_diff <= 72 && !isset($ordered_product->return_request_product))
                                        <a class="btn btn-sm btn-primary return-ordered-product-btn" href="#returnProductModal" data-ordered-product-id="{{  $ordered_product->id }}" data-ordered-product-qty="{{ $ordered_product->quantity }}" data-toggle="modal">Return</a>
                                    @endif
                                </td>

                            </tr>
                            
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-left">Total</td>
                            <td class="text-center"><strong id="totalQty">{{ $total_quantity }}</strong></td>
                            <td class="text-right"><strong id="totalMrp">{{ $total_mrp }}</strong></td>
                            {{-- <td class="text-right"><strong id="totalOfferPrice">{{ $calculated_offer_price }}</strong></td> --}}
                            <td class="text-right"><strong id="totalPrice">{{ $totalPrice }}</strong></td>
                            <td class="text-center"><span id="totalWeight">{{ $total_weight }}</span> Kg</td>
                            <td colspan="3"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="5" class="text-Left">Offer </td>
                            
                            @php
                                $calculated_offer_price = round($calculated_offer_price);
                            @endphp

                            <th class="text-right"><span id="totalOfferPrice">{{ $calculated_offer_price }}</span></th>
                            
                        </tr>

                        @php
                            $totalPrice = $totalPrice - $calculated_offer_price;
                        @endphp
                        <tr>
                            <td colspan="5" class="text-Left">Total </td>
                            <td class="text-right" id="totalPriceAfterOffer">{{ $totalPrice }}</td>
                            
                        </tr>
                        @php
                            $calculated_discount_price = round($calculated_discount_price);
                        @endphp

                        @if(isset($order->applied_coupon))
                            <tr>
                                <td colspan="5" class="text-left">
                                    {{ $order->applied_coupon->coupon_title }} 
                                    <strong>[ {{ $order->applied_coupon->coupon_code }} ]</strong>
                                </td>
                                <th class="text-right">
                                    {{-- {{ $order->applied_coupon->discount_amount }} --}}
                                    {{ $calculated_discount_price }}
                                </th>
                                
                            </tr>

                            @php
                                // $totalPrice = $totalPrice - $order->applied_coupon->discount_amount;
                                $totalPrice = $totalPrice - $calculated_discount_price ;
                            @endphp

                            <tr>
                                <td colspan="5" class="text-left">
                                    Total
                                </td>
                                <td class="text-right">{{ $totalPrice }}</td>
                                
                            </tr>

                        @endif

                        <tr>
                            <td colspan="5" class="text-left">
                                Shipping
                            </td>
                            <th class="text-right">

                                @php
                                    $total_weight = $instock_total_weight + $preorder_total_weight;
                                    // dd($instock_total_weight.'---'.$preorder_total_weight);
                                    $instock_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $instock_total_weight);
                                    $preorder_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $preorder_total_weight);

                                    $total_delivery_charge = $instock_delivery_charge + $preorder_delivery_charge;

                                    $order->delivery_charge = $total_delivery_charge;
                                    // $order->save();
                                @endphp

                                {{ $order->delivery_charge }}
                            </th>
                            
                        </tr>

                        @php
                            $totalPrice = $totalPrice + $order->delivery_charge;
                        @endphp

                        <tr>
                            <td colspan="5" class="text-left">
                                Total
                            </td>
                            <td class="text-right"><span id="totalPriceAfterCoupon">{{ $totalPrice }}</span></td>
                            
                        </tr>

                        <tr>
                            <th colspan="5" class="text-left"> Grand Total </th>
                            <th class="text-right" style="font-size: 18px;">
                                <span id="grandTotalPrice">{{  $totalPrice }}</span>
                            </th>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
                <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Shipping Address</strong></p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $shipping_details->shipping_name }}</strong> -
                                                        <!--<strong>88717</strong><small>(Pan Number)</small></span>-->
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{$shipping_details->shipping_phone}}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $shipping_details->shipping_email }}</strong></span>
                                                </p>
                                            </div>
                                             @php
                                                    $shipping_city = \App\Models\City::where('id', $shipping_details->shipping_city_id)->first();

                                                    if ($shipping_city) {
                                                        $shipping_city_name = $shipping_city->name;
                                                    }else{
                                                        $shipping_city_name = $shipping_details->shipping_city_name;
                                                    }

                                                    $shipping_district = \App\Models\District::where('id',$shipping_details->shipping_district_id)->first();

                                                    if ($shipping_district) {
                                                        $shipping_district_name = $shipping_district->name;
                                                    }else{
                                                        $shipping_district_name = $shipping_details->shipping_district_name;
                                                    }

                                                    $shipping_state = \App\Models\State::where('id',$shipping_details->shipping_state_id)->first();

                                                    if ($shipping_state) {
                                                        $shipping_state_name = $shipping_state->name;
                                                    }else{
                                                        $shipping_state_name = $shipping_details->shipping_state_name;
                                                    }

                                                    $shipping_country = \App\Models\Country::where('id',$shipping_details->shipping_country_id)->first();

                                                    if ($shipping_country) {
                                                        $shipping_country_name = $shipping_country->name;
                                                    }else{
                                                        $shipping_country_name = $shipping_details->shipping_country_name;
                                                    }
                                                    
                                                @endphp
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>
                                                {{ $shipping_details->shipping_street_address_1 }}, {{ $shipping_details->shipping_street_address_2 }}
                                                {!! isset($shipping_city_name) ? $shipping_city_name : '<span style="color:red;">N-A</span>' !!}<br>
                                                {!! isset($shipping_district_name) ? $shipping_district_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($shipping_state_name) ? $shipping_state_name : '<span style="color:red;">N-A</span>' !!}
                                                
                                                {{ $shipping_details->shipping_pin_code }}<br>
                                                
                                                {!! isset($shipping_country_name) ? $shipping_country_name : '<span style="color:red;">N-A</span>' !!}</strong></span>
                                                </p>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Billing Address</strong> </p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $billing_details->billing_name }}</strong> -
                                                        <!--<strong>88717</strong><small>(Pan Number)</small></span>-->
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>
                                                    {{$billing_details->billing_phone}}

                                                    </strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $billing_details->billing_email }}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $billing_details->billing_street_address_1 }}, {{ $billing_details->billing_street_address_2 }}
                                                    @php
                                                    $billing_city = \App\Models\City::where('id', $billing_details->billing_city_id)->first();

                                                    if ($billing_city) {
                                                        $billing_city_name = $billing_city->name;
                                                    }else{
                                                        $billing_city_name = $billing_details->billing_city_name;
                                                    }

                                                    $billing_district = \App\Models\District::where('id',$billing_details->billing_district_id)->first();

                                                    if ($billing_district) {
                                                        $billing_district_name = $billing_district->name;
                                                    }else{
                                                        $billing_district_name = $billing_details->billing_district_name;
                                                    }

                                                    $billing_state = \App\Models\State::where('id',$billing_details->billing_state_id)->first();

                                                    if ($billing_state) {
                                                        $billing_state_name = $billing_state->name;
                                                    }else{
                                                        $billing_state_name = $billing_details->billing_state_name;
                                                    }

                                                    $billing_country = \App\Models\Country::where('id',$billing_details->billing_country_id)->first();

                                                    if ($billing_country) {
                                                        $billing_country_name = $billing_country->name;
                                                    }else{
                                                        $billing_country_name = $billing_details->billing_country_name;
                                                    }

                                                @endphp
                                                 {!! isset($billing_city_name) ? $billing_city_name : '<span style="color:red;">N-A</span>' !!}<br>
                                                {!! isset($billing_district_name) ? $billing_district_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($billing_state_name) ? $billing_state_name : '<span style="color:red;">N-A</span>' !!}
                                                
                                                {{ $billing_details->billing_pin_code }}<br>
                                                
                                                {!! isset($billing_country_name) ? $billing_country_name : '<span style="color:red;">N-A</span>' !!}
                                                </strong></span>
                                                </p>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection