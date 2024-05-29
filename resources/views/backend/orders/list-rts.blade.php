@extends('backend.layouts.app')
@section('title', 'RTS')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>RTS Orders</h5>
                            {{-- <span>Create, Update, Delete RTS</span> --}}

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
                                <a href="{{ route('admin.orders.index') }}">RTS</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List RTS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
     
                <div class="card border border-secondary">
                    {{-- <div class="card-header bg-default">
                        <h3>
                            <a href="{{ route('admin.orders.on-route.create') }}" class="btn btn-primary">Create New</a>
                        </h3>
                    </div> --}}
                    <form action="{{ route('admin.orders.manifest') }}" method="POST">
                        @csrf
                        <div class="card-body mt-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-responsive">
                                        <table id="orders-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Order #</th>
                                                    <th width="15%">SKU - Qty</th>
                                                    <th>Rate</th>
                                                    <th>Shipping</th>
                                                    <th>Total</th>
                                                    <th>COD Value</th>
                                                    <th style="font-size: 10px;">Payment Mode</th>
                                                    <th>Courier</th>
                                                    <th>Tracking</th>
                                                    <th>Invoice No</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $grand_total_rate = 0;
                                                    $grand_total_shipping = 0;
                                                    $grand_total_price = 0;
                                                    // $grouped_ordered_products = $ordered_products[59]->groupBy('preorder_status')->all()[1]->pluck('id')->all();
                                                    // dd($grouped_ordered_products);
                                                @endphp
                                                @foreach($ordered_products as $order_id => $ordered_product_row)
                                                    @php

                                                        // $grouped_ordered_products = $ordered_product->groupBy('preorder_status')->all();
                                                        // dd($ordered_product);
                                                        $ordered_product_row = array_values($ordered_product_row->all());
                                                        $order = \App\Models\Order::find($order_id);
                                                    @endphp

                                                    

                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="ordered-product-checkbox" name="rts[{{ $order_id }}][order_id]" value="{{ $order->id }}" data-key="{{ $order_id }}">
                                                        </td>
                                                        <td>
                                                            <strong>
                                                                <a target="_blank" href="{{ route('admin.orders.show', $order->order_no) }}">#{{ $order->order_no }}</a>
                                                            </strong>
                                                        </td>
                                                        {{-- <td> 
                                                            @foreach($ordered_product_row as $ordered_product)
                                                                {{ $ordered_product->product->title }}<br>
                                                            @endforeach
                                                        </td> --}}
                                                        <td> 
                                                            @foreach($ordered_product_row as $ordered_product)
                                                                @if(isset($ordered_product->product_size->sku))
                                                                <input type="hidden" name="rts[{{ $order_id }}][ordered_product_id][]" value="{{ $ordered_product->id }}" class="dis-status-{{ $order_id }} req-not-req-{{ $order_id }}">
                                                                <small>
                                                                    {{ $ordered_product->product_size->sku }} - {{ $ordered_product->quantity }} Pc{{ $ordered_product->quantity > 1 ? 's' : '' }}
                                                                </small><br>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @php 
                                                                $total_price = 0; 
                                                                $preorder_total_weight = 0;
                                                                $instock_total_weight = 0;
                                                                // if ($order_id == 36) {
                                                                    
                                                                //     dd($ordered_product_row[0]->ordered_product_rts);
                                                                // }
                                                                $db_courier_id = isset($ordered_product_row[0]->ordered_product_rts) ? $ordered_product_row[0]->ordered_product_rts->courier_id : '';

                                                                $db_tracking_no = isset($ordered_product_row[0]->ordered_product_rts) ? $ordered_product_row[0]->ordered_product_rts->tracking_no : '';

                                                                $db_invoice_no = isset($ordered_product_row[0]->ordered_product_rts) ? $ordered_product_row[0]->ordered_product_rts->invoice_no : '';
                                                            @endphp

                                                            @foreach($ordered_product_row as $ordered_product)
                                                                @php
                                                                    $product = \App\Models\Product::withTrashed()->where("id", $ordered_product->product_id)->first();

                                                                    $mrp = $ordered_product->sub_total;

                                                                    if ($ordered_product->has_free_shipping == 0) {

                                                                        if ($ordered_product->preorder_status == 0) {
                                                                            
                                                                            $instock_total_weight = $instock_total_weight + ($ordered_product->quantity * $product->weight);
                                                                        }else{

                                                                            $preorder_total_weight = $preorder_total_weight + ($ordered_product->quantity * $product->weight);
                                                                        }
                                                                    }



                                                                    if($ordered_product->ordered_product_offer()->count() > 0){
                                                                        
                                                                        $mrp = $mrp - $ordered_product->ordered_product_offer->discount_amount;
                                                                    }

                                                                    if($ordered_product->ordered_product_discount_coupon()->count() > 0){
                                                                        
                                                                        $mrp = $mrp - $ordered_product->ordered_product_discount_coupon->discount_amount;
                                                                    }

                                                                    $mrp = round($mrp);

                                                                    $total_price += $mrp;
                                                                @endphp
                                                                {{ $mrp }}<br>
                                                            @endforeach

                                                            {{-- @php
                                                                $rts_ordered_product_ids = $ordered_product_row->pluck('id')->all();

                                                                $order = \App\Models\Order::find($order_id);
                                                                $other_order_count = $order->ordered_products()->where('preorder_status', $odKey)->whereNotIn('id', $rts_ordered_product_ids)->count();
                                                                
                                                            @endphp
                                                            {{ $other_order_count }} --}}
                                                        </td>
                                                        <td>
                                                            
                                                            @php
                                                                $grand_total_rate += $total_price;
                                                                $shipping_details = json_decode($order->shipping_details);

                                                                $total_weight = $instock_total_weight + $preorder_total_weight;

                                                                $instock_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $instock_total_weight);
                                                                

                                                                $preorder_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $preorder_total_weight);
                                                                

                                                                $delivery_charge = $instock_delivery_charge + $preorder_delivery_charge;
                                                                
                                                                $total_price = $total_price + $delivery_charge;

                                                                $grand_total_shipping += $delivery_charge;
                                                                $grand_total_price += $total_price;
                                                            @endphp
                                                            {{ $delivery_charge }}
                                                        </td>
                                                        <td>{{ $total_price }}</td>
                                                        <td>{{ $order->payment_status == 1 ? 0 : $total_price }}</td>
                                                        <td>
                                                            <small>{{ $payment_method[$order->payment_method] }}</small>
                                                        </td>
                                                        <td>
                                                            
                                                            <select name="rts[{{ $order_id }}][courier_id]" class="form-control select2 dis-status-{{ $order_id }} req-not-req-{{ $order_id }}" required>
                                                                @foreach($couriers as $ckey => $courier)
                                                                    <option {{ $db_courier_id == $courier->id ? 'selected' : '' }} value="{{ $courier->id }}">{{ $courier->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm dis-status-{{ $order_id }} req-not-req-{{ $order_id }}" type="text" name="rts[{{ $order_id }}][tracking_no]" value="{{ $db_tracking_no }}" placeholder="Tracking #" required>
                                                        </td>
                                                        
                                                        <td>
                                                            <input class="form-control form-control-sm dis-status-{{ $order_id }}" type="text" name="rts[{{ $order_id }}][invoice_no]" value="{{ $db_invoice_no }}" placeholder="Invoice #" >
                                                        </td>
                                                    </tr>
                                                    
                                                @endforeach
                                                <tr>
                                                    <td colspan="3" class="text-right">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td>{{ $grand_total_rate }}</td>
                                                    <td>{{ $grand_total_shipping }}</td>
                                                    <td>{{ $grand_total_price }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success" name="manifest" type="submit" value="1"><i class="ik ik-truck"></i> Save & Manifest</button>
                                    <button class="btn btn-warning" name="save" type="submit" value="2"><i class="ik ik-save"></i> Save</button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
           
            </div>
        </div>
    </div>
   
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Delete RTS')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                <p>Are you sure, you want to delete RTS?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                    <a href="" class="btn btn-danger">{{ __('Yes, Delete It')}}</a>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        // $('#orders-table').DataTable({
        //     "paging": true,
        //     "lengthChange": true,
        //     "searching": true,
        //     "ordering": false,
        //     "info": true,
        //     "autoWidth": false
        // });

        $(".ordered-product-checkbox").click(function(){
            var key = $(this).data('key');
            
            if ($(this).is(':checked')) {
                $(".dis-status-"+key).attr('disabled', false);
                $(".req-not-req-"+key).attr('required', true);
            }else{

                $(".dis-status-"+key).attr('disabled', true);
                $(".req-not-req-"+key).attr('required', false);
            }
        });

        $(".ordered-product-checkbox").each(function(){
            var key = $(this).data('key');
            
            if ($(this).is(':checked')) {
                $(".dis-status-"+key).attr('disabled', false);
                $(".req-not-req-"+key).attr('required', true);
            }else{

                $(".dis-status-"+key).attr('disabled', true);
                $(".req-not-req-"+key).attr('required', false);
            }
        });

        $(".on-route-status-btn").click(function(){
            var status = $(this).data('status');
            var on_route_id = $(this).data('on-route-id');

            $.ajax({
                url : "{{ URL::route('admin.orders.on-route.change-on-route-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: on_route_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    // console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        
                        $('#onRouteStatus'+on_route_id).load(document.URL + ' #onRouteStatus'+on_route_id+'>*');

                        if (status == 3) {
                            $('#onRouteRow'+on_route_id).remove();
                        }

                        if (status == 2) {
                            showNotification('On Route Status changed to ON ROUTE!','{{ session('status') }}', 'info', 'top-right');
                        }else if (status == 3) {
                            showNotification('On Route Status changed to ARRIVED!','{{ session('status') }}', 'info', 'top-right');
                        }
                        
                    }else {
                        showNotification('Something went Wrong', '{{ session('status') }}', 'danger', 'top-right');
                        

                    };
                }
            });
        });

        (function ($) {

            $(".select2").select2({
                "width" : "100%",
                placeholder: "Select Order First"
            });

        })(jQuery);
        

        function delete_order(id) {
            var conn = 'orders/delete/' + id;
            $('#delete a').attr("href", conn);
        }
    </script>
@endpush
