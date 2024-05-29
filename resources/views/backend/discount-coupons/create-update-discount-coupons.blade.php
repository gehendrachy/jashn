@extends('backend.layouts.app')
@section('title', 'Discount Coupons')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> --}}
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
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
                            <h5>Discount Coupons</h5>
                            <span>Create, Update, Delete Discount Coupons</span>
                        </div>
                    </div>
                    {{-- <a href="{{ route('admin.discount-coupons.create') }}" class="btn btn-primary btn-sm"> <i class="ik ik-plus"></i> Add New </a> --}}
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.discount-coupons.index') }}">Discount Coupons</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ request()->routeIs('admin.discount-coupons.edit') ? 'Update' : 'Create New' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <form method="POST" action="{{ request()->routeIs('admin.discount-coupons.edit') ? route('admin.discount-coupons.update', $discount_coupon) : route('admin.discount-coupons.store') }}" enctype="multipart/form-data">
                    
                    @csrf

                    @if(request()->routeIs('admin.discount-coupons.edit'))
                        @method('PUT')
                    @endif
                    <div class="card border border-secondary">
                        <div class="card-header bg-default ">
                            <h3>{{ request()->routeIs('admin.discount-coupons.edit') ? 'Update Discount Coupon' : 'Create New Discount Coupon' }}</h3>
                        </div>
                        <div class="card-body" id="Discount Coupons">
                            {{-- <h4 class="sub-title">color Addons</h4> --}}

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-type"></i>&nbsp; Coupon Name</label>
                                        </span>
                                        <input name="name" type="text" class="form-control" placeholder="eg: Dashain Offer" required value="{{ old('name') ? old('name') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->name : '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-slack"></i>&nbsp; Code</label>
                                        </span>
                                        <input name="code" type="text" class="form-control" placeholder="eg: JASHN2078" required value="{{ old('code') ? old('code') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->code : '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text">
                                                <i class="ik ik-info"></i>&nbsp; Discount Type
                                            </label>
                                        </span>
                                        @php
                                            $discount_type = old('discount_type') ? old('discount_type') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->discount_type : '')
                                        @endphp
                                        <select id="discountType" class="form-control" name="discount_type" required>
                                            <option value="2" {{ $discount_type == 2 ? 'selected' : '' }}>Any Purchase</option>
                                            <option value="1" {{ $discount_type == 1 ? 'selected' : '' }}>First Purchase</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="couponUsageInput">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text">
                                                <i class="ik ik-info"></i>&nbsp; Coupon Usage
                                            </label>
                                        </span>
                                        <input id="couponUsageCount" class="form-control" type="number" name="coupon_usage" placeholder="eg: 2, 3" min="2" value="{{ old('coupon_usage') ? old('coupon_usage') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->coupon_usage : '' ) }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-sm-6" id="discountPercentageDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-percent"></i>&nbsp; Discount Percentage</label>
                                        </span>
                                        <input name="discount_percentage" type="text" id="discountPercentageInput" class="form-control discount-coupon-input" placeholder="Discount Percentage, eg: 20" value="{{ old('discount_percentage') ? old('discount_percentage') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->discount_percentage : '') }}" required>
                                        <span class="input-group-append">
                                            <label class="input-group-text"><i class="ik ik-percent"></i></label>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="minimumQuantityDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-shopping-cart"></i>&nbsp;Minimum Order Quantity</label>
                                        </span>
                                        <input name="minimum_quantity" type="number" id="minimumQuantityInput" class="form-control discount-coupon-input" placeholder="Minimum Product Quantity, eg: 10, 20" value="{{ old('minimum_quantity') ? old('minimum_quantity') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->minimum_quantity : '') }}" min="0">
                                    </div>
                                </div>

                                <div class="col-sm-6" id="minimumSpendDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-dollar-sign"></i>&nbsp; Minimum Spend</label>
                                        </span>
                                        <input name="minimum_spend" type="number" id="minimumSpendInput" class="form-control discount-coupon-input" placeholder="Minimum Amount Spend, eg: 10000, 20000" value="{{ old('minimum_spend') ? old('minimum_spend') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->minimum_spend : '') }}" min="0">
                                    </div>
                                </div>

                                <div class="col-sm-6" id="maximumDiscountDiv">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-dollar-sign"></i>&nbsp; Maximum Discount</label>
                                        </span>
                                        <input name="maximum_discount" type="number" id="maximumDiscountInput" class="form-control discount-coupon-input" placeholder="Maximum Discount Amount, eg: 2000" required value="{{ old('maximum_discount') ? old('maximum_discount') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->maximum_discount : '') }}">
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-calendar"></i>&nbsp; Start Date Time</label>
                                        </span>
                                          <input type="text" class="form-control" value="{{ old('start_date') ? old('start_date') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->start_date : '')  }}" name="start_date" placeholder="Start Date" required id="startDate" />

                                        {{-- <input type="time" class="form-control" value="{{ old('start_time') ? old('start_time') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->start_time : '')  }}" name="start_time" /> --}}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <label class="input-group-text"><i class="ik ik-calendar"></i>&nbsp; End Date Time</label>
                                        </span>
                                        <input type="text" class="form-control" value="{{ old('expire_date') ? old('expire_date') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->expire_date : '')  }}" name="expire_date" placeholder="End Date" required id="endDate" />

                                        {{-- <input type="time" class="form-control" value="{{ old('expire_time') ? old('expire_time') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->expire_time : '')  }}" name="expire_time" required /> --}}
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
                                                $discount_on = old('discount_on') ? old('discount_on') : (request()->routeIs('admin.discount-coupons.edit') ? $discount_coupon->discount_on : '')
                                            @endphp
                                            <option value="3" {{ $discount_on == 3 ? 'selected' : '' }}>All Products</option>
                                            <option value="1" {{ $discount_on == 1 ? 'selected' : '' }}>Selected Categories</option>
                                            <option value="2" {{ $discount_on == 2 ? 'selected' : '' }}>Selected Products</option>
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
                                    <a href="{{ route('admin.discount-coupons.index') }}" class="btn btn-danger">Cancel</a>
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
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script> --}}
    <!-- bootstrap datepicker -->
    <script src="{{ asset('backend/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/quicksearch-master/jquery.quicksearch.js') }}"></script>
    <script src="{{ asset('backend/plugins/multiselect/js/jquery.multi-select.js') }}"></script>

    <!--  datatable script-->
    <script>

        $("#discountType").change(function(){

            var discount_type = $(this).val();

            if(discount_type == 1){

                $("#couponUsageInput").hide();
                $("#couponUsageCount").attr('required', false);
                $("#couponUsageCount").attr('disabled', true);

            }else{

                $("#couponUsageInput").show();
                $("#couponUsageCount").attr('required', true);
                $("#couponUsageCount").attr('disabled', false);
            }
        });

        if($("#discountType").val() == 1){

            $("#couponUsageInput").hide();
            $("#couponUsageCount").attr('required', false);
            $("#couponUsageCount").attr('disabled', true);

        }else{

            $("#couponUsageInput").show();
            $("#couponUsageCount").attr('required', true);
            $("#couponUsageCount").attr('disabled', false);
        }

        $("#discountOn").change(function(){
            var discount_on = $(this).val();


            if (discount_on != null && discount_on != 3) {

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

        if ($("#discountOn").val() != null && $("#discountOn").val() != 3) {

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
                url: "{{ route('admin.discount-coupons.get-discount-on-items') }}",
                data: {
                    "_token" : '{{ csrf_token() }}',
                    type : discount_on,
                    discount_coupon_id : '{{ request()->routeIs('admin.discount-coupons.edit') ? base64_encode($discount_coupon->id) : 0 }}'
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

        // if ($("#couponUsage").val() == 2) {

        //     $("#couponUsageCount").attr('disabled', false);
        //     $("#couponUsageCount").attr('required', true);
        //     $("#couponUsageCount").show();
        // }else{
            
        //     $("#couponUsageCount").attr('disabled', true);
        //     $("#couponUsageCount").attr('required', false);
        //     $("#couponUsageCount").hide();
        // }

        // $("#couponUsage").change(function(){
        //     if ($(this).val() == 2) {

        //         $("#couponUsageCount").attr('disabled', false);
        //         $("#couponUsageCount").attr('required', true);
        //         $("#couponUsageCount").show();
        //     }else{

        //         $("#couponUsageCount").attr('disabled', true);
        //         $("#couponUsageCount").attr('required', false);
        //         $("#couponUsageCount").hide();
        //     }
        // });

        $(function () {
            // $("#discountItems").multiSelect();
            $('#discountItems').multiSelect({
                keepOrder: true,
                selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search Items to Select'>",
                selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search Items to Remove'>",
                afterInit: function(ms){
                    var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){
                        if (e.which == 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
        });
    </script>
@endpush
