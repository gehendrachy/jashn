@extends('backend.layouts.app')
@section('title', 'Create Order')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .wrapper .page-wrap .main-content .page-header .page-header-title i {
            width: 50px !important;
            height: 50px !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-image bg-blue"></i>
                        <div class="d-inline">
                            <h5>Create</h5>
                            <span>Create Order</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create Order</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.orders.store') }}">
                    @csrf
                    <div class="card border border-secondary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border border-default card-solid">

                                        <div class="card-header with-border justify-content-between">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="input-group mb-1">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text" style="min-width: 170px;">
                                                                <i class="ik ik-shopping-bag"></i>&nbsp;  Ordered Date 
                                                            </label>
                                                        </span>
                                                        <span class="input-group-append">
                                                            <span class="input-group-text" style="min-width: 208px; background-color: #fff;">
                                                                
                                                                {{ date('jS F Y') }}
                                                            </span>
                                                        </span>
                                                    </div>

                                                    <div class="input-group mb-1">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text" style="min-width: 170px;">
                                                                <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Mode 
                                                            </label>
                                                        </span>
                                                        <select name="payment_method" class="form-control payment-select" id="paymentMode" data-type="payment-mode">

                                                            @for($i=1; $i<count($payment_method); $i++)
                                                                <option value="{{ $i }}">{{ $payment_method[$i] }}</option>
                                                            @endfor

                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-1">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text" style="min-width: 170px;">
                                                                <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Status 
                                                            </label>
                                                        </span>
                                                        <select name="payment_status" class="form-control payment-select" id="paymentStatus" data-type="payment-status">
                                                            <option value="0">Payment Pending</option>
                                                            <option value="1">Payment Received</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table header-border table-hover" id="orderTable">
                                                    <thead>
                                                        <tr>
                                                            <th><strong> Product</strong></th>
                                                            <th><strong>Qty</strong></th>
                                                            <th class="text-right"><strong>MRP</strong></th>
                                                            <th class="text-right"><strong>Total</strong></th>
                                                            <th class="text-right">Remove</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productItems">
                                                        <tr class="product-items" id="product-item-1" data-cumulative-count="1">
                                                            <td>
                                                                <div class="input-group mb-1">
                                                                    <select name="product[1][product_size_id]" class="form-control product-size-select select2" onchange="call_product_function(this)" data-key="1" required>
                                                                        <option selected disabled>Select Product</option>
                                                                        @foreach($product_sizes as $key => $product_size)
                                                                            @php
                                                                                $max_order_qty = $product_size->quantity > 0 ? $product_size->quantity : $product_size->preorder_stock_limit;
                                                                            @endphp

                                                                            <option value="{{ $product_size->id }}" 
                                                                                data-product-id="{{ $product_size->product_color->product->id }}"
                                                                                data-product-color-id="{{ $product_size->product_color->id }}"
                                                                                data-preorder-status="{{ $product_size->quantity > 0 ? 0 : $product_size->preorder }}"
                                                                                data-stock-count="{{ $max_order_qty }}"
                                                                                data-final-price="{{ $product_size->final_price }}"
                                                                                >

                                                                                {{ $product_size->product_color->product->title }} 
                                                                                
                                                                                <b>
                                                                                    ( {{ $product_size->size->name }}, 
                                                                                    {{ $product_size->product_color->color->title }} )
                                                                                </b>
                                                                                - [ {{ $product_size->sku }} ]
                                                                            </option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="input-group mb-1">
                                                                    <input id="ordered-qty-1" class="form-control" type="number" name="product[1][ordered_qty]" value="1" min="1" max="" onchange="calculate_total_price(this)" data-key="1" required>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <span id="product-item-price-1">0</span>
                                                            </td>

                                                            <td>
                                                                <span class="sub-total-price" id="product-total-price-1">0</span>
                                                            </td>
                                                            <td>
                                                                {{-- <button type="button" class="btn btn-danger btn-sm remove-product-button" onclick="removeProduct(this)" data-index="1"><i class="fa fa-trash mr-0"></i></button> --}}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-right"><strong>Total Price</strong></td>
                                                            <td><span id="totalPrice">0</span></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-warning" onclick="addProduct()"><i class="fa fa-plus"></i> Add Product</button>
                                                    {{-- <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-default card-solid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <hr>
                                    <h6><strong>Shipping Address</strong></h6>
                                    <hr>
                                    <div class="row" id="ship-box-info" style="display: inline-flex;">
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-name">Name*</label>
                                            <input type="text" name="shipping_name" placeholder="Name" id="input-shipping-name" class="form-control shipping-address-status" value="{{ old('shipping_name') ? old('shipping_name') : (isset($shipping_details->name) ? $shipping_details->name : '') }}" required>
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-pan">Pan </label>
                                            <input type="text" name="shipping_pan" placeholder="Eg: 88766676" id="input-shipping-pan" class="form-control shipping-address-status" value="{{ old('shipping_pan') ? old('shipping_pan') : (isset($shipping_details->pan) ? $shipping_details->pan : '') }}">
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-phone">Phone Number(Primary)*</label>
                                            <input type="text" name="shipping_phone" placeholder="+977-123456789" id="input-shipping-phone" class="form-control shipping-address-status" value="{{ old('shipping_phone') ? old('shipping_phone') : (isset($shipping_details->phone) ? $shipping_details->phone : '') }}" required >
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-phone2">Phone Number 2</label>
                                            <input type="text" name="shipping_phone2" placeholder="+977-123456789" id="input-shipping-phone2" class="form-control shipping-address-status" value="{{ old('shipping_phone2') ? old('shipping_phone2') : (isset($shipping_details->phone2) ? $shipping_details->phone2 : '') }}" >
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-email">E-Mail</label>
                                            <input type="email" name="shipping_email" placeholder="E-Mail" id="input-shipping-email" class="form-control shipping-address-status" value="{{ old('shipping_email') ? old('shipping_email') : (isset($shipping_details->email) ? $shipping_details->email : '') }}">
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
                                                    class="w-100 py-1 form-control shipping-address-status country-select shipping-country-select" 
                                                    required>
                                                <option selected disabled>Select Country</option>
                                                @php
                                                    $tempCountry = old('shipping_country_id') ? old('shipping_country_id') : (isset($shipping_details->country_id) ? $shipping_details->country_id : '');
                                                @endphp

                                                @foreach($countries as $country)
                                                    <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                                {{-- <option {{ $tempCountry == 0 ? 'selected' : '' }} value="0">Other</option> --}}
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
                                                    class="w-100 py-1 form-control shipping-address-status state-select shipping-country-select" 
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
                                                    class="w-100 py-1 form-control shipping-address-status district-select shipping-country-select" 
                                                    required>
                                                <option selected disabled>Select State First</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-city-select">City*</label>
                                            <div class="shipping-other-field-wrapper" style="position:relative; display: none;">
                                                <input id="input-shipping-city-name" type="text" name="shipping_city_name" class="form-control shipping-other-country" placeholder="Enter City Name" value="{{ old('shipping_city_name') ? old('shipping_city_name') : (isset($shipping_details->city_name) ? $shipping_details->city_name : '') }}">
                                            </div>
                                            <select name="shipping_city_id" id="input-shipping-city-select" data-pin-code-id="input-shipping-pin-code" class="w-100 py-1 form-control shipping-address-status city-select shipping-country-select" required>
                                                <option selected disabled>Select District First</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-pin-code">Pin Code</label>
                                            <input type="text" name="shipping_pin_code" value="{{ old('shipping_pin_code') ? old('shipping_pin_code') : (isset($shipping_details->pin_code) ? $shipping_details->pin_code : '') }}" placeholder="Eg: +977" id="input-shipping-pin-code" class="form-control shipping-address-status">
                                        </div>
                                        
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-street-address-1">Street Address 1*</label>
                                            <input type="text" name="shipping_street_address_1" value="{{ old('shipping_street_address_1') ? old('shipping_street_address_1') : (isset($shipping_details->street_address_1) ? $shipping_details->street_address_1 : '') }}" placeholder="Eg: 23 burrow street" id="input-shipping-street-address-1" class="form-control shipping-address-status" required>
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-shipping-street-address-2">Street Address 2</label>
                                            <input type="text" name="shipping_street_address_2" value="{{ old('shipping_street_address_2') ? old('shipping_street_address_2') : (isset($shipping_details->street_address_2) ? $shipping_details->street_address_2 : '') }}" placeholder="Eg: 23 burrow street" id="input-shipping-street-address-2" class="form-control shipping-address-status">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">    
                                    <div class="row" style="padding-left: 30px;">
                                        
                                         <label for="ship-box">Billing Address Same as Shipping</label>
                                         
                                         <input class="form-check-input" type="checkbox" value="" id="ship-box">
                                        
                                    </div>
                                
                                    <h6><strong>Billing Address</strong></h6>
                                    <hr>
                                    <div class="row" id="billing-box-info">
                                   
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-name">Name*</label>
                                            <input type="text" name="billing_name" placeholder="Name" id="input-billing-name" class="form-control billing-address-status req-not-req" value="{{ old('billing_name') ? old('billing_name') : (isset($billing_details->name) ? $billing_details->name : '') }}" required>
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-pan">Pan </label>
                                            <input type="text" name="billing_pan" placeholder="Eg: 88766676" class="form-control billing-address-status" id="input-billing-pan" value="{{ old('billing_pan') ? old('billing_pan') : (isset($billing_details->pan) ? $billing_details->pan : '') }}">
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-phone">Phone Number(Primary)*</label>
                                            <input type="text" name="billing_phone" placeholder="+977-123456789" id="input-billing-phone" class="form-control billing-address-status req-not-req" value="{{ old('billing_phone') ? old('billing_phone') : (isset($billing_details->phone) ? $billing_details->phone : '') }}" required >
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-phone2">Phone Number 2</label>
                                            <input type="text" name="billing_phone2" placeholder="+977-123456789" id="input-billing-phone2" class="form-control billing-address-status" value="{{ old('billing_phone2') ? old('billing_phone2') : (isset($billing_details->phone2) ? $billing_details->phone2 : '') }}" >
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-email">E-Mail</label>
                                            <input type="email" name="billing_email" placeholder="E-Mail" id="input-billing-email" class="form-control billing-address-status" value="{{ old('billing_email') ? old('billing_email') : (isset($billing_details->email) ? $billing_details->email : '') }}">
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label for="input-billing-country-select">Country*</label>
                                            <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                                <input id="input-billing-country-name" type="text" name="billing_country_name" class="form-control billing-other-country billing-address-status req-not-req" placeholder="Enter Country Name" value="{{ old('billing_country_name') ? old('billing_country_name') : (isset($billing_details->country_name) ? $billing_details->country_name : '') }}">
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
                                                    class="w-100 py-1 form-control country-select billing-country-select billing-address-status" required>
                                                <option selected disabled>Select Country</option>
                                                @php
                                                    $tempCountry = old('billing_country_id') ? old('billing_country_id') : (isset($billing_details->country_id) ? $billing_details->country_id : '');
                                                @endphp

                                                @foreach($countries as $country)
                                                    <option <?=$tempCountry == $country->id ? 'selected' : '' ?> value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                                {{-- <option {{ $tempCountry == 0 ? 'selected' : '' }} value="0">Other</option> --}}
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
                                                    class="w-100 py-1 form-control state-select billing-country-select billing-address-status req-not-req" 
                                                    required>
                                                <option selected disabled>Select Country First</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-district-select">District*</label>
                                            <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                                <input id="input-billing-district-name" type="text" name="billing_district_name" class="form-control billing-other-country billing-address-status" placeholder="Enter District Name" value="{{ old('billing_district_name') ? old('district_name') : (isset($billing_details->district_name) ? $billing_details->district_name : '') }}">
                                            </div>
                                            <select name="billing_district_id" 
                                                    id="input-billing-district-select" 
                                                    data-city-id="{{ old('billing_city_id') ? old('billing_city_id') : (isset($billing_details->city_id) ? $billing_details->city_id : 0) }}" 
                                                    data-city-input-id="input-billing-city-select" 
                                                    data-pin-code-id="input-billing-pin-code" 
                                                    class="w-100 py-1 form-control district-select billing-country-select billing-address-status req-not-req" 
                                                    required>
                                                <option selected disabled>Select State First</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-city-select">City*</label>
                                            <div class="billing-other-field-wrapper" style="position:relative; display: none;">
                                                <input id="input-billing-city-name" type="text" name="billing_city_name" class="form-control billing-other-country" placeholder="Enter City Name" value="{{ old('billing_city_name') ? old('billing_city_name') : (isset($billing_details->city_name) ? $billing_details->city_name : '') }}">
                                            </div>
                                            <select name="billing_city_id" id="input-billing-city-select" data-pin-code-id="input-billing-pin-code" class="w-100 py-1 form-control city-select billing-country-select billing-address-status req-not-req" required>
                                                <option selected disabled>Select District First</option>
                                            </select>
                                        </div>

                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-pin-code">Pin Code</label>
                                            <input type="text" name="billing_pin_code" value="{{ old('billing_pin_code') ? old('billing_pin_code') : (isset($billing_details->pin_code) ? $billing_details->pin_code : '') }}" id="input-billing-pin-code" placeholder="Eg: +977" class="form-control billing-address-status">
                                        </div>
                                        
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-street-address-1">Street Address 1*</label>
                                            <input type="text" name="billing_street_address_1" value="{{ old('billing_street_address_1') ? old('billing_street_address_1') : (isset($billing_details->street_address_1) ? $billing_details->street_address_1 : '') }}" placeholder="Eg: 23 burrow street" id="input-billing-street-address-1" class="form-control billing-address-status req-not-req" required>
                                        </div>
                                        <div class="mb-2 col-sm-6">
                                            <label class="control-label" for="input-billing-street-address-2">Street Address 2</label>
                                            <input type="text" name="billing_street_address_2" value="{{ old('billing_street_address_2') ? old('billing_street_address_2') : (isset($billing_details->street_address_2) ? $billing_details->street_address_2 : '') }}" placeholder="Eg: 23 burrow street" id="input-billing-street-address-2" class="form-control billing-address-status">
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="removeBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Remove Image?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-white">
                    <p>Are you Sure...!!</p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-round btn-default" data-dismiss="modal">Close</button>
                    <a href="" class="btn btn-round btn-primary">Delete</a>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.16.1/ckeditor.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        
        function call_product_function(that) {
            var key = $(that).data('key');
            
            var selected_option = $('option:selected', that);
            var product_size_id = selected_option.val();
            var product_id = selected_option.attr('data-product-id');
            var product_color_id = selected_option.attr('data-product-color-id');
            var preorder_status = selected_option.attr('data-preorder-status');
            var stock_count = selected_option.attr('data-stock-count');
            var final_price = selected_option.attr('data-final-price');

            $("#ordered-qty-"+key).val(1);
            $("#ordered-qty-"+key).attr('max', stock_count);
            $("#product-item-price-"+key).html(final_price);
            $("#product-total-price-"+key).html(final_price);

            var grand_total = 0;

            $(".sub-total-price").each(function(){
                grand_total = grand_total + parseInt($(this).html());
            });

            $("#totalPrice").html(grand_total);

        }

        function calculate_total_price(that) {
            var key = $(that).data('key');
            var qty = $(that).val();
            var item_price = parseInt($("#product-item-price-"+key).html());
            var sub_total = qty * item_price;

            $("#product-total-price-"+key).html(sub_total);

            var grand_total = 0;

            $(".sub-total-price").each(function(){
                grand_total = grand_total + parseInt($(this).html());
            });

            $("#totalPrice").html(grand_total);
        }

    </script>

    <script>
        function remove_banner(id) {
                var conn = '../../banners/delete-banner/' + id;
                $('#removeBanner a').attr("href", conn);
        }
        $('.select2').select2({
            placeholder: 'Select an option'
        });

        function getColor(thisObj){
            var val = $(thisObj).val();
            var index = $(thisObj).data('index');
            $.ajax({
                url : "{{ route('admin.orders.get-color') }}",
                method : 'POST',
                cache : false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    id : val,
                    index : index
                },
                beforeSend : function (){

                },
                complete : function($response, $status){
                    console.log($status);
                    if ($status != "error" && $status != "timeout") {
                        $('#color-'+ index).html($response.responseText);
                    }
                },
                error : function ($responseObj){
                    alert("Something went wrong while processing your request.\n\nError => "
                        + $responseObj.responseText);
                }
            });
        }

        
        function getSizes(thisObj, $color){
            var val = $(thisObj).val();
            var index = $(thisObj).data('index');
            $.ajax({
                url : "{{ route('admin.orders.get-size') }}",
                method : 'POST',
                cache : false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    id : val,
                    color : $color
                },
                beforeSend : function (){

                },
                complete : function($response, $status){
                    console.log($status);
                    if ($status != "error" && $status != "timeout") {
                        $('#size-'+index).html($response.responseText);
                    }
                },
                error : function ($responseObj){
                    alert("Something went wrong while processing your request.\n\nError => "
                        + $responseObj.responseText);
                }
            });
            
        }
    </script>
    <script>
        
        function addProduct(){

                var i = $(".product-items").last().data('cumulative-count');
                i = i == null ? 0 : i;
                i++;

                $.ajax({
                    url : "{{url('admin/orders/new/add-product/')}}/"+i,
                    cache : false,
                    beforeSend : function (){
                        $('#modal-loader').show();
                    },
                    complete : function($response, $status){
                        $('#modal-loader').hide();
                        if ($status != "error" && $status != "timeout") {
                            $('#productItems').append($response.responseText);          

                            $('.select2').select2({
                                placeholder: 'Select an option'
                            });
                        }
                    },
                    error : function ($responseObj){
                        $('#modal-loader').hide();
                        alert("Something went wrong while processing your request.\n\nError => "
                            + $responseObj.responseText);
                    }
                });
        }

        function removeProduct(thisObj){
            var button_id = $(thisObj).data("index");
            $('#product-item-'+button_id).remove();

            var grand_total = 0;

            $(".sub-total-price").each(function(){
                grand_total = grand_total + parseInt($(this).html());
            });

            $("#totalPrice").html(grand_total);
        }
        
    </script>


        <script>
            if ($('#ship-box').is(':checked')){
                // $("#billing-box-info").slideUp();
                $('.billing-address-status').attr('disabled',true);
                $('.req-not-req').attr('required',false);
            }else {
                // $("#billing-box-info").slideDown();
                $('.billing-address-status').attr('disabled',false);
                $('.req-not-req').attr('required',true);
            }

            $('#ship-box').click(function () {
                // $("#billing-box-info").slideToggle();

                if (!this.checked) {
                    // $("#billing-box-info").slideDown();
                    $('.billing-address-status').attr('disabled',false);
                    $('.req-not-req').attr('required',true);

                    @guest
                        $('#input-billing-name').val('{{ old('shipping_name') }}');
                        $('#input-billing-phone').val('{{ old('shipping_phone') }}');
                        $('#input-billing-phone2').val('{{ old('shipping_phone2') }}');
                        $('#input-billing-email').val('{{ old('shipping_email') }}');
                        $('#input-billing-country-name').val('{{ old('shipping_country_name') }}');
                        $('#input-billing-country-select').val('{{ old('shipping_country_id') }}');
                        $('#input-billing-state-name').val('{{ old('shipping_state_name') }}');
                        $('#input-billing-state-select').val('{{ old('shipping_state_id') }}');
                        $('#input-billing-district-name').val('{{ old('shipping_district_name') }}');
                        $('#input-billing-district-select').val('{{ old('shipping_district_id') }}');
                        $('#input-billing-city-name').val('{{ old('shipping_city_name') }}');
                        $('#input-billing-city-select').val('{{ old('shipping_city_id') }}');
                        $('#input-billing-pin-code').val('{{ old('shipping_pin_code') }}');
                        $('#input-billing-street-address-1').val('{{ old('shipping_street_address_1') }}');
                        $('#input-billing-street-address-2').val('{{ old('shipping_street_address_2') }}'); 
                    @else
                        $('#input-billing-name').val('{{ old('name') ? old('name' ) : (isset($billing_details) ? $billing_details->name : '') }}');
                        $('#input-billing-phone').val('{{ old('phone') ? old('phone' ) : (isset($billing_details) ? $billing_details->phone : '') }}');
                        $('#input-billing-phone2').val('{{ old('phone2') ? old('phone2' ) : (isset($billing_details) ? $billing_details->phone2 : '') }}');
                        $('#input-billing-email').val('{{ old('email') ? old('email' ) : (isset($billing_details) ? $billing_details->email : '') }}');
                        $('#input-billing-country-name').val('{{ old('country_name') ? old('country_name' ) : (isset($billing_details) ? $billing_details->country_name : '') }}');
                        $('#input-billing-country-select').val('{{ old('country_id') ? old('country_id' ) : (isset($billing_details) ? $billing_details->country_id : '') }}');
                        $('#input-billing-state-name').val('{{ old('state_name') ? old('state_name' ) : (isset($billing_details) ? $billing_details->state_name : '') }}');
                        $('#input-billing-state-select').val('{{ old('state_id') ? old('state_id' ) : (isset($billing_details) ? $billing_details->state_id : '') }}');
                        $('#input-billing-district-name').val('{{ old('district_name') ? old('district_name' ) : (isset($billing_details) ? $billing_details->district_name : '') }}');
                        $('#input-billing-district-select').val('{{ old('district_id') ? old('district_id' ) : (isset($billing_details) ? $billing_details->district_id : '') }}');
                        $('#input-billing-city-name').val('{{ old('city_name') ? old('city_name' ) : (isset($billing_details) ? $billing_details->city_name : '') }}');
                        $('#input-billing-city-select').val('{{ old('city_id') ? old('city_id' ) : (isset($billing_details) ? $billing_details->city_id : '') }}');
                        $('#input-billing-pin-code').val('{{ old('pin_code') ? old('pin_code' ) : (isset($billing_details) ? $billing_details->pin_code : '') }}');
                        $('#input-billing-street-address-1').val('{{ old('street_address_1') ? old('street_address_1' ) : (isset($billing_details) ? $billing_details->street_address_1 : '') }}');
                        $('#input-billing-street-address-2').val('{{ old('street_address_2') ? old('street_address_2' ) : (isset($billing_details) ? $billing_details->street_address_2 : '') }}');

                        // needs to check
                        // billing-other-field-wrapper
                        var other_field_wrapper_class = 'billing-other-field-wrapper'; 
                        var other_country_class = 'billing-other-country';
                        var country_select_class = 'billing-country-select';

                        if ($('#input-billing-country-select').val() != null) {
                            if ($('#input-billing-country-select').val() != 0) {
                                get_states('{{ old('country_id') ? old('country_id' ) : (isset($billing_details) ? $billing_details->country_id : 0) }}', 
                                           '{{ old('state_id') ? old('state_id' ) : (isset($billing_details) ? $billing_details->state_id : 0) }}', 
                                           '{{ old('district_id') ? old('district_id' ) : (isset($billing_details) ? $billing_details->district_id : 0) }}', 
                                           '{{ old('city_id') ? old('city_id' ) : (isset($billing_details) ? $billing_details->city_id : 0) }}', 
                                           'input-billing-state-select', 
                                           'input-billing-district-select', 
                                           'input-billing-city-select'
                                        );
                                $("."+country_select_class).show();
                                $("."+country_select_class).attr('required', true);

                                $("."+other_field_wrapper_class).hide();
                                $("."+other_country_class).attr('required', false);
                                $("."+other_country_class).attr('disabled', true);
                            }
                            // else{
                            //     $("#totalShippingCost").val(0);
                            //     $("#shippingCost").html('Extra');
                            //     $("."+country_select_class).hide();
                            //     $("."+country_select_class).attr('required', false);

                            //     $("."+other_field_wrapper_class).show();
                            //     $("."+other_country_class).attr('required', true);
                            //     $("."+other_country_class).attr('disabled', false);
                            // }
                        }
                        // else{
                        //     $("."+country_select_class).show();
                        //     $("."+country_select_class).attr('required', true);

                        //     $("."+other_field_wrapper_class).hide();
                        //     $("."+other_country_class).attr('required', false);
                        //     $("."+other_country_class).attr('disabled', true);
                        //     $("#cashOnDelivery").hide();
                        //     $("#cash-input").attr('disabled',true);
                        // }
                    @endguest

                    if($('#input-billing-country-select').val() == '' || $('#input-billing-country-select').val() == null){
                        $("#input-billing-country-select").val($("#input-billing-country-select option:first").val());
                    }

                } else {
                    // $("#billing-box-info").slideUp();
                    $('.billing-address-status').attr('disabled',true);
                    $('.req-not-req').attr('required',false);

                    // alert($('#cust_region').val());
                    $('#input-billing-name').val($('#input-shipping-name').val());
                    $('#input-billing-phone').val($('#input-shipping-phone').val());
                    $('#input-billing-phone2').val($('#input-shipping-phone2').val());
                    $('#input-billing-email').val($('#input-shipping-email').val());
                    $('#input-billing-country-name').val($('#input-shipping-country-name').val());
                    $('#input-billing-country-select').val($('#input-shipping-country-select').val());
                    $('#input-billing-state-name').val($('#input-shipping-state-name').val());
                    $('#input-billing-state-select').val($('#input-shipping-state-select').val());
                    $('#input-billing-district-name').val($('#input-shipping-district-name').val());
                    $('#input-billing-district-select').val($('#input-shipping-district-select').val());
                    $('#input-billing-city-name').val($('#input-shipping-city-name').val());
                    $('#input-billing-city-select').val($('#input-shipping-city-select').val());
                    $('#input-billing-pin-code').val($('#input-shipping-pin-code').val());
                    $('#input-billing-street-address-1').val($('#input-shipping-street-address-1').val());
                    $('#input-billing-street-address-2').val($('#input-shipping-street-address-2').val());

                    // billing-field wrapper
                    
                    var other_field_wrapper_class = 'billing-other-field-wrapper';
                    var other_country_class = 'billing-other-country';
                    var country_select_class = 'billing-country-select';

                    if ($('#input-billing-country-select').val() != null) {
                        if ($('#input-billing-country-select').val() != 0) {
                            get_states($('#input-shipping-country-select').val(), 
                                       $('#input-shipping-state-select').val(), 
                                       $('#input-shipping-district-select').val(), 
                                       $('#input-shipping-city-select').val(), 
                                       'input-billing-state-select', 
                                       'input-billing-district-select', 
                                       'input-billing-city-select'
                                    );
                            $("."+country_select_class).show();
                            $("."+country_select_class).attr('required', true);

                            $("."+other_field_wrapper_class).hide();
                            $("."+other_country_class).attr('required', false);
                            $("."+other_country_class).attr('disabled', true);

                        }
                        // else{
                        //     $("#totalShippingCost").val(0);
                        //     $("#shippingCost").html('Extra');
                        //     $("."+country_select_class).hide();
                        //     $("."+country_select_class).attr('required', false);

                        //     $("."+other_field_wrapper_class).show();
                        //     $("."+other_country_class).attr('required', true);
                        //     $("."+other_country_class).attr('disabled', false);
                        // }

                    }
                    // else{

                    //     $("."+country_select_class).show();
                    //     $("."+country_select_class).attr('required', true);

                    //     $("."+other_field_wrapper_class).hide();
                    //     $("."+other_country_class).attr('required', false);
                    //     $("."+other_country_class).attr('disabled', true);

                    //     $("#cashOnDelivery").hide();
                    //     $("#cash-input").attr('disabled',true);
                    // }
                    $('#input-shipping-state').val($('#input-billing-state').val());                
                    
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
                        if (country_select_class == 'shipping-country-select') {

                            $("#totalShippingCost").val(0);
                            $("#shippingCost").html('Extra');
                        }

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

                    if (country_select_class == 'shipping-country-select') {

                        $("#totalShippingCost").val(0);
                        $("#shippingCost").html('Extra');
                    }

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
                var district_type = city_input_id == 'input-shipping-city-select' ? 'shipping-district' : 0;
                $.ajax({
                    url: "{{ route('get-cities') }}",
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

                        // var obj = jQuery.parseJSON( response);
                        
                        $('#'+city_input_id).html(response); 

                        // // if (district_type == 'shipping-district') {

                        // //     $("#totalShippingCost").val(obj.shipping_cost);
                        // //     $("[name='shipping_cost']").val(obj.shipping_cost);
                        // //     $("#shippingCost").html(obj.shipping_cost);
                        // //     $("#totalPrice").html(obj.total_price);
                        // // }

                        // check_cod_availability($("#input-shipping-city-select").val());
                    }
                });
            }

            $("#input-shipping-city-select").change(function(){
               var city_id = $(this).val();
               get_shipping_pincode(city_id);
            });
            $("#input-billing-city-select").change(function(){
               var city_id = $(this).val();
               get_billing_pincode(city_id);
            });

            function get_shipping_pincode(city_id) {
                $.ajax({
                    url: "{{ route('get-shipping-pincode') }}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        city_id: city_id
                    },
                    success: function(response){
                        $('#modal-loader').hide();
                        console.log(response);
                        $('#input-shipping-pin-code').val(response['pin_code']);
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
            function get_billing_pincode(city_id) {
                $.ajax({
                    url: "{{ route('get-billing-pincode') }}",
                    type: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        city_id: city_id
                    },
                    success: function(response){
                        $('#modal-loader').hide();
                        console.log(response);
                        $('#input-billing-pin-code').val(response['pin_code']);
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

            
            
        </script>

@endpush
