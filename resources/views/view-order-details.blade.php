@extends('layouts.app')
@section('title', Auth::user()->name.' - Order #'.$order->order_no)
@push('post-css')
    <style type="text/css">
        .table tbody td {
          vertical-align: middle;
        }

        .badge{
            font-size: 60%;
            font-weight: 500;
        }

        .table tbody td {
          vertical-align: middle;
        }

        .badge{
            font-size: 60%;
            font-weight: 500;
        }

        .btn{
            padding: .375rem .75rem;
        }
    </style>
@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="page-title-head">
                        Order - #{{ $order->order_no }}
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li><a href="{{ route('customer.orders') }}">Orders /</a></li>
                            <li>Order - #{{ $order->order_no }}</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cart mb-5">
        <div class="container">
            <h6><a href="{{ route('customer.orders') }}"><small><i class="ti-arrow-left"></i></small> Go Back To Order History</a>
            </h6>
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
                        @if($order->payment_method == 2 && $order->payment_status != 1)
                            <span class="input-group-append">
                                <a class="btn btn-sm btn-warning" href="{{ route('customer.pay-now', ['order_no' => base64_encode($order->order_no)]) }}">Pay Now</a>
                            </span>
                        @endif

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
                                    @if($ordered_product->status == 4 && $ordered_product->is_shipped == 1)
                                        {{ 'Shipped' }}
                                    @else
                                        {{ $order_status[$ordered_product->status][0] }}
                                    @endif
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

        </div>
    </section>

    <div class="modal fade" id="returnProductModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Return Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('customer.store-return-request') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="orderedProductId" type="hidden" name="ordered_product_id" value="">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Quantity</label>
                                    </span>
                                    <input id="returnQuantity" type="number" name="quantity" class="form-control" min="1" max="" value="1" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Reason</label>
                                    </span>
                                    <select name="reason" class="form-control" required>
                                        <option value="1">Damage</option>
                                        <option value="2">Different Product</option>
                                        <option value="3">Size not Fit</option>
                                        <option value="4">Spl Request</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Upload Image</label>
                                    </span>
                                    <input type="file" id="img" name="image" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('post-scripts')
    <script>
        $(".return-ordered-product-btn").click(function(){
            var ordered_product_id = $(this).data('ordered-product-id');
            var ordered_product_qty = $(this).data('ordered-product-qty');

            $("#orderedProductId").val(ordered_product_id);
            $("#returnQuantity").attr('max', ordered_product_qty);

        });
        
    </script>
@endpush