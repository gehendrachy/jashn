@extends('layouts.app')
@section('title', "CheckOut")
@push('post-css')
    <style type="text/css">
        .billing-other-field-wrapper i, .shipping-other-field-wrapper i{
            position: absolute;
            right:8px;
            top:50%;
            transform: translateY(-50%);
            font-size:12px;
            color:red;
            z-index:9;
            opacity: 0.75;
        }
        .billing-other-field-wrapper i:hover, .shipping-other-field-wrapper i:hover{
            cursor: pointer;
        }

        ::placeholder {
          color: #b4bac3 !important;  
          font-size: 14px !important;
        } 
    </style>
@endpush
@section('content')
	<div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        CheckOut
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Checkout</li>
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
                        <h6><strong>Billing Address</strong></h6>
                        <hr>
                        <div class="row">
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-name">Name*</label>
                                <input type="text" name="billing_name" placeholder="Name" id="input-billing-name" class="form-control" value="{{ old('billing_name') ? old('billing_name') : (isset($billing_details->name) ? $billing_details->name : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-pan">Pan </label>
                                <input type="text" name="billing_pan" placeholder="Eg: 88766676" class="form-control" id="input-billing-pan" value="{{ old('billing_pan') ? old('billing_pan') : (isset($billing_details->pan) ? $billing_details->pan : '') }}">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-phone">Phone Number(Primary)*</label>
                                <input type="text" name="billing_phone" placeholder="+977-123456789" id="input-billing-phone" class="form-control" value="{{ old('billing_phone') ? old('billing_phone') : (isset($billing_details->phone) ? $billing_details->phone : '') }}" required >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-phone2">Phone Number 2</label>
                                <input type="text" name="billing_phone2" placeholder="+977-123456789" id="input-billing-phone2" class="form-control" value="{{ old('billing_phone2') ? old('billing_phone2') : (isset($billing_details->phone2) ? $billing_details->phone2 : '') }}" >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-email">E-Mail*</label>
                                <input type="email" name="billing_email" placeholder="E-Mail" id="input-billing-email" class="form-control" value="{{ old('billing_email') ? old('billing_email') : (isset($billing_details->email) ? $billing_details->email : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label for="input-billing-country-select">Country*</label>
                                <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-billing-country-name" type="text" name="billing_country_name" class="form-control billing-other-country" placeholder="Enter Country Name" value="{{ old('billing_country_name') ? old('billing_country_name') : (isset($billing_details->country_name) ? $billing_details->country_name : '') }}">
                                    <i id="showCountrySelect" class="fa fa-times show-country-select"
                                        data-country-id="{{ old('billing_country_id') ? old('billing_country_id') : (isset($billing_details->country_id) ? $billing_details->country_id : '') }}"
                                        data-state-id="{{ old('billing_state_id') ? old('billing_state_id') : (isset($billing_details->state_id) ? $billing_details->state_id : '') }}" 
                                        data-district-id="{{ old('billing_district_id') ? old('billing_district_id') : (isset($billing_details->district_id) ? $billing_details->district_id : '') }}" 
                                        data-city-id="{{ old('billing_city_id') ? old('billing_city_id') : (isset($billing_details->city_id) ? $billing_details->city_id : '') }}" 
                                        data-country-input-id="input-billing-country-select" 
                                        data-state-input-id="input-billing-state-select" 
                                        data-district-input-id="input-billing-district-select" 
                                        data-city-input-id="input-billing-city-select"
                                        data-other-field-wrapper-class="billing-other-field-wrapper"
                                        data-other-country-class="billing-other-country"
                                        data-country-select-class="billing-country-select"></i>
                                </div>
                                <select name="billing_country_id" 
                                        id="input-billing-country-select" 
                                        data-state-id="{{ old('billing_state_id') ? old('billing_state_id') : (isset($billing_details->state_id) ? $billing_details->state_id : 0) }}" 

                                        data-district-id="{{ old('billing_district_id') ? old('billing_district_id') : (isset($billing_details->district_id) ? $billing_details->district_id : 0) }}"

                                        data-city-id="{{ old('billing_city_id') ? old('billing_city_id') : (isset($billing_details->city_id) ? $billing_details->city_id : 0) }}"

                                        data-state-input-id="input-billing-state-select" 
                                        data-district-input-id="input-billing-district-select" 
                                        data-city-input-id="input-billing-city-select" 
                                        data-other-field-wrapper-class="billing-other-field-wrapper"
                                        data-other-country-class="billing-other-country"
                                        data-country-select-class="billing-country-select"
                                        class="w-100 py-1 form-control country-select billing-country-select" required>
                                    <option selected disabled>Select Country</option>
                                    @php
                                        $tempCountry = old('billing_country_id') ? old('billing_country_id') : (isset($billing_details->country_id) ? $billing_details->country_id : '');
                                    @endphp

                                    @foreach($countries as $country)
                                        <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option {{ $tempCountry == 0 ? 'selected' : '' }} value="0">Other</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-state-select">State*</label>
                                <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-billing-state-name" type="text" name="billing_state_name" class="form-control billing-other-country" placeholder="Enter State Name" value="{{ old('billing_state_name') ? old('billing_state_name') : (isset($billing_details->state_name) ? $billing_details->state_name : '') }}">
                                </div>
                                <select name="billing_state_id" 
                                        id="input-billing-state-select" 

                                        data-district-id="{{ old('billing_district_id') ? old('billing_district_id') : (isset($billing_details->district_id) ? $billing_details->district_id : 0) }}" 

                                        data-city-id="{{ old('billing_city_id') ? old('billing_city_id') : (isset($billing_details->city_id) ? $billing_details->city_id : 0) }}"

                                        data-district-input-id="input-billing-district-select" 
                                        data-city-input-id="input-billing-city-select" 
                                        class="w-100 py-1 form-control state-select billing-country-select" 
                                        required>
                                    <option selected disabled>Select Country First</option>
                                </select>
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-district-select">District*</label>
                                <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-billing-district-name" type="text" name="billing_district_name" class="form-control billing-other-country" placeholder="Enter District Name" value="{{ old('billing_district_name') ? old('district_name') : (isset($billing_details->district_name) ? $billing_details->district_name : '') }}">
                                </div>
                                <select name="billing_district_id" 
                                        id="input-billing-district-select" 
                                        data-city-id="{{ old('billing_city_id') ? old('billing_city_id') : (isset($billing_details->city_id) ? $billing_details->city_id : 0) }}" 
                                        data-city-input-id="input-billing-city-select" 
                                        data-pin-code-id="input-billing-pin-code" 
                                        class="w-100 py-1 form-control district-select billing-country-select" 
                                        required>
                                    <option selected disabled>Select State First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-city-select">City*</label>
                                <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-billing-city-name" type="text" name="billing_city_name" class="form-control billing-other-country" placeholder="Enter City Name" value="{{ old('billing_city_name') ? old('billing_city_name') : (isset($billing_details->city_name) ? $billing_details->city_name : '') }}">
                                </div>
                                <select name="billing_city_id" id="input-billing-city-select" data-pin-code-id="input-billing-pin-code" class="w-100 py-1 form-control city-select billing-country-select" required>
                                    <option selected disabled>Select District First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-pin-code">Pin Code</label>
                                <input type="text" name="billing_pin_code" value="{{ old('billing_pin_code') ? old('billing_pin_code') : (isset($billing_details->pin_code) ? $billing_details->pin_code : '') }}" id="input-billing-pin-code" placeholder="Eg: +977" class="form-control">
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-street-address-1">Street Address 1*</label>
                                <input type="text" name="billing_street_address_1" value="{{ old('billing_street_address_1') ? old('billing_street_address_1') : (isset($billing_details->street_address_1) ? $billing_details->street_address_1 : '') }}" placeholder="Eg: 23 burrow street" id="input-billing-street-address-1" class="form-control" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-billing-street-address-2">Street Address 2</label>
                                <input type="text" name="billing_street_address_2" value="{{ old('billing_street_address_2') ? old('billing_street_address_2') : (isset($billing_details->street_address_2) ? $billing_details->street_address_2 : '') }}" placeholder="Eg: 23 burrow street" id="input-billing-street-address-2" class="form-control">
                            </div>
                        </div>
                        <input name="same_address" value="1" id="ship-box" type="checkbox" {{ old('same_address') == 1 ? 'checked' : ( Auth::check() ? (isset($shipping_address) ? 'checked' : '') : '') }}>
                        <label for="ship-box">
                            &nbsp;<span>Shipping Address is same as Billing Address.</span>
                        </label>

                        <div class="row" id="ship-box-info" style="display: inline-flex;">
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-name">Name*</label>
                                <input type="text" name="shipping_name" placeholder="Name" id="input-shipping-name" class="form-control shipping-address-status req-not-req" value="{{ old('shipping_name') ? old('shipping_name') : (isset($shipping_details->name) ? $shipping_details->name : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-pan">Pan </label>
                                <input type="text" name="shipping_pan" placeholder="Eg: 88766676" id="input-shipping-pan" class="form-control shipping-address-status" value="{{ old('shipping_pan') ? old('shipping_pan') : (isset($shipping_details->pan) ? $shipping_details->pan : '') }}">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-phone">Phone Number(Primary)*</label>
                                <input type="text" name="shipping_phone" placeholder="+977-123456789" id="input-shipping-phone" class="form-control shipping-address-status req-not-req" value="{{ old('shipping_phone') ? old('shipping_phone') : (isset($shipping_details->phone) ? $shipping_details->phone : '') }}" required >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-phone2">Phone Number 2</label>
                                <input type="text" name="shipping_phone2" placeholder="+977-123456789" id="input-shipping-phone2" class="form-control shipping-address-status" value="{{ old('shipping_phone2') ? old('shipping_phone2') : (isset($shipping_details->phone2) ? $shipping_details->phone2 : '') }}" >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-email">E-Mail*</label>
                                <input type="email" name="shipping_email" placeholder="E-Mail" id="input-shipping-email" class="form-control shipping-address-status req-not-req" value="{{ old('shipping_email') ? old('shipping_email') : (isset($shipping_details->email) ? $shipping_details->email : '') }}" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label for="name">Country*</label>
                                <div class="shipping-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-shipping-country-name" type="text" name="shipping_country_name" class="form-control shipping-other-country" placeholder="Enter Country Name" value="{{ old('shipping_country_name') ? old('shipping_country_name') : (isset($shipping_details->country_name) ? $shipping_details->country_name : '') }}">
                                    <i id="showCountrySelect" class="fa fa-times show-country-select"
                                        data-country-id="{{ old('shipping_country_id') ? old('shipping_country_id') : (isset($shipping_details->country_id) ? $shipping_details->country_id : '') }}"
                                        data-state-id="{{ old('shipping_state_id') ? old('shipping_state_id') : (isset($shipping_details->state_id) ? $shipping_details->state_id : '') }}" 
                                        data-district-id="{{ old('shipping_district_id') ? old('shipping_district_id') : (isset($shipping_details->district_id) ? $shipping_details->district_id : '') }}" 
                                        data-city-id="{{ old('shipping_city_id') ? old('shipping_city_id') : (isset($shipping_details->city_id) ? $shipping_details->city_id : '') }}" 
                                        data-country-input-id="input-shipping-country-select" 
                                        data-state-input-id="input-shipping-state-select" 
                                        data-district-input-id="input-shipping-district-select" 
                                        data-city-input-id="input-shipping-city-select"
                                        data-other-field-wrapper-class="shipping-other-field-wrapper"
                                        data-other-country-class="shipping-other-country"
                                        data-country-select-class="shipping-country-select"></i>
                                </div>
                                <select name="shipping_country_id" 
                                        id="input-shipping-country-select" 
                                        data-state-id="{{ old('shipping_state_id') ? old('shipping_state_id') : (isset($shipping_details->state_id) ? $shipping_details->state_id : 0) }}"  
                                        data-district-id="{{ old('shipping_district_id') ? old('shipping_district_id') : (isset($shipping_details->district_id) ? $shipping_details->district_id : 0) }}"
                                        data-city-id="{{ old('shipping_city_id') ? old('shipping_city_id') : (isset($shipping_details->city_id) ? $shipping_details->city_id : 0) }}"
                                        data-state-input-id="input-shipping-state-select" 
                                        data-district-input-id="input-shipping-district-select" 
                                        data-city-input-id="input-shipping-city-select"
                                        data-other-field-wrapper-class="shipping-other-field-wrapper"
                                        data-other-country-class="shipping-other-country"
                                        data-country-select-class="shipping-country-select" 
                                        class="w-100 py-1 form-control shipping-address-status req-not-req country-select shipping-country-select" 
                                        required>
                                    <option selected disabled>Select Country</option>
                                    @php
                                        $tempCountry = old('shipping_country_id') ? old('shipping_country_id') : (isset($shipping_details->country_id) ? $shipping_details->country_id : '');
                                    @endphp

                                    @foreach($countries as $country)
                                        <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                    <option {{ $tempCountry == 0 ? 'selected' : '' }} value="0">Other</option>
                                </select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-state-select">State*</label>
                                <div class="shipping-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-shipping-state-name" type="text" name="shipping_state_name" class="form-control shipping-other-country" placeholder="Enter State Name" value="{{ old('shipping_state_name') ? old('state_name') : (isset($shipping_details->state_name) ? $shipping_details->state_name : '') }}">
                                </div>
                                <select name="shipping_state_id" 
                                        id="input-shipping-state-select" 
                                        data-district-id="{{ old('shipping_district_id') ? old('shipping_district_id') : (isset($shipping_details->district_id) ? $shipping_details->district_id : 0) }}" 
                                        data-city-id="{{ old('shipping_city_id') ? old('shipping_city_id') : (isset($shipping_details->city_id) ? $shipping_details->city_id : 0) }}"
                                        data-district-input-id="input-shipping-district-select" 
                                        data-city-input-id="input-shipping-city-select" 
                                        class="w-100 py-1 form-control shipping-address-status req-not-req state-select shipping-country-select" 
                                        required>
                                    <option selected disabled>Select Country First</option>
                                </select>
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-district-select">District*</label>
                                <div class="shipping-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-shipping-district-name" type="text" name="shipping_district_name" class="form-control shipping-other-country" placeholder="Enter District Name" value="{{ old('shipping_district_name') ? old('district_name') : (isset($shipping_details->district_name) ? $shipping_details->district_name : '') }}">
                                </div>
                                <select name="shipping_district_id" 
                                        id="input-shipping-district-select" 
                                        data-city-id="{{ old('shipping_city_id') ? old('shipping_city_id') : (isset($shipping_details->city_id) ? $shipping_details->city_id : 0) }}" 
                                        data-city-input-id="input-shipping-city-select" 
                                        data-pin-code-id="input-shipping-pin-code"
                                        class="w-100 py-1 form-control shipping-address-status req-not-req district-select shipping-country-select" 
                                        required>
                                    <option selected disabled>Select State First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-city-select">City*</label>
                                <div class="shipping-other-field-wrapper" style="position:relative; display: none;">
                                    <input id="input-shipping-city-name" type="text" name="shipping_city_name" class="form-control shipping-other-country" placeholder="Enter City Name" value="{{ old('shipping_city_name') ? old('shipping_city_name') : (isset($shipping_details->city_name) ? $shipping_details->city_name : '') }}">
                                </div>
                                <select name="shipping_city_id" id="input-shipping-city-select" data-pin-code-id="input-shipping-pin-code" class="w-100 py-1 form-control shipping-address-status req-not-req city-select shipping-country-select" required>
                                    <option selected disabled>Select District First</option>
                                </select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-pin-code">Pin Code</label>
                                <input type="text" name="shipping_pin_code" value="{{ old('shipping_pin_code') ? old('shipping_pin_code') : (isset($shipping_details->pin_code) ? $shipping_details->pin_code : '') }}" placeholder="Eg: +977" id="input-shipping-pin-code" class="form-control shipping-address-status">
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-street-address-1">Street Address 1*</label>
                                <input type="text" name="shipping_street_address_1" value="{{ old('shipping_street_address_1') ? old('shipping_street_address_1') : (isset($shipping_details->street_address_1) ? $shipping_details->street_address_1 : '') }}" placeholder="Eg: 23 burrow street" id="input-shipping-street-address-1" class="form-control shipping-address-status req-not-req" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-shipping-street-address-2">Street Address 2</label>
                                <input type="text" name="shipping_street_address_2" value="{{ old('shipping_street_address_2') ? old('shipping_street_address_2') : (isset($shipping_details->street_address_2) ? $shipping_details->street_address_2 : '') }}" placeholder="Eg: 23 burrow street" id="input-shipping-street-address-2" class="form-control shipping-address-status">
                            </div>
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
                                <div class="col-6">
                                    <p><strong>Nrs. {{ $cart_total_price }}</strong></p>
                                </div>

                                <div class="col-6">
                                    <p>Offer</p>
                                </div>
                                <div class="col-6">
                                    @php
                                        $cart_total_price = $cart_total_price - $cart_total_offer_price;
                                        session()->put("total_price", $cart_total_price);
                                        session()->save();
                                    @endphp
                                    <p><strong>- Nrs. {{ $cart_total_offer_price }}</strong></p>
                                </div>


                                <div class="col-6 coupon-details" style="display: {{ isset($coupon_details['title']) ? '' : 'none' }}">
                                    <p id="couponTitle">{{ isset($coupon_details['title']) ? $coupon_details['title'] : '' }}</p>
                                </div>
                                <div class="col-6 coupon-details" style="display: {{ isset($coupon_details['title']) ? '' : 'none' }}">
                                    <p><strong>- Nrs. <span id="discountAmount">{{ isset($coupon_details['discount_amount']) ? $coupon_details['discount_amount'] : 0 }}</span></strong></p>
                                    <input type="hidden" id="discountAmount" value="{{ isset($coupon_details['discount_amount']) ? $coupon_details['discount_amount'] : 0 }}">
                                </div>
                                {{-- <div class="col-6">
                                    <p>Total Weight</p>
                                </div> --}}
                                <input type="hidden" id="totalWeight" value="{{ $cart_total_weight }}">
                                {{-- <div class="col-6">
                                    <p><strong>{{ $cart_total_weight }}Kg</strong></p>
                                </div> --}}
                                <div class="col-6">
                                    <p>Shipping Cost</p>
                                </div>
                                <div class="col-6">
                                    <input type="hidden" id="totalShippingCost" value="0">
                                    <p>+ <strong>Nrs. <span id="shippingCost">0</span><small>({{ $cart_total_weight }} Kg)</small></strong></p>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <p>Grand Total</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Nrs. <span id="totalPrice">{{ $cart_total_price }}</span></strong></p>
                                </div>
                                <div class="col-12">
                                    <input id="couponCode" class="input-text"  placeholder="Coupon code" type="text">
                                    <input id="applyCoupon" class="main-button colored"  value="Apply coupon" type="button">
                                </div>
                            </div>
                        </div>
                        <div class="checkout-left">
                            <h6>Payment Options</h6>
                            <hr>
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
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="esewa" value="2" disabled>
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
                                    <input type="radio" name="payment_method" id="fone" value="3" disabled>
                                    <label for="fone">Fone Pay <small>(coming soon)</small></label>
                                </div>
                                <div class="fone-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="card" value="4" disabled="">
                                    <label for="card">Pay Using Credit Card <small>(coming soon)</small></label>
                                </div>
                                <div class="card-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            <hr>
                            <button id="placeOrder" type="submit" class="main-button colored">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('post-scripts')
	<script>

        if ($('#ship-box').is(':checked')){

            $("#ship-box-info").slideUp();
            $('.shipping-address-status').attr('disabled',true);
            $('.req-not-req').attr('required',false);
        }else {

            $("#ship-box-info").slideDown();
            $('.shipping-address-status').attr('disabled',false);
            $('.req-not-req').attr('required',true);
            

        }


        $('#ship-box').click(function () {
            $("#ship-box-info").slideToggle();

            if (!this.checked) {
                $("#ship-box-info").slideDown();
                $('.shipping-address-status').attr('disabled',false);
                $('.req-not-req').attr('required',true);

                @guest

                    $('#input-shipping-name').val('{{ old('billing_name') }}');
                    $('#input-shipping-phone').val('{{ old('billing_phone') }}');
                    $('#input-shipping-phone2').val('{{ old('billing_phone2') }}');
                    $('#input-shipping-email').val('{{ old('billing_email') }}');
                    $('#input-shipping-country-name').val('{{ old('billing_country_name') }}');
                    $('#input-shipping-country-select').val('{{ old('billing_country_id') }}');
                    $('#input-shipping-state-name').val('{{ old('billing_state_name') }}');
                    $('#input-shipping-state-select').val('{{ old('billing_state_id') }}');
                    $('#input-shipping-district-name').val('{{ old('billing_district_name') }}');
                    $('#input-shipping-district-select').val('{{ old('billing_district_id') }}');
                    $('#input-shipping-city-name').val('{{ old('billing_city_name') }}');
                    $('#input-shipping-city-select').val('{{ old('billing_city_id') }}');
                    $('#input-shipping-pin-code').val('{{ old('billing_pin_code') }}');
                    $('#input-shipping-street-address-1').val('{{ old('billing_street_address_1') }}');
                    $('#input-shipping-street-address-2').val('{{ old('billing_street_address_2') }}');

                    
                @else

                    $('#input-shipping-name').val('{{ old('name') ? old('name' ) : (isset($shipping_details) ? $shipping_details->name : '') }}');
                    $('#input-shipping-phone').val('{{ old('phone') ? old('phone' ) : (isset($shipping_details) ? $shipping_details->phone : '') }}');
                    $('#input-shipping-phone2').val('{{ old('phone2') ? old('phone2' ) : (isset($shipping_details) ? $shipping_details->phone2 : '') }}');
                    $('#input-shipping-email').val('{{ old('email') ? old('email' ) : (isset($shipping_details) ? $shipping_details->email : '') }}');
                    $('#input-shipping-country-name').val('{{ old('country_name') ? old('country_name' ) : (isset($shipping_details) ? $shipping_details->country_name : '') }}');
                    $('#input-shipping-country-select').val('{{ old('country_id') ? old('country_id' ) : (isset($shipping_details) ? $shipping_details->country_id : '') }}');
                    $('#input-shipping-state-name').val('{{ old('state_name') ? old('state_name' ) : (isset($shipping_details) ? $shipping_details->state_name : '') }}');
                    $('#input-shipping-state-select').val('{{ old('state_id') ? old('state_id' ) : (isset($shipping_details) ? $shipping_details->state_id : '') }}');
                    $('#input-shipping-district-name').val('{{ old('district_name') ? old('district_name' ) : (isset($shipping_details) ? $shipping_details->district_name : '') }}');
                    $('#input-shipping-district-select').val('{{ old('district_id') ? old('district_id' ) : (isset($shipping_details) ? $shipping_details->district_id : '') }}');
                    $('#input-shipping-city-name').val('{{ old('city_name') ? old('city_name' ) : (isset($shipping_details) ? $shipping_details->city_name : '') }}');
                    $('#input-shipping-city-select').val('{{ old('city_id') ? old('city_id' ) : (isset($shipping_details) ? $shipping_details->city_id : '') }}');
                    $('#input-shipping-pin-code').val('{{ old('pin_code') ? old('pin_code' ) : (isset($shipping_details) ? $shipping_details->pin_code : '') }}');
                    $('#input-shipping-street-address-1').val('{{ old('street_address_1') ? old('street_address_1' ) : (isset($shipping_details) ? $shipping_details->street_address_1 : '') }}');
                    $('#input-shipping-street-address-2').val('{{ old('street_address_2') ? old('street_address_2' ) : (isset($shipping_details) ? $shipping_details->street_address_2 : '') }}');


                    var other_field_wrapper_class = 'shipping-other-field-wrapper';
                    var other_country_class = 'shipping-other-country';
                    var country_select_class = 'shipping-country-select';

                    if ($('#input-shipping-country-select').val() != null) {

                        if ($('#input-shipping-country-select').val() != 0) {


                            get_states('{{ old('country_id') ? old('country_id' ) : (isset($shipping_details) ? $shipping_details->country_id : 0) }}', 
                                       '{{ old('state_id') ? old('state_id' ) : (isset($shipping_details) ? $shipping_details->state_id : 0) }}', 
                                       '{{ old('district_id') ? old('district_id' ) : (isset($shipping_details) ? $shipping_details->district_id : 0) }}', 
                                       '{{ old('city_id') ? old('city_id' ) : (isset($shipping_details) ? $shipping_details->city_id : 0) }}', 
                                       'input-shipping-state-select', 
                                       'input-shipping-district-select', 
                                       'input-shipping-city-select'
                                    );
                            $("."+country_select_class).show();
                            $("."+country_select_class).attr('required', true);

                            $("."+other_field_wrapper_class).hide();
                            $("."+other_country_class).attr('required', false);
                            $("."+other_country_class).attr('disabled', true);

                        }else{
                            $("#totalShippingCost").val(0);
                            $("#shippingCost").html('Extra');
                            $("."+country_select_class).hide();
                            $("."+country_select_class).attr('required', false);

                            $("."+other_field_wrapper_class).show();
                            $("."+other_country_class).attr('required', true);
                            $("."+other_country_class).attr('disabled', false);
                        }

                    }else{

                        $("."+country_select_class).show();
                        $("."+country_select_class).attr('required', true);

                        $("."+other_field_wrapper_class).hide();
                        $("."+other_country_class).attr('required', false);
                        $("."+other_country_class).attr('disabled', true);

                        $("#cashOnDelivery").hide();
                        $("#cash-input").attr('disabled',true);
                    }
                @endguest

                if($('#input-shipping-country-select').val() == '' || $('#input-shipping-country-select').val() == null){
                    $("#input-shipping-country-select").val($("#input-shipping-country-select option:first").val());
                }

            } else {
                $("#ship-box-info").slideUp();
                $('.shipping-address-status').attr('disabled',true);
                $('.req-not-req').attr('required',false);

                // alert($('#cust_region').val());
                $('#input-shipping-name').val($('#input-billing-name').val());
                $('#input-shipping-phone').val($('#input-billing-phone').val());
                $('#input-shipping-phone2').val($('#input-billing-phone2').val());
                $('#input-shipping-email').val($('#input-billing-email').val());
                $('#input-shipping-country-name').val($('#input-billing-country-name').val());
                $('#input-shipping-country-select').val($('#input-billing-country-select').val());
                $('#input-shipping-state-name').val($('#input-billing-state-name').val());
                $('#input-shipping-state-select').val($('#input-billing-state-select').val());
                $('#input-shipping-district-name').val($('#input-billing-district-name').val());
                $('#input-shipping-district-select').val($('#input-billing-district-select').val());
                $('#input-shipping-city-name').val($('#input-billing-city-name').val());
                $('#input-shipping-city-select').val($('#input-billing-city-select').val());
                $('#input-shipping-pin-code').val($('#input-billing-pin-code').val());
                $('#input-shipping-street-address-1').val($('#input-billing-street-address-1').val());
                $('#input-shipping-street-address-2').val($('#input-billing-street-address-2').val());

                var other_field_wrapper_class = 'shipping-other-field-wrapper';
                var other_country_class = 'shipping-other-country';
                var country_select_class = 'shipping-country-select';

                if ($('#input-shipping-country-select').val() != null) {

                    if ($('#input-shipping-country-select').val() != 0) {


                        get_states($('#input-billing-country-select').val(), 
                                   $('#input-billing-state-select').val(), 
                                   $('#input-billing-district-select').val(), 
                                   $('#input-billing-city-select').val(), 
                                   'input-shipping-state-select', 
                                   'input-shipping-district-select', 
                                   'input-shipping-city-select'
                                );

                        
                        $("."+country_select_class).show();
                        $("."+country_select_class).attr('required', true);

                        $("."+other_field_wrapper_class).hide();
                        $("."+other_country_class).attr('required', false);
                        $("."+other_country_class).attr('disabled', true);

                    }else{
                        $("#totalShippingCost").val(0);
                        $("#shippingCost").html('Extra');
                        $("."+country_select_class).hide();
                        $("."+country_select_class).attr('required', false);

                        $("."+other_field_wrapper_class).show();
                        $("."+other_country_class).attr('required', true);
                        $("."+other_country_class).attr('disabled', false);
                    }

                }else{

                    $("."+country_select_class).show();
                    $("."+country_select_class).attr('required', true);

                    $("."+other_field_wrapper_class).hide();
                    $("."+other_country_class).attr('required', false);
                    $("."+other_country_class).attr('disabled', true);

                    $("#cashOnDelivery").hide();
                    $("#cash-input").attr('disabled',true);
                }
                // $('#input-shipping-state').val($('#input-billing-state').val());                
                
            }
        });

        $(".country-select").each(function(){

            var other_field_wrapper_class = $(this).data('other-field-wrapper-class');
            var other_country_class = $(this).data('other-country-class');
            var country_select_class = $(this).data('country-select-class');

            if ($(this).val() != null) {

                if ($(this).val() != 0) {

                    $("."+country_select_class).show();
                    $("."+country_select_class).attr('required', true);

                    $("."+other_field_wrapper_class).hide();
                    $("."+other_country_class).attr('required', false);
                    $("."+other_country_class).attr('disabled', true);

                    get_states($(this).val(), $(this).data('state-id'), $(this).data('district-id'), $(this).data('city-id'), $(this).data('state-input-id'), $(this).data('district-input-id'), $(this).data('city-input-id'));

                    $(".state-select").each(function(){

                        if ($(this).val() != null && $(this).val() != 0) {

                            get_districts($(this).val(), $(this).data('district-id'), $(this).data('city-id'), $(this).data('district-input-id'), $(this).data('city-input-id'));

                            $(".district-select").each(function(){

                                if ($(this).val() != null && $(this).val() != 0) {
                                    get_cities($(this).val(), $(this).data('city-id'), $(this).data('city-input-id'));
                                }
                            });
                        }
                    });

                }else{
                    $("#totalShippingCost").val(0);
                    $("#shippingCost").html('Extra');
                    $("."+country_select_class).hide();
                    $("."+country_select_class).attr('required', false);

                    $("."+other_field_wrapper_class).show();
                    $("."+other_country_class).attr('required', true);
                    $("."+other_country_class).attr('disabled', false);

                }
            }else{

                $("."+country_select_class).show();
                $("."+country_select_class).attr('required', true);

                $("."+other_field_wrapper_class).hide();
                $("."+other_country_class).attr('required', false);
                $("."+other_country_class).attr('disabled', true);
            }
        });

        $(".country-select").change(function(){

            var other_field_wrapper_class = $(this).data('other-field-wrapper-class');
            var other_country_class = $(this).data('other-country-class');
            var country_select_class = $(this).data('country-select-class');

            if ($(this).val() != 0) {
                
                var country_id = $(this).val();
                var state_id = $(this).data('state-id');
                var district_id = $(this).data('district-id');
                var city_id = $(this).data('city-id');
                var state_input_id =  $(this).data('state-input-id');
                var district_input_id =  $(this).data('district-input-id');
                var city_input_id =  $(this).data('city-input-id');

                get_states(country_id, state_id, district_id, city_id, state_input_id, district_input_id, city_input_id);

                $("."+country_select_class).show();
                $("."+country_select_class).attr('required', true);

                $("."+other_field_wrapper_class).hide();
                $("."+other_country_class).attr('required', false);
                $("."+other_country_class).attr('disabled', true);

            }else{
                $("#totalShippingCost").val(0);
                $("#shippingCost").html('Extra');
                $("."+country_select_class).hide();
                $("."+country_select_class).attr('required', false);

                $("."+other_field_wrapper_class).show();
                $("."+other_country_class).attr('required', true);
                $("."+other_country_class).attr('disabled', false);
            }

        });

        function get_states(country_id, state_id = 0, district_id = 0, city_id = 0, state_input_id, district_input_id, city_input_id) {
            $.ajax({
                url: "{{ route('get-states') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    country_id: country_id,
                    state_id: state_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#'+state_input_id).html(response); 

                    if ($("#"+state_input_id).val() != null) {
                        get_districts($("#"+state_input_id).val(), district_id, city_id, district_input_id, city_input_id);
                    }else{
                        $("#"+district_input_id).html('<option selected disabled>Select State First</option>');
                        $("#"+city_input_id).html('<option selected disabled>Select District First</option>');
                    }

                    
                }
            });
        }

        $(".state-select").change(function(){
            var state_id = $(this).val();
            var district_id = $(this).data('district-id');
            var city_id = $(this).data('city-id');
            var district_input_id = $(this).data('district-input-id');
            var city_input_id = $(this).data('city-input-id');
            get_districts(state_id, district_id, city_id, district_input_id, city_input_id);
        });

        function get_districts(state_id, district_id = 0, city_id = 0, district_input_id, city_input_id) {
            $.ajax({
                url: "{{ route('get-districts') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    state_id: state_id,
                    district_id: district_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    $('#'+district_input_id).html(response); 

                    if ($("#"+district_input_id).val() != null) {
                        get_cities($("#"+district_input_id).val(), city_id, city_input_id);
                    }else{

                        $("#"+city_input_id).html('<option selected disabled>Select District First</option>');
                    }
                }
            });
        }

        $(".district-select").change(function(){
            var district_id = $(this).val();
            var city_id = $(this).data('city-id');
            var city_input_id = $(this).data('city-input-id');
            get_cities(district_id, city_id, city_input_id);
        });

        function get_cities(district_id, city_id = 0, city_input_id) {
            var cart_total_weight = $("#totalWeight").val();
            $.ajax({
                url: "{{ route('get-cities-checkout') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    district_id: district_id,
                    city_id: city_id,
                    total_weight: cart_total_weight
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();

                    var obj = jQuery.parseJSON( response);
                    
                    $('#'+city_input_id).html(obj.responseText); 

                    $("#totalShippingCost").val(obj.shipping_cost);
                    $("#shippingCost").html(obj.shipping_cost);
                    $("#totalPrice").html(obj.total_price);


                    check_cod_availability($("#input-shipping-city-select").val());
                }
            });
        }

        $("#input-shipping-city-select").change(function(){

            var shipping_city_id = $(this).val();
            check_cod_availability(shipping_city_id);

        });

        // if ($("#input-shipping-city-select").val() == null) {
            
        //     alert($("#input-shipping-city-select").val());

            
        // }

        function check_cod_availability(shipping_city_id) {
            $.ajax({
                url: "{{ route('check-cod-availability') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    city_id: shipping_city_id
                },
                cache : false,
                beforeSend : function(){
                    $('#modal-loader').show();
                },
                success: function(response){
                    $('#modal-loader').hide();
                    
                    if (response == 'available') {
                        $("#cashOnDelivery").show();
                        $("#cash-input").attr('disabled',false);
                    }else{
                        $("#cashOnDelivery").hide();
                        $("#cash-input").attr('disabled',true);
                    }

                    
                }
            });
        }

        $(".show-country-select").click(function(){
            show_country_select(this);
        });

        function show_country_select(that){


            var country_id = $(that).data('country-id');
            var state_id = $(that).data('state-id');
            var district_id = $(that).data('district-id');
            var city_id = $(that).data('city-id');
            var country_input_id =  $(that).data('country-input-id');
            var state_input_id =  $(that).data('state-input-id');
            var district_input_id =  $(that).data('district-input-id');
            var city_input_id =  $(that).data('city-input-id');

            get_states(country_id, state_id, district_id, city_id, state_input_id, district_input_id, city_input_id);
                $("#"+country_input_id).val(country_id);

            var other_field_wrapper_class = $(that).data('other-field-wrapper-class');
            var other_country_class = $(that).data('other-country-class');
            var country_select_class = $(that).data('country-select-class');

            $("."+country_select_class).show();
            $("."+country_select_class).attr('required', true);

            $("."+other_field_wrapper_class).hide();
            $("."+other_country_class).attr('required', false);
            $("."+other_country_class).attr('disabled', true);

            if(country_id == ''){
                $("#"+country_input_id).val($("#"+country_input_id+" option:first").val());
            }
        };

        $('#applyCoupon').click(function (e) {
            e.preventDefault();

            if ($("#couponCode").val() == '') {
                toastr['error']('Please enter valid Coupon Code!');
                return;
            }

            $.ajax({
                url : "{{ URL::route('customer.apply-coupon') }}",
                type: "POST",
                data: {
                        '_token' : '{{ csrf_token() }}',
                        code : $("#couponCode").val(),
                        shipping_cost : $("#totalShippingCost").val(),
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
                        
                    }else if(obj.status == 'invalid_date'){

                        toastr['error']('Coupon is already expired!');
                    }else if(obj.status == 'invalid_code'){
                        
                        toastr['error']('Invalid Coupon Code');
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