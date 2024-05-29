@extends('backend.layouts.app')
@section('title', 'Order - #'.$order->order_no)
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}"/>
    <style type="text/css">

        .btn{
            padding: 4px 8px;
        }

        .btn i{
            margin-right: 0px;
        }

        .badge {
          padding: 4px 6px;
          font-size: 10px;
          font-weight: 500;
        }
    </style>
@endpush
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-shopping-bag bg-blue"></i>
                        <div class="d-inline">
                            <h5>Orders</h5>
                            <span>View Order Orders</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.orders.index') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_no }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        {{-- <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Orders</h3>
                        </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border border-default card-solid">

                                            <div class="card-header with-border justify-content-between">
                                                
                                                {{-- <h3 class="card-title">Order Details</h3> --}}


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text" style="min-width: 170px;">
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
                                                                <label class="input-group-text" style="min-width: 170px;">
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
                                                                <label class="input-group-text" style="min-width: 170px;">
                                                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Mode 
                                                                </label>
                                                            </span>
                                                            <select class="form-control payment-select" id="paymentMode" data-type="payment-mode">

                                                                @for($i=1; $i<count($payment_method); $i++)
                                                                    <option {{ $order->payment_method == $i ? 'selected' : '' }} value="{{ $i }}">{{ $payment_method[$i] }}</option>
                                                                @endfor

                                                            </select>
                                                        </div>

                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text" style="min-width: 170px;">
                                                                    <i class="ik ik-shopping-bag"></i>&nbsp;  Payment Status 
                                                                </label>
                                                            </span>
                                                            <select class="form-control payment-select" id="paymentStatus" data-type="payment-status">
                                                                <option value="0" {{ $order->payment_status == 0 ? 'selected' : '' }}>
                                                                    Payment Pending
                                                                </option>
                                                                <option value="1" {{ $order->payment_status == 1 ? 'selected' : '' }}>
                                                                    Payment Received
                                                                </option>
                                                            </select>
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

                                                <button id="status-checkbox" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: none;"> 
                                                    Change Status for Selected Products<span class="caret"></span>
                                                </button>

                                                <div class="dropdown-menu" style="">
                                                    @for($i = 0; $i < count($order_status); $i++)
                                                        @if(!in_array($i, [2,3,5,6,7,8]))
                                                            <a href="javascript:void(0)" id="order-status-{{ $i }}" class="dropdown-item order-status-btn" data-order-id="{{ $order->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>
                                                        @endif
                                                    @endfor
                                                </div>                                                    
                                                
                                                
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table header-border table-hover" id="orderTable">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>SN</th>
                                                                <th></th>
                                                                <th><strong>Product Name</strong></th>
                                                                <th><strong>Qty</strong></th>
                                                                <th class="text-right"><strong>MRP</strong></th>
                                                                {{-- <th class="text-right"><strong>Offer</strong></th> --}}
                                                                <th class="text-right"><strong>Total</strong></th>
                                                                <th>Weight</th>
                                                                <th style="font-size: 10px;">Delivery Due On</th>
                                                                <th class="text-center"><strong>Status</strong></th>
                                                                <th>Action</th>
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
                                                                <td>
                                                                    <input type="checkbox" class="ordered-product-checkbox" value="{{ $ordered_product->id }}" data-preorder-status="{{ $ordered_product->preorder_status }}">
                                                                </td>
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
                                                                            <b>{{ $product->title }}</b> 
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

                                                                    @if($ordered_product->ordered_product_rts()->count() > 0)
                                                                        <br><i style="font-size: 11px;">Tracking No #<b>{{ $ordered_product->ordered_product_rts->tracking_no }}</b></i>
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

                                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Dashboard" class="badge badge-{{ $order_status[$ordered_product->status][1] }}" >
                                                                        @if($ordered_product->status == 4 && $ordered_product->is_shipped == 1)
                                                                            {{ 'Shipped' }}
                                                                        @else
                                                                            {{ $order_status[$ordered_product->status][0] }}
                                                                        @endif
                                                                    </a>
                                                                </td>

                                                                <td class="text-left">
                                                                    @if(!in_array($ordered_product->status, []))
                                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
                                                                    <div class="dropdown-menu" style="">
                                                                        @for($i = 0; $i < count($order_status); $i++)

                                                                            @if(!in_array($i, [2,3,5,6,7,8]))
                                                                                @if($ordered_product->preorder_status == 0 || $i != 4)

                                                                                    <a href="javascript:void(0)" class="dropdown-item ordered-product-status-btn" data-ordered-product-id="{{ $ordered_product->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>
                                                                                
                                                                                @endif
                                                                            @endif

                                                                            @if($ordered_product->preorder_status == 0 && in_array($i, [6]))

                                                                                <a href="#cancelModal" class="dropdown-item ordered-product-status-btn" data-toggle="modal" data-ordered-product-id="{{ $ordered_product->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>

                                                                            @elseif($ordered_product->preorder_status == 1 && in_array($i, [6]))

                                                                                <a href="#cancelModal" class="dropdown-item ordered-product-status-btn" data-toggle="modal" data-ordered-product-id="{{ $ordered_product->id }}" data-status="{{ $i }}" href="">{{ $order_status[$i][0] }}</a>
                                                                            @endif
                                                                        {!! $i == 5 ? '<div role="separator" class="dropdown-divider"></div>' : '' !!}
                                                                        @endfor
                                                                    </div>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                            
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-left">Total</td>
                                                            <td class="text-center"><strong id="totalQty">{{ $total_quantity }}</strong></td>
                                                            <td class="text-right"><strong id="totalMrp">{{ $total_mrp }}</strong></td>
                                                            {{-- <td class="text-right"><strong id="totalOfferPrice">{{ $calculated_offer_price }}</strong></td> --}}
                                                            <td class="text-right"><strong id="totalPrice">{{ $totalPrice }}</strong></td>
                                                            <td class="text-center"><span id="totalWeight">{{ $total_weight }}</span> Kg</td>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td colspan="6" class="text-Left">Offer </td>
                                                            
                                                            @php
                                                                $calculated_offer_price = round($calculated_offer_price);
                                                            @endphp

                                                            <th class="text-right"><span id="totalOfferPrice">{{ $calculated_offer_price }}</span></th>
                                                            <td colspan="4"></td>
                                                        </tr>

                                                        @php
                                                            $totalPrice = $totalPrice - $calculated_offer_price;
                                                        @endphp
                                                        <tr>
                                                            <td colspan="6" class="text-Left">Total </td>
                                                            <td class="text-right" id="totalPriceAfterOffer">{{ $totalPrice }}</td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        @php
                                                            $calculated_discount_price = round($calculated_discount_price);
                                                        @endphp

                                                        @if(isset($order->applied_coupon))
                                                            <tr>
                                                                <td colspan="6" class="text-left">
                                                                    {{ $order->applied_coupon->coupon_title }} 
                                                                    <strong>[ {{ $order->applied_coupon->coupon_code }} ]</strong>
                                                                </td>
                                                                <th class="text-right">
                                                                    {{-- {{ $order->applied_coupon->discount_amount }} --}}
                                                                    {{ $calculated_discount_price }}
                                                                </th>
                                                                <td colspan="4"></td>
                                                            </tr>

                                                            @php
                                                                // $totalPrice = $totalPrice - $order->applied_coupon->discount_amount;
                                                                $totalPrice = $totalPrice - $calculated_discount_price ;
                                                            @endphp

                                                            <tr>
                                                                <td colspan="6" class="text-left">
                                                                    Total
                                                                </td>
                                                                <td class="text-right">{{ $totalPrice }}</td>
                                                                <td colspan="4"></td>
                                                            </tr>

                                                        @endif

                                                        <tr>
                                                            <td colspan="6" class="text-left">
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
                                                            <td colspan="4"></td>
                                                        </tr>

                                                        @php
                                                            $totalPrice = $totalPrice + $order->delivery_charge;
                                                        @endphp

                                                        <tr>
                                                            <td colspan="6" class="text-left">
                                                                Total
                                                            </td>
                                                            <td class="text-right"><span id="totalPriceAfterCoupon">{{ $totalPrice }}</span></td>
                                                            <td colspan="4"></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="6" class="text-left">
                                                                Loyalty Point
                                                            </td>
                                                            <th class="text-right">
                                                                
                                                            </th>
                                                            <td colspan="4"></td>
                                                        </tr>

                                                        <tr>
                                                            <th colspan="6" class="text-left"> Grand Total </th>
                                                            <th class="text-right" style="color: #fc9800; font-size: 15px;">
                                                                <span id="grandTotalPrice">{{  $totalPrice }}</span>
                                                            </th>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="font-size: 12px !important;">

                                    <div class="col-md-4">
                                        <div class="card border border-default card-solid">
                                            <div class="card-header with-border p10">
                                                <h5 class="text-center">Billing Details</h5>
                                            </div>
                                            <div class="card-body  ">
                                                <strong>{{ $billing_details->billing_name }}</strong><br>
                                                {{ $billing_details->billing_email }}<br>
                                                <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $billing_details->billing_phone)}}">{{ $billing_details->billing_phone }}</a>
                                                @if($billing_details->billing_phone2 != NULL)
                                                    <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $billing_details->billing_phone2)}}">{{ $billing_details->billing_phone2 }}</a>
                                                @endif
                                                <br>
                                                {{ $billing_details->billing_street_address_1 }}, {{ $billing_details->billing_street_address_2 }}
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

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border border-default card-solid">
                                            <div class="card-header with-border p10">
                                                <h5 class="text-center">Shipping Details</h5>
                                            </div>
                                            <div class="card-body ">
                                                <strong>{{ $shipping_details->shipping_name }}</strong><br>
                                                {{ $shipping_details->shipping_email }}<br>
                                                <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $shipping_details->shipping_phone)}}">{{ $shipping_details->shipping_phone }}</a>
                                                @if($shipping_details->shipping_phone2 != NULL)
                                                    <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $shipping_details->shipping_phone2)}}">{{ $shipping_details->shipping_phone2 }}</a>
                                                @endif
                                                <br>
                                                {{ $shipping_details->shipping_street_address_1 }}, {{ $shipping_details->shipping_street_address_2 }}

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

                                                {!! isset($shipping_city_name) ? $shipping_city_name : '<span style="color:red;">N-A</span>' !!}<br>
                                                {!! isset($shipping_district_name) ? $shipping_district_name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($shipping_state_name) ? $shipping_state_name : '<span style="color:red;">N-A</span>' !!}
                                                
                                                {{ $shipping_details->shipping_pin_code }}<br>
                                                
                                                {!! isset($shipping_country_name) ? $shipping_country_name : '<span style="color:red;">N-A</span>' !!}
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card border border-default card-solid">
                                            <div class="card-header with-border p10">
                                                <h5 class="text-center">Order Note</h5>
                                            </div>
                                            <div class="card-body p10">
                                                <textarea id="orderNoteInput" class="form-control" placeholder="Enter Order Notes">{{ $order->additional_message }}</textarea><br>
                                                <button type="button" class="btn btn-outline-success" id="saveNoteBtn">Save Note</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Cancel this Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.orders.cancel-ordered-product') }}" method="POST">
                    @csrf
                    <input id="orderedProductId" type="hidden" name="ordered_product_id" value="">
                    <input id="orderedProductStatus" type="hidden" name="status" value="">
                    <div class="modal-body">
                        <p>Are you sure, you want to cancel this ordered Product?</p>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Reason</label>
                            </span>
                            <select class="form-control" name="remarks" required>
                                @for($i=1; $i <= count($canceled_reasons); $i++)
                                    <option value="{{ $canceled_reasons[$i] }}">{{ $canceled_reasons[$i] }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Cancel It')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $(".ordered-product-checkbox").click(function(){
            if ($(".ordered-product-checkbox:checkbox:checked").length > 0) {
                $("#status-checkbox").show();

                $("#order-status-4").show();
                $(".ordered-product-checkbox:checkbox:checked").each(function(){

                    if ($(this).data('preorder-status') == 1) {
                        $("#order-status-4").hide();
                    }
                });
            }else{
                $("#status-checkbox").hide();
            }

        });

        $(".order-status-btn").click(function(){
            var status = $(this).data('status');
            var checked_ordered_product_ids = [];
            var checked_ordered_products = $(".ordered-product-checkbox:checkbox:checked");

            for (var i = 0; i < checked_ordered_products.length; i++) {
                checked_ordered_product_ids.push(checked_ordered_products[i].value);
            }

            // console.log(checked_ordered_product_ids);
            // return;

            $.ajax({
                url : "{{ URL::route('admin.orders.change-selected-ordered-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        status: status,
                        ordered_product_ids: checked_ordered_product_ids
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {

                        for (var i = 0; i < checked_ordered_products.length; i++) {
                            var ordered_product_id = checked_ordered_products[i].value;

                            $('#orderedProductStatus'+ordered_product_id).load(document.URL + ' #orderedProductStatus'+ordered_product_id+'>*');
                        }
                        
                        
                        if (status == 0) {
                            showNotification('Order Status changed to PENDING!','{{ session('status') }}', 'warning', 'top-right');
                        }else if (status == 1) {
                            showNotification('Order Status changed to NEW!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 2) {
                            showNotification('Order Status changed to ON ROUTE!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 3) {
                            showNotification('Order Status changed to ARRIVED!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 4) {
                            showNotification('Order Status changed to RTS!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 5) {
                            showNotification('Order Status changed to DELIVERED!','{{ session('status') }}', 'success', 'top-right');
                        }else if (status == 6) {
                            showNotification('Order Status changed to CANCELED!','{{ session('status') }}', 'error', 'top-right');
                        }else if (status == 7) {
                            showNotification('Order Status changed to RETURNED!','{{ session('status') }}', 'warning', 'top-right');
                        }
                        

                    }else {

                        toastr['error']('Something went wrong!');
                        

                    };
                }
            });
        });

        $('#orders-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $(".ordered-product-status-btn").click(function(){
            var status = $(this).data('status');
            var ordered_product_id = $(this).data('ordered-product-id');

            if (status == 6 || status == 7) {
                $("#orderedProductStatus").val(status);
                $("#orderedProductId").val(ordered_product_id);
                return;
            }

            $.ajax({
                url : "{{ URL::route('admin.orders.change-ordered-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: ordered_product_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    // console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#orderedProductStatus'+ordered_product_id).load(document.URL + ' #orderedProductStatus'+ordered_product_id+'>*');

                        showNotification('Status Updated!','', 'info', 'top-right');
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
                    };
                }
            });
        });

        $(".payment-select").change(function(){
            var type = $(this).data('type');
            var order_id = '{{ base64_encode($order->id) }}';
            var selected_value = $(this).val();

            $.ajax({
                url : "{{ URL::route('admin.orders.change-payment-select') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: order_id,
                        type: type,
                        selected_value: selected_value

                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    var obj = jQuery.parseJSON( response);   
                    if (obj.status == 'success') {
                        if (type == 'payment-mode') {

                            showNotification('Status Updated!','Payment Mode Changed Successfully!', 'info', 'top-right');
                        }else{
                            showNotification('Status Updated!','Payment Status Changed Successfully!', 'info', 'top-right');
                        }
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
                    };
                }
            });
        });


        $("#saveNoteBtn").click(function(){

            var order_note = $('#orderNoteInput').val();
            var order_id = '{{ base64_encode($order->id) }}';

            $.ajax({
                url : "{{ URL::route('admin.orders.save-order-note') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: order_id,
                        order_note: order_note
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {

                        showNotification('Order Note saved!','Saved', 'info', 'top-right');
                        
                    }else {

                        toastr['error']('Something went wrong!');
                        

                    };
                }
            });
        });
        

        function delete_order(id) {
            var conn = 'orders/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
