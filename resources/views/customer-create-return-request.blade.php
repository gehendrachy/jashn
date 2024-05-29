@extends('layouts.app')
@section('title', "Request for Return")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Request for Return
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Request for Return</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pb40">
        <div class="container">
            <div class="return">
                <form action="{{ route('customer.post-return-request') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="">
                                <h5 class="roboto">Returning Order Information</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="o-num">Order Number:</label>
                                        <select id="orderSelect" name="order_id" class="w-100 mb-3 pl-5 form-control">
                                            <option selected disabled>Select Order</option>
                                            @foreach($orders as $order)
                                                <option value="{{ $order->id }}">#{{ $order->order_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <di class="row">
                                    <div class="col-md-12">
                                        <div class="reward-point-feature">
                                            <p class="table-message">
                                                <small>Please scroll horizontally on table to view full table</small></p>
                                            <div class="table-wrapper">
                                                <table id="check-out">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Product</th>
                                                            <th>Unit Price</th>
                                                            <th>Quantity</th>
                                                            <th>Reason</th>
                                                            <th>Upload Image</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="orderedProducts">
                                                        <tr>
                                                            <td colspan="6" class="text-center">Please Select Order Number</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p class="table-message"><small>Please scroll horizontally on table to view full
                                                    table</small></p>
                                        </div>
                                    </div>
                                </di>
                            </div>
                        </div>
                    </div>
                    <div id="submitBtn" class="text-center" style="display: none;">
                        <br>
                        <input type="submit" class="main-button colored" value="Request Return">
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('post-scripts')
    <script>
        $("#orderSelect").change(function(){
            var order_id = $(this).val();
            get_related_ordered_products(order_id);
            $("#submitBtn").show();
        });

        function get_related_ordered_products(order_id) {

            $.ajax({
                url : "{{ URL::route('customer.get-related-ordered-products') }}",
                type : "POST",
                data : { '_token': '{{ csrf_token() }}',
                            order_id: order_id
                        },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                    $('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);
                        $("#orderedProducts").html(obj.ordered_products);

                        $(".ordered-product-checkbox").click(function(){
                            call_ajax_function(this);
                        });
                    }
                }
            });
        }

        function call_ajax_function(that) {
            var key = $(that).val();
            if (that.checked) {

                $(".ordered-product-"+key).attr('disabled', false);
                $(".ordered-product-"+key).attr('required', true);
                
            }else{
                $(".ordered-product-"+key).attr('disabled', true);
                $(".ordered-product-"+key).attr('required', false);
            }

        }
        
    </script>
@endpush