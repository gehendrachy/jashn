@extends('backend.layouts.app')
@section('title', 'Return Request - #'.$return_request->return_request_no)
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/nestable/nestable.css') }}"/>
    <style type="text/css">
        .btn{
            padding: 4px 8px;
        }
        .btn i{
            margin-right: 0px;
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
                            <h5>Return Requests</h5>
                            <span>View Return Request Return Requests</span>

                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.return-requests.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.return-requests.index') }}">Return Requests</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">#{{ $return_request->return_request_no }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ route('admin.return-requests.store') }}" enctype="multipart/form-data">
                    @csrf
                
                    <div class="card border border-secondary">
                        {{-- <div class="card-header bg-default">
                            <h3>Drag & Drop to sort the Return Requests</h3>
                        </div> --}}

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border border-default card-solid">

                                            <div class="card-header with-border justify-content-between">
                                                
                                                <h3 class="card-title">Return Request Details</h3>

                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table header-border table-hover" id="returnRequestTable">
                                                        <thead>
                                                            <tr>
                                                                
                                                                <th>SN</th>
                                                                <th></th>
                                                                <th><strong>Product Name</strong></th>
                                                                <th><strong>Quantity</strong></th>
                                                                <th class="text-right"><strong>Price</strong></th>
                                                                <th class="text-right"><strong>Sub Total</strong></th>
                                                                <th class="text-center"><strong>Status</strong></th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $totalPrice = 0;
                                                        @endphp
                                                        @foreach($return_request->return_request_products as $key => $return_request_product)
                                                            @php
                                                            
                                                            $product = \App\Models\Product::where("id", $return_request_product->product_id)->first();

                                                            $product_variation = \App\Models\ProductVariation::where("id", $return_request_product->variation_id)->first();

                                                            $totalPrice += $return_request_product->sub_total;

                                                            @endphp

                                                            <tr>
                                                                <th>{{ $key+1 }}.</th>
                                                                <td class="text-center">

                                                                    @if(isset($product))
                                                                    
                                                                        <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug]) }}" >

                                                                            <img src="{{ asset('storage/products/'.$product->slug.'/thumbs/thumb_'.$product->image) }}" class="img-thumbnail" alt="{{ $product->slug }}" width="50">

                                                                        </a>

                                                                    @else

                                                                        <img src="https://place-hold.it/100x100/eeeef5?text=Image%20Unavailable&fontsize=8&italic&bold" width="50">

                                                                    @endif
                                                                </td>
                                                                
                                                                <td class="text-left" >
                                                                    
                                                                    @if(isset($product))

                                                                        <a target="_blank" href="{{ url('product/'.$product->slug) }}">
                                                                            <b>{{ $product->title }}</b> 
                                                                        </a>
                                                                        
                                                                        @if(isset($product_variation) && $product_variation->sku != NULL)
                                                                            <br>
                                                                            <small>{{ $product_variation->sku }}</small>
                                                                        @endif

                                                                    @else
                                                                        <b>{{ $return_request_product->product_title }}</b> 

                                                                    @endif
                                                                    
                                                                    <br>
                                                                    @if($return_request_product->size_id != 0)
                                                                        <p style="display: inline-block;">
                                                                            Size : {{ strtoupper($return_request_product->size_name) }}
                                                                        </p>
                                                                        <br>
                                                                    @endif

                                                                    @if($return_request_product->color_id != 0)
                                                                        Color : 
                                                                        <p style="margin-bottom: 0; display: inline-block; height: 16px; width: 16px; background: {{ $return_request_product->color_code }};"></p>

                                                                        <small style="display: inline-block; color: #778787; ">
                                                                            {{ strtoupper($return_request_product->color_name) }}
                                                                        </small>
                                                                    @endif
                                                                    <br>

                                                                    @if(!isset($product))
                                                                        <i style="font-size: 11px;">Product has been Deleted</i>
                                                                    @endif
                                                                    


                                                                </td>

                                                                <td class="text-center" >
                                                                    <b>{{(int)$return_request_product->quantity}}</b>
                                                                </td>

                                                                <td class="text-right" >
                                                                    <strong>
                                                                        Nrs.{{ $return_request_product->sub_total/$return_request_product->quantity }}
                                                                    </strong>
                                                                </td>
                                                                
                                                                <td class="text-right" >
                                                                    <strong>
                                                                        Nrs.{{ $return_request_product->sub_total }}
                                                                    </strong>
                                                                </td>

                                                                <td class="return-request-product-status text-center" id="returnRequestProductStatus{{ $return_request_product->id }}" width="10%">
                                                                    <small class="badge badge-{{ $return_status[$return_request_product->status][1] }}" >
                                                                        {{ $return_status[$return_request_product->status][0] }}
                                                                    </small>
                                                                </td>

                                                                <td class="text-left">
                                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action </button>
                                                                    <div class="dropdown-menu" style="">
                                                                        @for($i = 0; $i < count($return_status); $i++)
                                                                            <a href="javascript:void(0)" class="dropdown-item return-request-product-status-btn" data-return-request-product-id="{{ $return_request_product->id }}" data-status="{{ $i }}" href="">{{ $return_status[$i][0] }}</a>

                                                                        {!! $i == 5 ? '<div role="separator" class="dropdown-divider"></div>' : '' !!}
                                                                        @endfor
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            
                                                        @endforeach
                                                       
                                                        <tr>
                                                            <td colspan="5" class="text-right"> Grand Total </td>
                                                            <th class="text-right">Nrs.{{  number_format($totalPrice ,2)  }}</th>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="font-size: 12px !important;">

                                    <div class="col-md-6">
                                        <div class="card border border-default card-solid">
                                            <div class="card-header with-border">
                                                <h5 class="text-center">Billing Details</h5>
                                            </div>
                                            <div class="card-body ">
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

                                                    $billing_district = \App\Models\District::where('id',$billing_details->billing_district_id)->first();

                                                    $billing_state = \App\Models\State::where('id',$billing_details->billing_state_id)->first();

                                                    $billing_country = \App\Models\Country::where('id',$billing_details->billing_country_id)->first();

                                                @endphp

                                                {!! isset($billing_city) ? $billing_city->name : '<span style="color:red;">N-A</span>' !!}<br>
                                                {!! isset($billing_district) ? $billing_district->name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($billing_state) ? $billing_state->name : '<span style="color:red;">N-A</span>' !!}
                                                
                                                {{ $billing_details->billing_pin_code }}<br>
                                                
                                                {!! isset($billing_country) ? $billing_country->name : '<span style="color:red;">N-A</span>' !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border border-default card-solid">
                                            <div class="card-header with-border">
                                                <h5 class="text-center">Shipping Details</h5>
                                            </div>
                                            <div class="card-body">
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

                                                    $shipping_district = \App\Models\District::where('id',$shipping_details->shipping_district_id)->first();

                                                    $shipping_state = \App\Models\State::where('id',$shipping_details->shipping_state_id)->first();

                                                    $shipping_country = \App\Models\Country::where('id',$shipping_details->shipping_country_id)->first();
                                                    
                                                @endphp

                                                {!! isset($shipping_city) ? $shipping_city->name : '<span style="color:red;">N-A</span>' !!}<br>
                                                {!! isset($shipping_district) ? $shipping_district->name : '<span style="color:red;">N-A</span>' !!},
                                                
                                                {!! isset($shipping_state) ? $shipping_state->name : '<span style="color:red;">N-A</span>' !!}
                                                
                                                {{ $shipping_details->shipping_pin_code }}<br>
                                                
                                                {!! isset($shipping_country) ? $shipping_country->name : '<span style="color:red;">N-A</span>' !!}
                                                
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

    
@endsection

@push('script')

    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/nestable/jquery.nestable.js') }}"></script><!-- Jquery Nestable -->
    <script>
        $('#return-requests-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $(".return-request-product-status-btn").click(function(){
            var status = $(this).data('status');
            var return_request_product_id = $(this).data('return-request-product-id');

            $.ajax({
                url : "{{ URL::route('admin.return-requests.change-return-request-product-status') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        id: return_request_product_id,
                        status: status
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    console.log("response "+ response);
                    var obj = jQuery.parseJSON( response);

                    if (obj.status == 'success') {
                        
                        $('#returnRequestProductStatus'+return_request_product_id).load(document.URL + ' #returnRequestProductStatus'+return_request_product_id+'>*');

                        showNotification('Status Updated!','', 'info', 'top-right');
                    }else {
                        showNotification('Something went wrong!!','' , 'danger', 'top-right');
                        
                        
                    };
                }
            });
        });

    </script>
@endpush
