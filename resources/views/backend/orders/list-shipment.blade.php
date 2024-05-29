@extends('backend.layouts.app')
@section('title', 'Shipment')
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
                            <h5>Shipment Orders</h5>
                            {{-- <span>Create, Update, Delete Shipment</span> --}}

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
                                <a href="{{ route('admin.orders.index') }}">Shipment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List Shipment</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
     
                <div class="card border border-secondary">
                    <div class="card-header bg-default">
                        <h3>
                            <a href="{{ route('admin.orders.on-route.create') }}" class="btn btn-primary">Create New</a>
                        </h3>
                    </div>
                    
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dt-responsive">
                                    <table id="orders-table" class="table table-striped table-bordered nowrap" style="margin-left: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Order No#</th>
                                                <th>SKU - Qty</th>
                                                <th>Courier</th>
                                                <th>Tracking #</th>
                                                <th>Customer Name</th>
                                                <th>Customer #</th>
                                                <th style="font-size: 10px;">Date of Shipping</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ordered_product_shipments as $key => $rts_products)
                                            <tr id="shipmentStatus{{ $rts_products[0]->tracking_no }}">
                                                <td>
                                                    <strong>
                                                        <a target="_blank" href="{{ route('admin.orders.show', $rts_products[0]->ordered_product->order->order_no) }}">#{{ $rts_products[0]->ordered_product->order->order_no }}</a>
                                                    </strong>
                                                </td>
                                                <td>
                                                    @php
                                                        $total_price = 0; 
                                                        $preorder_total_weight = 0;
                                                        $instock_total_weight = 0;

                                                    @endphp
                                                    @foreach($rts_products as $rts)
                                                        @php
                                                            $product = \App\Models\Product::withTrashed()->where("id", $rts->ordered_product->product_id)->first();

                                                            $mrp = $rts->ordered_product->sub_total;

                                                            if ($rts->ordered_product->has_free_shipping == 0) {

                                                                if ($rts->ordered_product->preorder_status == 0) {
                                                                    
                                                                    $instock_total_weight = $instock_total_weight + ($rts->ordered_product->quantity * $product->weight);
                                                                }else{

                                                                    $preorder_total_weight = $preorder_total_weight + ($rts->ordered_product->quantity * $product->weight);
                                                                }
                                                            }



                                                            if($rts->ordered_product->ordered_product_offer()->count() > 0){
                                                                
                                                                $mrp = $mrp - $rts->ordered_product->ordered_product_offer->discount_amount;
                                                            }

                                                            if($rts->ordered_product->ordered_product_discount_coupon()->count() > 0){
                                                                
                                                                $mrp = $mrp - $rts->ordered_product->ordered_product_discount_coupon->discount_amount;
                                                            }

                                                            $mrp = round($mrp);

                                                            $total_price += $mrp;
                                                        @endphp

                                                        @if(isset($rts->ordered_product->product_size->sku))
                                                        <small>
                                                            {{ $rts->ordered_product->product_size->sku }} - {{ $rts->ordered_product->quantity }} Pc{{ $rts->ordered_product->quantity > 1 ? 's' : '' }}
                                                        </small><br>
                                                        @endif
                                                    @endforeach
                                                    @php
                                                        $shipping_details = json_decode($rts_products[0]->ordered_product->order->shipping_details);
                                                        $total_weight = $instock_total_weight + $preorder_total_weight;

                                                        $instock_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $instock_total_weight);
                                                        

                                                        $preorder_delivery_charge = \App\Models\Order::calculate_delivery_charge($shipping_details->shipping_district_id, $preorder_total_weight);
                                                        

                                                        $delivery_charge = $instock_delivery_charge + $preorder_delivery_charge;
                                                        
                                                        $total_price = $total_price + $delivery_charge;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $rts_products[0]->courier->name }}
                                                </td>
                                                <td>
                                                    {{ $rts_products[0]->tracking_no }}
                                                </td>
                                                <td>
                                                    @php
                                                        $shipping_details = json_decode($rts_products[0]->ordered_product->order->shipping_details);
                                                    @endphp
                                                    {{ $shipping_details->shipping_name }}
                                                </td>
                                                <td>
                                                    {{ $shipping_details->shipping_phone }}
                                                </td>
                                                <td style="font-size: 10px;">
                                                    {{ date('jS F,Y', strtotime($rts_products[0]->created_at)) }}
                                                </td>
                                                <td>{{ $total_price }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status </button>
                                                    <div class="dropdown-menu" style="">

                                                        <a href="javascript:void(0)" class="dropdown-item shipment-status-btn" data-tracking-no="{{ $rts_products[0]->tracking_no }}" data-status="5">Delivered</a>

                                                        <a href="#failedModal" class="dropdown-item shipment-status-btn" data-toggle="modal" data-tracking-no="{{ $rts_products[0]->tracking_no }}" data-status="8">Failed</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                
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

    <div class="modal fade" id="failedModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">{{ __('Cancel this Product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.orders.failed-shipment-ordered-product') }}" method="POST">
                    @csrf
                    <input id="trackingNo" type="hidden" name="tracking_no" value="">
                    <input id="shipmentStatus" type="hidden" name="status" value="">
                    <div class="modal-body">
                        <p>Are you sure, you want to cancel this ordered Product?</p>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Reason</label>
                            </span>
                            <select class="form-control" name="remarks" required>
                                @for($i=1; $i <= count($failed_reasons); $i++)
                                    <option value="{{ $failed_reasons[$i] }}">{{ $failed_reasons[$i] }}</option>
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
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $(".shipment-status-btn").click(function(){
            var status = $(this).data('status');
            var tracking_no = $(this).data('tracking-no');

            if (status == 8) {
                $("#shipmentStatus").val(status);
                $("#trackingNo").val(tracking_no);
                return;
            }

            $.ajax({
                url : "{{ URL::route('admin.orders.change-shipment-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        tracking_no: tracking_no,
                        status: 5
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    // console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#shipmentStatus'+tracking_no).remove();

                        showNotification('Status Updated!','', 'info', 'top-right');
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
                    };
                }
            });
        });
    </script>
@endpush
