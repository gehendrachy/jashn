@extends('layouts.app')
@section('title', 'Checkout Confirmation')
@section('content')

    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        CheckOut Review
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Checkout Confirmation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="checkout-wrapper pt40 pb40">
            <form action="https://beta.shopatjashn.com/place-order" method="POST">
                <input type="hidden" name="_token" value="dzdjDT6L8WgjKrNjjaQwpChXdxQjk4hqUu0HJpfK">
                <div class="row">
                    <div class="col-sm-8">

                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Shipping Address</strong> <small>(Default)</small></p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['shipping']['name'] }}</strong> -
                                                        @if($details['shipping']['pan'] !== null)<strong>{{ $details['shipping']['pan'] }}</strong><small>(Pan Number)</small>@endif</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['shipping']['phone'] }}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['shipping']['email'] }}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['shipping']['street_address_1'] }}
                                                            Kathmandu,
                                                            Bagmati, Nepal</strong></span>
                                                </p>
                                                <br>
                                            </div>
                                            <!-- <p><small><i>Biiling Address is same as shipping address.</i></small></p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="address-information">
                            <div class="address-box" id="ship-address-box">
                                <div class="address-box-title">
                                    <p><strong>Billing Address</strong></p>
                                </div>
                                <div class="address-detail-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['billing']['name'] }}</strong> -
                                                        @if($details['billing']['pan'] !== null)<strong>{{ $details['billing']['pan'] }}</strong><small>(Pan Number)</small>@endif</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['billing']['phone'] }}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['billing']['email'] }}</strong></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="info-detail">
                                                    <span class="d-block"><strong>{{ $details['billing']['street_address_1'] }}
                                                            Kathmandu,
                                                            Bagmati, Nepal</strong></span>
                                                </p>
                                                <br>
                                            </div>
                                            <!-- <p><small><i>Biiling Address is same as billing address.</i></small></p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <p class="mb-0"><strong>Cart Review</strong></p>
                        <div class="table-wrapper">
                            <table id="check-out">
                                <tbody>
                                    <tr>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>MRP</th>
                                        <th>Offer Price</th>
                                        <th>Total</th>
                                        <th>Order Date</th>
                                    </tr>
                                    <tr class="cart-item-46">
                                        <td>
                                            <div class="list">

                                                <div class="detail">
                                                    <p><a
                                                            href="https://beta.shopatjashn.com/product/beautiful-soft-banarasi-saree-with-gold-zari-weaving-work?c=%23ffe5b4">Beautiful
                                                            Soft Banarasi Saree with Gold Zari weaving work</a></p>
                                                    <p>SGVKAS007</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mx-auto">

                                                <p>5.5/0.80 MTRS</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mrp">
                                                <p>
                                                    4
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mrp">
                                                <p>
                                                    Nrs.
                                                    <span class="price-0">

                                                        4000
                                                    </span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="offer-price">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="total-price">
                                                <p>
                                                    Nrs.
                                                    <span class="sub-total-0">
                                                        4000
                                                    </span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="order-date">
                                                <p>7th Apr, 2022</p>
                                            </div>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="checkout-cart">
                            <h6>Cart Details</h6>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <p>Cart Total</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Nrs. {{ $cart_total }}</strong></p>
                                </div>

                                <div class="col-6">
                                    <p>Offer</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>- Nrs. {{ $cart_total_offer_price }}</strong></p>
                                </div>


                                <div class="col-6 coupon-details" style="display: none">
                                    <p id="couponTitle"></p>
                                </div>
                                <div class="col-6 coupon-details" style="display: none">
                                    <p><strong>- Nrs. <span id="discountAmount">0</span></strong></p>
                                    <input type="hidden" id="discountAmount" value="0">
                                </div>

                                <input type="hidden" id="totalWeight" value="0.7">

                                <div class="col-6">
                                    <p>Shipping Cost</p>
                                </div>
                                <div class="col-6">
                                    <input type="hidden" id="totalbillingCost" value="0">
                                    <p>+ <strong>Nrs. <span id="billingCost">{{ $shipping_cost }}</span><small>(0.7 Kg)</small></strong>
                                    </p>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <p>Grand Total</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Nrs. <span id="totalPrice">{{ $cart_total + $shipping_cost }}</span></strong></p>
                                </div>
                                <div class="col-12 form-inline">
                                    <input id="couponCode" class="input-text"  placeholder="Coupon code" type="text">
                                    <input id="applyCoupon" class="main-button colored"  value="Apply coupon" type="button">
                                </div>
                            </div>
                        </div>
                        <div class="checkout-left">
                            <h6>Payment Options</h6>
                            <hr>
                            <div class="col-sm-12" id="cashOnDelivery">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="cash-input" value="1" checked>
                                    <label for="cash-input">Cash On Delivery</label>
                                </div>
                                <div class="cash-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="esewa" value="2" disabled>
                                    <label for="esewa">Pay Via Esewa <small>(coming soon)</small></label>
                                </div>
                                <div class="esewa-show pay-details">
                                    <img src="./images/qr-code.png" alt="" class="qr-code img-fluid">
                                    <p>Upload the Screenshot after scanning the code.</p>
                                    <input type="file">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="fone" value="3" disabled>
                                    <label for="fone">Fone Pay <small>(coming soon)</small></label>
                                </div>
                                <div class="fone-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="payment-radio">
                                    <input type="radio" name="payment_method" id="card" value="4" disabled="">
                                    <label for="card">Pay Using Credit Card <small>(coming soon)</small></label>
                                </div>
                                <div class="card-show pay-details">
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus itaque
                                        cupiditate excepturi!</p>
                                </div>
                            </div>
                            <hr>
                            <button id="placeOrder" type="submit" class="main-button colored">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <section>
        <div id="toogle">
            <h3>See more about Jashn</h3>
            <i class="fa fa-chevron-down arrow" style="padding: 8px;"></i>
        </div>
    </section>
@endsection
@push('post-scripts')
<script>
    $('#applyCoupon').click(function (e) {
            e.preventDefault();

            if ($("#couponCode").val() == '') {
                toastr['error']('Please enter valid Coupon Code!');
                return;
            }

            $.ajax({
                url : "{{ URL::route('apply-coupon') }}",
                type: "POST",
                data: {
                        '_token' : '{{ csrf_token() }}',
                        code : $("#couponCode").val(),
                        shipping_cost : $("#totalShippingCost").val(),
                        action: 'apply_coupon'
                    },
                beforeSend: function () {
                    $('#modal-loader').show();
                },
                success: function (response) {
                    $('#modal-loader').hide();
                    console.log("success");
                    console.log("response " + response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.status == 'calculated') {   

                        toastr['success']('Coupon Code Applied Successfully!');

                        $('#couponTitle').html(obj.title);
                        $('#discountAmount').html(obj.discount_amount);
                        $('#totalPrice').html(obj.total_price);
                        $(".coupon-details").show();
                        $("#couponCode").prop('disabled', 'true');
                        $("#applyCoupon").prop('disabled', 'true');
                        
                    }else if(obj.status == 'invalid_date'){

                        toastr['error']('Coupon is already expired!');
                    }else if(obj.status == 'invalid_code'){
                        
                        toastr['error']('Invalid Coupon Code');
                    }else if(obj.status == 'already_used'){
                        
                        toastr['error']('Coupon Already Used!');
                    }else if(obj.status == 'no_coupons'){
                        
                        toastr['error']('Sorry! All the Coupons have been Used up!');
                    }else if(obj.status == 'auth_failed'){
                        
                        toastr['error']('Please Login to Apply Coupon!');
                    }else if(obj.status == 'applied_maximum'){
                        
                        toastr['error']('You have applied this Coupon code to maximum limit!');
                    }else if(obj.status == 'first_invalid'){
                        
                        toastr['error']('You are not eligible for this Coupon!');
                    }else if(obj.status == 'min_spend_invalid'){
   
                        toastr['error']('Please Spend upto Nrs.'+obj.min_spend +' to apply this code!');
                    }else if(obj.status == 'min_quantity_invalid'){
   
                        toastr['error']('You must buy '+obj.min_quantity +' items in total to apply this code!');
                    };
                }
            });

        });
</script>
@endpush