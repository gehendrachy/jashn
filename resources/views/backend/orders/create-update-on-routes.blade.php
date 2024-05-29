@extends('backend.layouts.app')
@section('title', 'On Route Orders  ')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
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
                        <i class="ik ik-anchor bg-blue"></i>
                        <div class="d-inline">
                            <h5>On Route Orders</h5>
                            <span>Create, Update, Delete On Route Orders</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.orders.on-route.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.orders.on-route') }}">Create On Route Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.orders.on-route.edit') ? 'Update' : 'Create New' }} On Route</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.orders.on-route.edit') ? route('admin.orders.on-route.update',$on_route) : route('admin.orders.on-route.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.orders.on-route.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.orders.on-route.edit') ? 'Update On Route' : 'Create New On Route' }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="input-group input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Tag Name</label>
                                        </span>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter On Route Tag Name" required value="{{ old('name') ? old('name') : (request()->routeIs('admin.orders.on-route.edit') ? $on_route->name : '') }}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card" id="onRouteOrders">
                                @if(request()->routeIs('admin.orders.on-route.edit'))
                                    @php $key = 0; @endphp
                                    @foreach($db_on_route_ordered_products as $order_id => $onRoProd)
                                        
                                        @php $key++; @endphp
                                        <div class="card-body border on-route-orders mb-1" id="on-route-order-{{ $key }}" data-cumulative-count="{{ $key }}">
                                            
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="input-group input-group mb-0">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-shopping-bag"></i>&nbsp; Order</label>
                                                        </span>
                                                        <select name="on_route[{{ $key }}][order_id]" onchange="get_related_ordered_products(this)" data-ordered-product-select-id="ordered-products-{{ $key }}" class="form-control select2 on-route-order" required>
                                                            <option disabled selected>Select Order</option>
                                                            @foreach($orders as $order)
                                                                <option {{ $order->id == $order_id ? 'selected' : '' }} value="{{ $order->id }}">#{{ $order->order_no }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-9">
                                                    <div class="input-group input-group mb-0">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-shopping-cart"></i>&nbsp; Ordered Product</label>
                                                        </span>
                                                        <select name="on_route[{{ $key }}][ordered_product_id][]" id="ordered-products-{{ $key}}" class="ordered-product form-control select2" multiple required>
                                                            
                                                        </select>
                                                        {{-- <span class="input-group-append">
                                                            <button type="button" class="btn btn-danger remove-on-route-order-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-order-{{ $key }}" data-on-route-id="{{ $on_route->id }}">
                                                                <i class="fa fa-trash m-0"></i>
                                                            </button>
                                                        </span> --}}
                                                    </div>
                                                </div>
                                                
                                            </div>                                
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card-body border on-route-orders mb-1" id="on-route-order-1" data-cumulative-count="1">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="input-group input-group mb-0">
                                                    <span class="input-group-prepend">
                                                        <label class="input-group-text"><i class="ik ik-shopping-bag"></i>&nbsp; Order</label>
                                                    </span>
                                                    <select name="on_route[1][order_id]" onchange="get_related_ordered_products(this)" data-ordered-product-select-id="ordered-products-1" class="form-control select2" required>
                                                        <option disabled selected>Select Order</option>
                                                        @foreach($orders as $key => $order)
                                                            <option value="{{ $order->id }}">#{{ $order->order_no }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-9">
                                                <div class="input-group input-group mb-0">
                                                    <span class="input-group-prepend">
                                                        <label class="input-group-text"><i class="ik ik-shopping-cart"></i>&nbsp; Ordered Product</label>
                                                    </span>
                                                    <select name="on_route[1][ordered_product_id][]" id="ordered-products-1" class="ordered-product form-control select2" multiple required>
                                                        
                                                    </select>
                                                    {{-- <span class="input-group-append">
                                                        <button type="button" class="btn btn-outline-danger remove-on-route-order-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-order-1">
                                                            <i class="fa fa-trash m-0"></i>
                                                        </button>
                                                    </span> --}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <button class="btn btn-warning" type="button" data-total-orders="{{ $orders->count() }}" id="addMoreBtn">Add More Orders</button>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group">
                                        
                                        <span class="form-control" style="padding-top: 6px; max-width: 60px;">
                                            @php
                                                $has_other_products = request()->routeIs('admin.orders.on-route.edit') ? ($on_route->product_sizes->count() > 0 ? 1 : 0) : 0;
                                            @endphp
                                            <input name="has_other_products" {{ $has_other_products == 1 ? 'checked' : '' }} type="checkbox" class="form-control add-other-products" value="1" />
                                        </span>
                                        <span class="input-group-append">
                                            <label class="input-group-text"><i class="ik ik-shopping-cart"></i>&nbsp; Add More Product Stock</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="addOtherProducts" style="display: {{ $has_other_products == 1 ? 'block' : 'none'  }};">
                                <div class="card">
                                    <div class="row" id="onRouteOthers">
                                        @if(request()->routeIs('admin.orders.on-route.edit'))

                                        @foreach($on_route->on_route_product_sizes as $key => $other_product)
                                            <div class="col-md-4 on-route-others mb-1" id="on-route-other-{{ $key }}" data-cumulative-count="{{ $key }}">
                                                <div class="card-body border">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group input-group mb-1">
                                                                <span class="input-group-prepend">
                                                                    <label class="input-group-text">
                                                                        <i class="ik ik-shopping-cart"></i>&nbsp; Product
                                                                    </label>
                                                                </span>
                                                                <select name="on_route_other[{{ $key }}][product_size_id]" class="form-control other-product select2" required>
                                                                    <option disabled selected>Select Product</option>
                                                                    @foreach($product_sizes as $product_size)
                                                                        <option {{ $product_size->id == $other_product->product_size_id ? 'selected' : '' }} value="{{ $product_size->id }}">{{ $product_size->sku }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="input-group input-group mb-1">
                                                                <span class="input-group-prepend">
                                                                    <label class="input-group-text">
                                                                        <i class="ik ik-shopping-cart"></i>&nbsp; Quantity
                                                                    </label>
                                                                </span>
                                                                <input type="number" name="on_route_other[{{ $key }}][quantity]" class="form-control other-product" value="{{ $other_product->quantity }}" min="1" required>
                                                                {{-- <span class="input-group-append">
                                                                    <button type="button" class="btn btn-outline-danger remove-on-route-other-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-other-{{ $key }}">
                                                                        <i class="fa fa-trash m-0"></i>
                                                                    </button>
                                                                </span> --}}
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="col-md-4 on-route-others mb-1" id="on-route-other-1" data-cumulative-count="1">
                                                <div class="card-body border">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group input-group mb-1">
                                                                <span class="input-group-prepend">
                                                                    <label class="input-group-text">
                                                                        <i class="ik ik-shopping-cart"></i>&nbsp; Product
                                                                    </label>
                                                                </span>
                                                                <select name="on_route_other[1][product_size_id]" class="form-control other-product select2" disabled>
                                                                    <option disabled selected>Select Product</option>
                                                                    @foreach($product_sizes as $product_size)
                                                                        <option value="{{ $product_size->id }}">{{ $product_size->sku }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="input-group input-group mb-1">
                                                                <span class="input-group-prepend">
                                                                    <label class="input-group-text">
                                                                        <i class="ik ik-shopping-cart"></i>&nbsp; Quantity
                                                                    </label>
                                                                </span>
                                                                <input type="number" name="on_route_other[1][quantity]" class="form-control other-product" min="1" disabled>
                                                                {{-- <span class="input-group-append">
                                                                    <button type="button" class="btn btn-outline-danger remove-on-route-other-btn" onclick="remove_on_route_order(this)" data-div-id="on-route-other-1">
                                                                        <i class="fa fa-trash m-0"></i>
                                                                    </button>
                                                                </span> --}}
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <button class="btn btn-warning" type="button" id="addMoreOtherBtn">Add More Products</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- <button class="btn btn-primary" type="button" data-total-orders="{{ $orders->count() }}" id="addMoreBtn">Add More Orders</button> --}}
                                    {{-- <a href="{{ route('admin.orders.on-route') }}" class="btn btn-danger">Cancel</a> --}}
                                    <button type="submit" class="btn btn-success mr-2 float-right">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <!--  datatable script-->
    <script>
        $("#addMoreBtn").click(function(){
            var i = $(".on-route-orders").last().data('cumulative-count');
            i = i == null ? 0 : i;
            i++;

            add_more_orders(i);

        });

        function add_more_orders(index) {

            $.ajax({
                url : "{{ URL::route('admin.orders.on-route.add-more-orders') }}",
                type : "POST",
                data : { '_token': '{{ csrf_token() }}',
                            key: index
                        },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);
                        $("#onRouteOrders").append(obj.response);
                        $(".select2").select2({
                            "width" : "100%",
                            placeholder: "Select Order First"
                        });
                    }
                }
            });
        }

        $("#addMoreOtherBtn").click(function(){
            var i = $(".on-route-others").last().data('cumulative-count');
            i = i == null ? 0 : i;
            i++;

            add_more_products(i);

        });

        function add_more_products(index) {

            $.ajax({
                url : "{{ URL::route('admin.orders.on-route.add-more-products') }}",
                type : "POST",
                data : { '_token': '{{ csrf_token() }}',
                            key: index
                        },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);
                        $("#onRouteOthers").append(obj.response);
                        $(".select2").select2({
                            "width" : "100%",
                            placeholder: "Select Order First"
                        });
                    }
                }
            });
        }

        // function initializeSelect2(selectElementObj) {
        //     selectElementObj.select2({
        //       width: "80%",
        //       tags: true
        //     });
        //   }

        $(".on-route-order").each(function(){
            get_related_ordered_products(this);
        });

        function get_related_ordered_products(that){
            var order_id = $(that).val();
            var ordered_product_select_id = $(that).data('ordered-product-select-id');
            // alert(ordered_product_select_id);
            // return;
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.orders.on-route.get-related-ordered-products') }}",
                data: {
                    "_token" : '{{ csrf_token() }}',
                    order_id : order_id,
                    on_route_id : '{{ request()->routeIs('admin.orders.on-route.edit') ? base64_encode($on_route->id) : 0 }}'
                },
                beforeSend: function(){                
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);

                        $("#"+ordered_product_select_id).html(obj.ordered_products);

                        $(".select2").select2({
                            "width" : "100%",
                            placeholder: "Select Order First"
                        });
                    }
                }
            });
        }

        (function ($) {

            $(".select2").select2({
                "width" : "100%",
                placeholder: "Select Order First"
            });

        })(jQuery);

        function remove_on_route_order(that) {

            swal({
                title: "Are you sure?",
                text: "It will remove all data asssociated with it!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true

            }, function (isConfirm) {

                if (isConfirm) {
                    $('#modal-loader').show();
                    var on_route_id = $(that).data('on-route-id');
                    var div_id = $(that).data('div-id');
                    

                    if (on_route_id) {

                        /*$.ajax({
                            url : "{{ URL::route('admin.orders.on-route.delete-order') }}",
                            type : "POST",
                            data : {
                                '_token': '{{ csrf_token() }}',
                                id: on_route_id
                            },
                            cache : false,
                            beforeSend : function (){

                            },
                            complete : function($response, $status){
                                $('#modal-loader').hide();

                                if ($status != "error" && $status != "timeout" && $response.responseText != 'error') {
                                    
                                    $('#'+div_id).remove();
                                    // var group_size_input_count = $(".group-size-input").length;
                                    // if (group_size_input_count <= 1) {
                                    //     $('.remove-size-btn').hide();
                                    // }
                                }else{
                                    alert('Something went Wrong');
                                }
                            },
                            error : function ($responseObj){
                                setTimeout(function(){
                                    $('#modal-loader').hide();
                                    alert("Something went wrong while processing your request.\n\nError => "
                                    + $responseObj.responseText);
                                }, 500);
                                

                            }
                        });*/

                    }else{

                        $('#modal-loader').hide();
                        $('#'+div_id).remove();

                        var group_size_input_count = $(".group-size-input").length;
                        if (group_size_input_count <= 1) {
                            $('.remove-size-btn').hide();
                        }
                    }
                    
                }

            });
            
        }

        var elem = Array.prototype.slice.call(document.querySelectorAll('.add-other-products'));

        elem.forEach(function(html) {
            
            var switchery = new Switchery(html, {
                color: '#4099ff',
                jackColor: '#fff',
                size: 'small',
                secondaryColor: '#eb525d'
            });

            html.onchange = function(e) {

                

                if ($(this).is(':checked')) {

                    $("#addOtherProducts").slideDown();
                    $(".other-product").attr('required', true);
                    $(".other-product").attr('disabled', false);

                }else{

                    $("#addOtherProducts").slideUp();
                    $(".other-product").attr('required', false);
                    $(".other-product").attr('disabled', true);
                }
               
            };
        });
    </script>
@endpush
