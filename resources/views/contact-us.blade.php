@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
	<div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Contact Us
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="#">Home /</a></li>
                            <li>Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="pt40 pb20">
        <div class="container">
            <div class="contact-us">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact">
                            <h4 class="text-uppercase"><strong>Send Us A Message</strong></h4>
                            <hr>
                            <form action="">
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fname">
                                                <strong>Full Name:</strong>
                                            </label>
                                            <div class="col-sm-12">
                                            	<input type="text" class="w-100 mb-3 pl-5 form-control" name="name" id="" placeholder="eg: John Doe">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">
                                                <strong>Your Number:</strong>
                                            </label>
                                            <div class="col-sm-12">
                                            	<input type="text" class="w-100 mb-3 pl-5 form-control" name="name" id="" placeholder="+977-9800000000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">
                                                <strong>Your Email:</strong>
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="email" class="w-100 mb-3 pl-5 form-control" name="email" id="" placeholder="email@jashn.com">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <strong>What kind of help you need</strong>
                                            <section class="light">
                                                <label>
                                                    <input type="radio" name="light" checked>
                                                    <span class="design"></span>
                                                    <span class="text">Order</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="light">
                                                    <span class="design"></span>
                                                    <span class="text">Payment</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="light">
                                                    <span class="design"></span>
                                                    <span class="text">Return & Refund</span>
                                                </label>
                                            </section>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div>
                                            <label for="name">
                                                <strong>Message:</strong>
                                            </label>
                                        </div>
                                        <textarea class="w-100 form-control" cols="30" rows="5"></textarea>
                                        <br>
                                    </div>
                                    <br>
                                    <button type="button" class="main-button colored">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 contact-info pt64 pb64" style="color: black;">
                        <div class="contact">
                            <div>
                                <h4 class="text-uppercase" data-sal="slide-up" data-sal-easing="easeInOutCubic" style="--sal-duration: 0.6s;"><strong>Contact Information</strong></h4>
                                <p data-sal="slide-up" data-sal-easing="easeInOutCubic" style="--sal-duration: 0.6s;">
                                    Let us know what you're looking for. We'll take a look and see if this could be the start of something beautiful. Please get in touch and let’s schedule time to talk!</p>
                            </div>

                            <ul class="footer-link">
                                <li>
                                	<a href="tel:{{ preg_replace("/[^0-9,+]/", "", $setting->phone)}}">
                                		<i class="fa fa-phone-alt"></i> {{ $setting->phone }}
                                	</a>
                                </li>
                                <li>
                                	<a href="mailto:{{ $setting->email }}">
                                		<i class="fa fa-envelope"></i> {{ $setting->email }}
                                	</a>
                                </li>
                                <li>
                                	<a href="javascript:void(0);">
                                		<i class="fa fa-map-marker"></i> {{ $setting->address }}
                                	</a>
                                </li>
                                <li>
                                	<a target="_blank" href="viber://chat?number={{ preg_replace("/[^0-9]/", "", $setting->mobile_viber)}}">
                                		<i class="fab fa-viber"></i>{{ $setting->mobile_viber }}
                                	</a>
                                </li>
                                <li>
                                	<a target="_blank" href="#" class="whatsappLink">
                                		<i class="fab fa-whatsapp"></i>{{ $setting->mobile_whatsapp }}
                                	</a>
                                </li>
                            </ul>
                            <div>
                                <br>
                                <ul class="social_share">
                                    <li><a class="facebook" href="{{ $setting->facebookurl }}"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a class="twitter" href="{{ $setting->twitterurl }}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a style="background: #d62977;" class="instagram" href="{{ $setting->instagramurl }}"><i class="fab fa-instagram"></i></a></li>
                                    <li><a style="background: #ff0000;" class="youtube" href="{{ $setting->youtubeurl }}"><i class="fab fa-youtube"></i></a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <iframe src="{{ $setting->googlemapurl }}" width="100%" height="450" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="container-fluid">
        <div class="map-section">

        </div>
    </div>
@endsection