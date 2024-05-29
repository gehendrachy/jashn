@extends('backend.layouts.app')
@section('title', 'Offers')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/multiselect/css/multi-select.css') }}">
    <style>
        .wrapper .page-wrap .main-content .page-header .page-header-title i {
            width: 50px !important;
            height: 50px !important;
        }

        .ms-container{
            width: 100% !important;
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
                            <h5>Create Offers</h5>
                            <span>Create, Update, Delete Create Offers</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.offers.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.offers.index') }}">Create Offers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.offers.edit') ? 'Update' : 'Create New' }} Offer</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.offers.edit') ? route('admin.offers.update', $offer) : route('admin.offers.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.offers.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.offers.edit') ? 'Update Offer' : 'Create New Offer' }}</h3>
                        </div>
                        <div class="card-body" id="Offers">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Offer Name</label>
                                        </span>
                                        <input name="name" type="text" class="form-control" placeholder="Enter Offer Name" required value="{{ old('name') ? old('name') : (request()->routeIs('admin.offers.edit') ? $offer->name : '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Offer Type</label>
                                        </span>
                                        <select id="offerType" class="form-control" name="offer_type" required>
                                            @php
                                                $offer_type = old('offer_type') ? old('offer_type') : (request()->routeIs('admin.offers.edit') ? $offer->offer_type : '')
                                            @endphp
                                            <option value="1" {{ $offer_type == 1 ? 'selected' : '' }}>Buy X Quantity get Y Amount Off</option>
                                            <option value="2" {{ $offer_type == 2 ? 'selected' : '' }}>Spend X Amount get Y Amount Off</option>
                                            <option value="3" {{ $offer_type == 3 ? 'selected' : '' }}>Free Shipping Offer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="shippingConditionDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Free Shipping Condition</label>
                                        </span>
                                        <select id="shippingConditionSelect" class="form-control" name="shipping_condition" required>
                                            @php
                                                $shipping_condition = old('shipping_condition') ? old('shipping_condition') : (request()->routeIs('admin.offers.edit') ? $offer->shipping_condition : '')
                                            @endphp
                                            <option value="1" {{ $shipping_condition == 1 ? 'selected' : '' }}>No Condition</option>
                                            <option value="2" {{ $shipping_condition == 2 ? 'selected' : '' }}>On Minimum Spend</option>
                                            <option value="3" {{ $shipping_condition == 3 ? 'selected' : '' }}>On Minimum Quantity</option>
                                            {{-- <option value="4" {{ $shipping_condition == 4 ? 'selected' : '' }}>On Pre Payment</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="discountPercentageDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Discount Percentage</label>
                                        </span>
                                        <input name="discount_percentage" type="text" id="discountPercentageInput" class="form-control offer-input" required placeholder="Discount Percentage, eg: 20" value="{{ old('discount_percentage') ? old('discount_percentage') : (request()->routeIs('admin.offers.edit') ? $offer->discount_percentage : '') }}">
                                        <span class="input-group-append">
                                            <label class="input-group-text"><i class="ik ik-percent"></i></label>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="minimumQuantityDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Minimum Order Quantity</label>
                                        </span>
                                        <input name="minimum_quantity" type="number" id="minimumQuantityInput" class="form-control offer-input" required placeholder="Minimum Product Quantity, eg: 10, 20" value="{{ old('minimum_quantity') ? old('minimum_quantity') : (request()->routeIs('admin.offers.edit') ? $offer->minimum_quantity : '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6" id="minimumSpendDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Minimum Spend</label>
                                        </span>
                                        <input name="minimum_spend" type="number" id="minimumSpendInput" class="form-control offer-input" required placeholder="Minimum Amount Spend, eg: 10000, 20000" value="{{ old('minimum_spend') ? old('minimum_spend') : (request()->routeIs('admin.offers.edit') ? $offer->minimum_spend : '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6" id="maximumDiscountDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Maximum Discount</label>
                                        </span>
                                        <input name="maximum_discount" type="text" id="maximumDiscountInput" class="form-control offer-input" required value="{{ old('maximum_discount') ? old('maximum_discount') : (request()->routeIs('admin.offers.edit') ? $offer->maximum_discount : '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Start Date Time</label>
                                        </span>
                                          <input type="text" class="form-control" value="{{ old('start_date') ? old('start_date') : (request()->routeIs('admin.offers.edit') ? $offer->start_date : '')  }}" name="start_date" placeholder="Start Date" required id="startDate" />

                                        {{-- <input type="time" class="form-control" value="{{ old('start_time') ? old('start_time') : (request()->routeIs('admin.offers.edit') ? $offer->start_time : '')  }}" name="start_time" required /> --}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; End Date Time</label>
                                        </span>
                                        <input type="text" class="form-control" value="{{ old('expire_date') ? old('expire_date') : (request()->routeIs('admin.offers.edit') ? $offer->expire_date : '')  }}" name="expire_date" placeholder="End Date" required id="endDate" />

                                        {{-- <input type="time" class="form-control" value="{{ old('expire_time') ? old('expire_time') : (request()->routeIs('admin.offers.edit') ? $offer->expire_time : '')  }}" name="expire_time" required /> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Discount On</label>
                                        </span>
                                        <select id="discountOn" class="form-control" name="discount_on" required>
                                            @php
                                                $discount_on = old('discount_on') ? old('discount_on') : (request()->routeIs('admin.offers.edit') ? $offer->discount_on : '')
                                            @endphp
                                            <option value="3" {{ $discount_on == 3 ? 'selected' : '' }}>All Products</option>
                                            <option value="1" {{ $discount_on == 1 ? 'selected' : '' }}>Selected Categories</option>
                                            <option value="2" {{ $discount_on == 2 ? 'selected' : '' }}>Selected Products</option>
                                            {{-- <option value="4" {{ $discount_on == 4 ? 'selected' : '' }}>Pre Payment</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="discountSelect">
                                    <div class="input-group">
                                        <select id="discountItems" class="form-control" name="discount_items[]" multiple>
                                            {{-- Dyamically date is fetched --}}
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.offers.index') }}" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
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
    <script src="{{ asset('backend/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/quicksearch-master/jquery.quicksearch.js') }}"></script>
    <script src="{{ asset('backend/plugins/multiselect/js/jquery.multi-select.js') }}"></script>

    <script>

        $("#offerType").change(function(){
            var offer_type = $(this).val();
            show_hide_offer_inputs(offer_type);
        });

        show_hide_offer_inputs($("#offerType").val());

        if ($("#offerType").val() == 3) {
            show_hide_minimum_field($("shippingConditionSelect").val());
        }

        $("#shippingConditionSelect").change(function(){
            var shipping_condition = $(this).val();
            show_hide_minimum_field(shipping_condition);
        });

        function show_hide_offer_inputs(offer_type) {

            switch(offer_type){
                case '1':
                    $("#minimumQuantityDiv").show();
                    $("#minimumQuantityInput").attr('required',true);
                    $("#minimumQuantityInput").attr('disabled',false);

                    $("#minimumSpendDiv").hide();
                    $("#minimumSpendInput").attr('required',false);
                    $("#minimumSpendInput").attr('disabled',true);

                    $("#maximumDiscountDiv").show();
                    $("#maximumDiscountInput").attr('required',true);
                    $("#maximumDiscountInput").attr('disabled',false);

                    $("#discountPercentageDiv").show();
                    $("#discountPercentageInput").attr('required',true);
                    $("#discountPercentageInput").attr('disabled',false);

                    $("#shippingConditionDiv").hide();
                    $("#shippingConditionSelect").attr('required',false);
                    $("#shippingConditionSelect").attr('disabled',true);

                    break;
                case '2':

                    $("#minimumQuantityDiv").hide();
                    $("#minimumQuantityInput").attr('required',false);
                    $("#minimumQuantityInput").attr('disabled',true);

                    $("#minimumSpendDiv").show();
                    $("#minimumSpendInput").attr('required',true);
                    $("#minimumSpendInput").attr('disabled',false);

                    $("#maximumDiscountDiv").show();
                    $("#maximumDiscountInput").attr('required',true);
                    $("#maximumDiscountInput").attr('disabled',false);

                    $("#discountPercentageDiv").show();
                    $("#discountPercentageInput").attr('required',true);
                    $("#discountPercentageInput").attr('disabled',false);

                    $("#shippingConditionDiv").hide();
                    $("#shippingConditionSelect").attr('required',false);
                    $("#shippingConditionSelect").attr('disabled',true);
                    break;


                case '3':
                    $("#minimumQuantityDiv").hide();
                    $("#minimumQuantityInput").attr('required',false);
                    $("#minimumQuantityInput").attr('disabled',true);

                    $("#minimumSpendDiv").hide();
                    $("#minimumSpendInput").attr('required',false);
                    $("#minimumSpendInput").attr('disabled',true);

                    $("#maximumDiscountDiv").hide();
                    $("#maximumDiscountInput").attr('required',false);
                    $("#maximumDiscountInput").attr('disabled',true);

                    $("#discountPercentageDiv").hide();
                    $("#discountPercentageInput").attr('required',false);
                    $("#discountPercentageInput").attr('disabled',true);

                    $("#shippingConditionDiv").show();
                    $("#shippingConditionSelect").attr('required',true);
                    $("#shippingConditionSelect").attr('disabled',false);

                    show_hide_minimum_field($("#shippingConditionSelect").val());

                    break;

                default:

                    $("#minimumQuantityDiv").hide();
                    $("#minimumQuantityInput").attr('required',false);
                    $("#minimumQuantityInput").attr('disabled',true);

                    $("#minimumSpendDiv").hide();
                    $("#minimumSpendInput").attr('required',false);
                    $("#minimumSpendInput").attr('disabled',true);

                    $("#maximumDiscountDiv").hide();
                    $("#maximumDiscountInput").attr('required',false);
                    $("#maximumDiscountInput").attr('disabled',true);

                    $("#discountPercentageDiv").hide();
                    $("#discountPercentageInput").attr('required',false);
                    $("#discountPercentageInput").attr('disabled',true);

                    $("#shippingConditionDiv").hide();
                    $("#shippingConditionSelect").attr('required',false);
                    $("#shippingConditionSelect").attr('disabled',true);

                    break;

            }
        }

        function show_hide_minimum_field(condition) {
            if (condition == 1) {

                $("#minimumQuantityDiv").hide();
                $("#minimumQuantityInput").attr('required',false);
                $("#minimumQuantityInput").attr('disabled',true);

                $("#minimumSpendDiv").hide();
                $("#minimumSpendInput").attr('required',false);
                $("#minimumSpendInput").attr('disabled',true);

            }else if(condition == 2){

                $("#minimumQuantityDiv").hide();
                $("#minimumQuantityInput").attr('required',false);
                $("#minimumQuantityInput").attr('disabled',true);

                $("#minimumSpendDiv").show();
                $("#minimumSpendInput").attr('required',true);
                $("#minimumSpendInput").attr('disabled',false);

            }else if(condition == 3){

                $("#minimumQuantityDiv").show();
                $("#minimumQuantityInput").attr('required',true);
                $("#minimumQuantityInput").attr('disabled',false);

                $("#minimumSpendDiv").hide();
                $("#minimumSpendInput").attr('required',false);
                $("#minimumSpendInput").attr('disabled',true);

            }
        }

        (function ($) {

            $(".select2").select2({
                "width" : "100%",
                placeholder: "Select Discount On First"
            });

        })(jQuery);
    </script>
    <script>
        $("#startDate").datepicker({
            startDate:"today",
            autoclose:true,
            format:"yyyy-mm-dd"
        });

        if ($("#discountCouponId").val() != '') {
            $("#endDate").datepicker({
                startDate: $("#startDate").val(),
                autoclose:true,
                format:"yyyy-mm-dd"
            });        
        }
        $("#startDate").change(function(){

            if($('#endDate').val() < $(this).val()){
                $("#endDate").val('');
            }
            
            $("#endDate").datepicker('destroy').datepicker({
                startDate: $(this).val(),
                autoclose:true,
                format:"yyyy-mm-dd"
            });
        });

        $("#discountOn").change(function(){
            var discount_on = $(this).val();


            if (discount_on != null && discount_on != 3 && discount_on != 4) {

                $("#discountSelect").show();
                $("#discountItems").attr('required', true);
                $("#discountItems").attr('disabled', false);

                get_discount_on_items(discount_on);

            }else{

                $("#discountSelect").hide();
                $("#discountItems").attr('required', false);
                $("#discountItems").attr('disabled', true);
            }
        });

        if ($("#discountOn").val() != null && $("#discountOn").val() != 3 && $("#discountOn").val() != 4) {

            $("#discountSelect").show();
            $("#discountItems").attr('required', true);
            $("#discountItems").attr('disabled', false);

            get_discount_on_items($("#discountOn").val());

        }else{

            $("#discountSelect").hide();
            $("#discountItems").attr('required', false);
            $("#discountItems").attr('disabled', true);
        }
        

        function get_discount_on_items(discount_on){
            
            // alert(ordered_product_select_id);
            // return ;

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.offers.get-discount-on-items') }}",
                data: {

                    "_token" : '{{ csrf_token() }}',
                    type : discount_on,
                    offer_id : '{{ request()->routeIs('admin.offers.edit') ? base64_encode($offer->id) : 0 }}'

                },
                beforeSend: function(){                

                    $('#modal-loader').show();
                    $("#discountItems").html('');

                },
                complete : function($response, $status){
                    
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);
                        $("#discountItems").html(obj.items);
                        $("#discountItems").multiSelect('refresh');
                    }
                }
            });
        }
    </script>
@endpush
