@extends('layouts.app')
@section('title', 'Order Failed')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Checkout Failed
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>Checkout Success</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="checkout-wrapper pt40 pb40">


            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <div class="checkout-message">
                        <img src="./cancel.png" alt="" class="checkout-image">

                        <h3 class="text-center"><strong>Looks like you have cancelled your order.</strong></h3>
                        <h6 class="text-center">Thank you for shopping with Jashn. Please feel free to look around some
                            more. </h6>
                        <p class="text-center">
                            <a href="javascript:void(0);" class="main-button colored"><i
                                    class="fa fa-chevron-lefts"></i><span class="add-to-cart-btn-text">Continue
                                    Shopping</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection