@extends('layouts.app')
@section('title', "My Account")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        My Account
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Account Information</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-wrapper pt40 pb40">
            <div class="row">
                @include('customer-sidebar')
                <div class="col-sm-9">
                    <div class="dashboard-righs-sidebar">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="reward-point-feature">
                                    <h6>Hello, {{ Auth::user()->name }}</h6>
                                    <h6>Welcome to Jashn! </h6>
                                    <p>
                                        This is your user account dashboard. This is where you can keep track of all your
                                        orders, thier delivery status, your wishlist and profile information. You can
                                        also update your password, change profile information from your username to
                                        billing & shipping details.
                                        <br><br>
                                        Please check the lefthand side of the screen for the tabs that will get you to all your account information.
                                        <br><br>
                                        Thankyou and enjoy shopping with Jashn.
                                    </p>
                                    <hr>
                                    <h6>
                                        <em>Currently you have <span class="red"><strong>275</strong></span> loyalty points left.</em>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('post-scripts')
    <script>

        
    </script>
@endpush