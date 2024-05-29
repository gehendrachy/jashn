@extends('layouts.app')
@section('title', $product->title)
@push('meta')
    <meta name="title" content="{{ $setting->meta_title }} -  {{ $product->title }}">
    <meta name="description" content="{!! $product->description !!}">
    
    <meta property="og:title" content="{{ $setting->og_title }} -  {{ $product->title }}">
    <meta property="og:description" content="{!! $product->description !!}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/medium_'.$product_variation_colors[0]->image) }}">
    <meta property="product:brand" content="{{ $product->category->title }}">
    <meta property="category" content="{{ $product->category->title }}" />
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="{{ $product->product_sizes[0]->price }}">
    <meta property="product:price:currency" content="NPR">
    <meta property="product:retailer_item_id" content="{{ $product->title }}_{{ $product->id }}">
    <meta property="product:item_group_id" content="{{ $product->title }}_{{ $product->id }}">
@endpush

@push('post-css')
	<link rel="stylesheet" href="{{ asset('frontend/css/star-rating-svg.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
        integrity="sha256-Vzbj7sDDS/woiFS3uNKo8eIuni59rjyNGtXfstRzStA=" crossorigin="anonymous" />
	<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=609135b118d187001189ef3b&product=inline-share-buttons" async="async"></script>
	<style>
        .tabs_item img {
            width: 40px;
            float: none;
            margin-right: 24px;
        }

        .review-box {
            padding: 16px 32px;
            border: 1px solid #eaeaea;
            margin-bottom: 15px;
        }

        .review-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 12px;
        }

        .review-header .review-names p {
            font-size: 18px;
            margin-bottom: 0;
            font-weight: 600;
        }

        .review-description p {
            font-weight: 400;
            font-size: 15px;
            margin-bottom: 0;
        }

        .review-form h4 {
            color: #131313;
            font-weight: 600;
        }
    </style>
    <style>
        .product-color li {
            margin-right: 5px;
        }

        .product-color li label {
            padding: 0;
            border: 1px solid #eaeaea;
            width: 35px;
            height: 35px;
        }

        .product-color li label.selected {
            border: 1px solid #000;
        }

        .product-color li label img {
            height: 32px;
            width: auto;
            margin: 0 auto;
            display: block;
        }

        .gallery-item-active {
            border: 2px solid #000;
        }
    </style>
@endpush




@section('content')
	<main>
	    <div class="page-title pt32 pb32 bg-light">
	        <div class="container">
	            <div class="row">
	                <div class="col-lg-8">
	                    <h3 class="page-title-head">
	                        {{ $product->title }}
	                    </h3>
	                    <div class="page-list">
	                        <ul class="breadcrumb">
	                            <li><a href="{{ route('home') }}">Home /</a></li>
	                            <li><a href="{{ route('category-products',['slug' => $product->category->slug]) }}">{{ $product->category->title }} /</a></li>
	                            {{-- <li><a href="#">Sub-Category /</a></li> --}}
	                            <li>{{ $product->title }}</li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="single-product-wrapper pt40">
	        <div class="container">
	            <div class="row align-itmes-center">
	                <div class="col-md-6 col-lg-4" style="position:relative">

	                	<div class="main-image">
	                	    <a data-fancybox="gallery" href="{{ asset('storage/products/'.$product->slug.'/'.$product->image) }}">
	                	        <img src="{{ asset('storage/products/'.$product->slug.'/thumbs/small_'.$product->image) }}" class="img-fluid" alt="{{ $product->slug }}">
	                	    </a>
	                	</div>

	                	{{-- <span class="discount">20%</span> --}}
	                	<div class="swiper-container swiper-gallery">
                            <div class="swiper-wrapper">
                                
                                <!--<div class="swiper-slide gallery-item " data-color-id="0"-->
                                <!--    data-linkSrc="{{ asset('storage/products/'.$product->slug.'/'.$product->image) }}"-->
                                <!--    data-imageSource="{{ asset('storage/products/'.$product->slug.'/thumbs/small_'.$product->image) }}">-->

                                <!--    <img src="{{ asset('storage/products/'.$product->slug.'/thumbs/thumb_'.$product->image) }}"-->
                                <!--        class="img-fluid" alt="{{ $product->slug }}">-->

                                <!--</div>-->
                                
                                @php
                                    $images = Storage::files('public/products/' . $product->slug . '/');
                                @endphp
                                @for ($i = 0; $i < count($images); $i++)
                                    @if (strpos($images[$i], $product->image) != true)
                                        <div class="swiper-slide gallery-item"
                                            data-linkSrc="{{ asset('storage/') .str_replace('public/products/' . $product->slug . '/','/products/' . $product->slug . '/thumbs/thumb_',$images[$i]) }}"
                                            data-imageSource="{{ asset('storage/') .str_replace('public/products/' . $product->slug . '/','/products/' . $product->slug . '/thumbs/medium_',$images[$i]) }}">
                    
                                            <img src="{{ asset('storage/') .str_replace('public/products/' . $product->slug . '/','/products/' . $product->slug . '/thumbs/thumb_',$images[$i]) }}"
                                                class="img-fluid" alt="{{ $product->slug }}">
                                        </div>
                                    @endif
                                @endfor

                                @foreach($product_variation_colors as $color_key => $product_variation_color)

                                	<div class="swiper-slide gallery-item" data-color-id="{{ $product_variation_color->id }}"
                                	    data-linkSrc="{{ asset('storage/products/'.$product->slug.'/variations/'.$product_variation_color->image) }}"
                                	    data-imageSource="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/small_'.$product_variation_color->image) }}">

                                	    <img src="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/thumb_'.$product_variation_color->image) }}" class="img-fluid" alt="{{ $product->slug }}">

                                	</div>

                                @endforeach

                                {{-- @php
	                                $images = Storage::files('public/products/'.$product->slug.'/');
	                            @endphp

	                            @for ($i = 0; $i < count($images); $i++)

	                                @if(strpos($images[$i], $product->image) != true)

	                                <div class="swiper-slide gallery-item " data-color-id="{{ 1000 + $i }}"
	                                    data-linkSrc="{{ asset('storage/products/'.$product->slug.'/'.basename($images[$i])) }}"
	                                    data-imageSource="{{ asset('storage/products/'.$product->slug.'/thumbs/small_'.basename($images[$i])) }}">

	                                    <img src="{{ asset('storage/products/'.$product->slug.'/thumbs/thumb_'.basename($images[$i])) }}" class="img-fluid" alt="{{ $product->slug }}">

	                                </div>
	                                @endif
                                @endfor --}}

                            </div>
                        </div>

	                    
	                    
	                </div>
	                <div class="col-md-6 col-lg-4">
	                    <div class="row">
	                        <div class="col-sm-12">
	                            <h3 class="single-product-title">
	                                {{ $product->title }}
	                                <br>
	                                <!--ADD SKU CODE HERE-->
	                                <!--<small class='sku-title' style="font-size:50%;margin-top:10px;display:inline-block;">-->
	                                <!--   SKU: M11321-->
	                                <!--</small>-->
	                                <span class="stock-status show"></span>
	                                
	                                <span class="preorder show" style="margin:0;float:right;display:inline-block;"></span>
	                            </h3>
	                            
	                            <p class="singple-price" id="priceElement" style="margin-bottom:6px;">
	                               
	                                @if(!isset($product->offer_price))
                                        <del>Nrs.{{ $product->price }}</del>
                                    @endif

                                    <ins>
                                        Nrs.{{ $product->offer_price != NULL || $product->offer_price != 0 ? $product->offer_price : $product->price }}
                                    </ins>
	                            </p>
	                           
	                            <div class="d-flex align-items-center justify-content-between">
    	                            <div class="my-rating" data-rating="{{ $product_reviews->sum('rating') }}"></div>
    	                            <a href="javascript:void(0)" data-product-id="{{ $product->id }}" class="btn-add-to-wishlist"><i class="far fa-heart"></i>&nbsp;&nbsp;Add to Wishlist</a>
    	                        </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <!--<p class="short-description">-->
	                            <!--    {!! $product->highlights !!}-->
	                            <!--</p>-->
	                            @if($product->video_link != '')
		                            <p class="misc">
		                                <a href="{{ $product->video_link }}" data-fancybox class="product-video"><i class="fa fa-play"></i> Watch Video</a>
		                            </p>
	                            @endif
	                        </div>
	                        <hr>
	                        {{-- <div class="col-sm-12">
	                            <h6 class="share-title">Available Coupons</h6>
	                            <ul class="coupons">
	                                <li><label for="couponName1">
	                                        <input type="radio" id="couponName1" name="coupons" class="">
	                                        Coupon name</label></li>
	                                <li><label for="couponName2">
	                                        <input type="radio" id="couponName2" name="coupons" class="">
	                                        Coupon name 1</label></li>
	                                <li><label for="couponName3">
	                                        <input type="radio" id="couponName3" name="coupons" class="">
	                                        Coupon name 2</label></li>
	                                <li><label for="couponName4">
	                                        <input type="radio" id="couponName4" name="coupons" class="">
	                                        Coupon name 3</label></li>
	                            </ul>
	                            <hr>
	                        </div> --}}
	                        <div class="col-sm-12">
	                            <h5 class="share-title">Available Colors</h5>
	                            <ul class="product-color" id="product-color">

	                            	@foreach($product_variation_colors as $color_key => $product_variation_color)
	                            		@php
	                            			$selected = 0;
	                            		@endphp
	                            		@if (isset($_GET['c']))

			                            	@if ($product_variation_color->color->code == $_GET['c']) 
			                            		
			                            		@php 
			                            			$selectedColorId = $product_variation_color->id; 
			                            			$selected = 1;
			                            		@endphp

			                            	@endif

			                           	@else

			                           		@if($color_key == 0)

			                            	    @php 
			                            	    	$selectedColorId = $product_variation_color->id; 
			                            	    	$selected = 1;
			                            	    @endphp

		                            	    @else

		                            	    	@php 
			                            	    	$selected = 0;
			                            	    @endphp

		                            	    @endif
		                            	@endif
		                                <li>
		                                    <label data-product-color-id="{{ $product_variation_color->id }}" for="color{{ $color_key }}" class="{{ $selected == 1 ? 'selected' : '' }}">
		                                        <input type="radio" name="product-color" id="color{{ $color_key }}" {{ $selected == 1 ? 'checked' : '' }} hidden>
		                                        @if($product_variation_color->image)
		                                        <img src="{{ asset('storage/products/'.$product->slug.'/variations/thumbs/thumb_'.$product_variation_color->image) }}" alt="{{ $product->slug }}-{{ $product_variation_color->id }}">
		                                        @endif
		                                    </label>
		                                </li>
	                                @endforeach
	                            </ul>
	                            <p  style="font-size:12px;line-height:1;">*Disclaimer: Slight variation in color may be there because of screen and camera lens.</p>
	                        </div>
	                        <div class="col-sm-12">
	                            <h5 class="share-title">
	                            	Available Sizes 
	                            	@if($size_guide != NULL)
	                            	- <a class="size-guide-button float-right" href="#" data-toggle="modal" data-target="#sizeGuideModal">
	                            		<img src="{{ asset('frontend/images/size-guide.png') }}" alt="size-guide" style="height:24px;" />&nbsp;View Size Guide
	                            	</a> 
	                            	@endif
	                            </h5>
	                            <ul class="product-sizes" id="product-variation-sizes">

	                            	@php
	                            		$product_variation_sizes = $product->product_colors()->where('id', $selectedColorId)->first()->product_sizes;
	                            	@endphp

	                            	@foreach ($product_variation_sizes as $size_key => $product_variation_size) 
	                            		@php

	                            			$max_order_qty = $product_variation_size->quantity > 0 ? $product_variation_size->quantity : $product_variation_size->preorder_stock_limit; ;

	                            		@endphp

	                            		@if ($size_key == 0) 
	                            		    @php 
	                            		    	$selected_max_order_qty = $max_order_qty;
	                            		    @endphp
	                            		@endif
		                            	
		                                <li>
		                                    <label data-product-size-id="{{ $product_variation_size->id }}" data-variation-price="{{ $product_variation_size->price }}" data-variation-offer-price="{{ $product_variation_size->offer_price }}" data-stock-status="{{ $product_variation_size->quantity > 0 ? 1 : 0 }}" data-pre-order-status="{{ $product_variation_size->preorder }}" data-stock-count="{{ $max_order_qty }}" for="size{{ $size_key }}" class="{{ $size_key == 0 ? 'selected' : '' }}">
		                                        <input type="radio" name="product-size" id="size{{ $size_key }}" hidden>
		                                        {{ $product_variation_size->size->name }}
		                                    </label>
		                                </li>
	                                @endforeach
	                            </ul>
	                        </div>
	                        <br>
	                        <div class="col-sm-12">
	                            <div class="product-single-button">
	                               
	                                <div class="num-block skin-5">
	                                    <h5 class="share-title">Quantity: &nbsp;&nbsp;&nbsp;</h5>
	                                    <div class="num-in">
	                                        <span class="minus dis">-</span>
	                                        <input id="ordered-qty" type="text" class="in-num" value="1" readonly="" max="{{ $selected_max_order_qty }}">
	                                        <span class="plus">+</span>
	                                    </div>
	                                </div>
	                                <hr style="background-color:#eaeaea;">
	                                <!--<div class="fabric-type">-->
	                                <!--     <label class="control-label" for="input-billing-name" style="line-height:1">Fabric Type</label>-->
                                 <!--       <input type="text" name="fabricType" id="fabric-type" class="form-control" placeholder="Eg. Cotton, Nylon, etc">-->
	                                <!--</div>-->
	                                <div class="duo-button">
	                                    <a href="javascript:void(0)" id="add-to-cart" data-buy-now="1" data-product-id="{{ $product->id }}" class="main-button lined order"><span class="add-to-cart-btn-text">Buy Now</span></a>
	                                    <a href="javascript:void(0)" id="add-to-cart" data-buy-now="0" data-product-id="{{ $product->id }}" class="main-button colored order-tab"><i class="fa fa-shopping-cart"></i><span class=""> Add to Cart</span></a>
	                                </div>
	                               
	                                
	                                
	                            </div>
	                        </div>
	                	</div>
	                </div>
	                <div class="col-md-12 col-lg-4">
	                	<div class="right-content">
	                			<div class="delivery">
	                				<h5 class="share-title">Share This:</h5>
	                				<div class="sharethis-inline-share-buttons"></div>
	                			</div>

	                			@if(Auth::check())
	                				@if(!Auth::user()->hasRole('customer'))
	                					<div class="d-flex align-items-start justify-content-between delivery">
			                				<div class="d-flex align-items-start ">
			                					<i class="fa fa-user" style="margin-right:8px;"></i>
			                					<span>You are logged in as Admin</span>
			                				</div>
			                			</div>
	                					
	                				@endif

	                				@if($shipping_address != NULL)
	                			
			                			<p><small><strong>Delivery Information</strong></small></p>
			                			<div class="d-flex align-items-start delivery">
			                				<i class="fa fa-map-marker" style="margin-right:8px;"></i> 
			                				{{ $shipping_address->street_address_1 }}, {{ $shipping_address->street_address_2 }}
			                				@php
			                				    $shipping_city = \App\Models\City::where('id', $shipping_address->city_id)->first();

			                				    if ($shipping_city) {
			                				        $shipping_city_name = $shipping_city->name;
			                				    }else{
			                				        $shipping_city_name = $shipping_address->city_name;
			                				    }

			                				    $shipping_district = \App\Models\District::where('id',$shipping_address->district_id)->first();

			                				    if ($shipping_district) {
			                				        $shipping_district_name = $shipping_district->name;
			                				    }else{
			                				        $shipping_district_name = $shipping_address->district_name;
			                				    }

			                				    $shipping_state = \App\Models\State::where('id',$shipping_address->state_id)->first();

			                				    if ($shipping_state) {
			                				        $shipping_state_name = $shipping_state->name;
			                				    }else{
			                				        $shipping_state_name = $shipping_address->state_name;
			                				    }

			                				    $shipping_country = \App\Models\Country::where('id',$shipping_address->country_id)->first();

			                				    if ($shipping_country) {
			                				        $shipping_country_name = $shipping_country->name;
			                				    }else{
			                				        $shipping_country_name = $shipping_address->country_name;
			                				    }

			                				@endphp

			                				{!! isset($shipping_city_name) ? $shipping_city_name : '<span style="color:red;">N-A</span>' !!}<br>
			                				{!! isset($shipping_district_name) ? $shipping_district_name : '<span style="color:red;">N-A</span>' !!},
			                				
			                				{!! isset($shipping_state_name) ? $shipping_state_name : '<span style="color:red;">N-A</span>' !!}
			                				
			                				{{ $shipping_address->pin_code }}<br>
			                				
			                				{!! isset($shipping_country_name) ? $shipping_country_name : '<span style="color:red;">N-A</span>' !!}
			                				
			                			</div>
			                			<div class="d-flex align-items-start justify-content-between delivery">
			                				<div class="d-flex align-items-start ">
			                					<i class="fa fa-truck" style="margin-right:8px;"></i>
			                					<span>Delivery</span>
			                				</div>
			                				<div><strong>
			                				    Nrs. {{ $shipping_charge_per_item }}
			                				    
			                				</strong></div>
			                			</div>

			                			@if($cod_availability == 1)
				                			<div class="d-flex align-items-start justify-content-between delivery">
				                				<div class="d-flex align-items-start ">
				                					<i class="fa fa-coins" style="margin-right:8px;"></i>
				                					<span><strong>Cash On Delivery Available</strong></span>
				                				</div>
				                			</div>
			                			@endif
			                		@else

			                			<div class="d-flex align-items-start justify-content-between delivery">
			                				<div class="d-flex align-items-start ">
			                					<i class="fa fa-coins" style="margin-right:8px;"></i>
			                					<span>Update your profile to view Delivery</span>
			                				</div>
			                			</div>
			                		@endif
	                			
	                			@else
	                			
		                			<div class="d-flex align-items-start justify-content-between delivery">
		                				<div class="d-flex align-items-start ">
		                					<i class="fa fa-coins" style="margin-right:8px;"></i>
		                					<span><a href="{{ route('user.login') }}">Login Profile</a></span>
		                				</div>
		                			</div>
	                			
	                			@endif
	                			<div class="d-flex align-items-start justify-content-between delivery">
	                				<div class="d-flex align-items-start ">
	                					<i class="fa fa-sync" style="margin-right:8px;"></i>
	                					<span><strong>Easy Return Within 3 Days <span class="d-block text-faded" style="opacity:0.75;"><small>Change of Mind not applicable</small></span></strong></span>
	                				</div>
	                			</div>

	                		</div>
	                </div> 
	                
	            </div>
	            <br>
	            <div class="row">
	                <div class="col-sm-12">
	                    <div class="tab">

	                        <ul class="tabs">
	                            <li><a href="#">Highlights</a></li>
	                            <li><a href="#">Description</a></li>
	                            <li><a href="#">Product Care</a></li>
	                            <!--<li><a href="return.html">Request Return</a></li>-->
	                            <li><a href="#">Product Reviews ({{ $product_reviews->count() }})</a></li>
	                        </ul>

	                        <div class="tab_content">
                                <div class="tabs_item">
	                                <h6 class="show-mobile">Highlights</h6>
	                                {!! $product->highlights !!}
	                            </div>
	                            
	                            <div class="tabs_item">
	                                <h6 class="show-mobile">Description</h6>
	                                {!! $product->description !!}
	                            </div> 

	                            <div class="tabs_item">
	                                <h6 class="show-mobile">Product Care</h6>
	                                	@foreach($product_cares as $product_care)
	                                	<div class="card mb-3" style="max-width: 540px; margin-right: 20px;">
	                                		<div class="row no-gutters">
	                                		    @if(isset($product_care->image))
	                                			<div class="col-md-4">
	                                				<img src="{{ asset('storage/product-cares/thumbs/thumb_'.$product_care->image) }}" class="card-img img-fluid" alt="{{ $product_care->title }}">
	                                			</div>
	                                			@endif
	                                			<div class="col-md-8">
	                                				<div class="card-body">
	                                					<h5 class="card-title">{{ $product_care->title }}</h5>
	                                					<p class="card-text">{!! $product_care->description !!}</p>
	                                					{{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
	                                				</div>
	                                			</div>
	                                		</div>
	                                	</div>
	                                	@endforeach
	                            </div>

	                            <div class="tabs_item">
                                    <h6 class="show-mobile">Product Reviews</h6>
                                    <div class="review-wrapper">
                                    	@if($product_reviews->count() > 0)
                                    		@foreach($product_reviews as $prod_review)
                                    			@if($prod_review->customer_id != @Auth::user()->id)


	                                            	<div class="review-box">
	                                            	    <div class="review-header">
	                                            	        {{-- <div class="review-img">
	                                            	            <img src="https://dummyimage.com/100x100/fafafa/aaa" alt="">
	                                            	        </div> --}}
	                                            	        <div class="review-names">
	                                            	            <p>{{ $prod_review->customer->name }}</p>
	                                            	            <div class="my-rating" data-rating="{{ $prod_review->rating }}"></div>
	                                            	        </div>
	                                            	    </div>
	                                            	    <div class="review-description truncate">
	                                            	        <p>{{ $prod_review->review }}</p>
	                                            	    </div>
	                                            	</div>
                                            	@endif
                                        	@endforeach
                                        	{{-- <a href="javascript:void(0)" class="main-button colored"><span class="">Read All Reviews</span></a> --}}
                                        @else
                                        	<p class="text-center">No Reviews Available</p>
                                    	@endif
                                        
                                        <hr>

                                        
                                        @if(Auth::check() && $product->has_ordered_product == 1)

                                        <form action="{{ route('store-product-review') }}" class="review-form" id="form-review" method="POST">
                                        	@csrf
                                        	<input type="hidden" name="product_id" value="{{ $product->id }}">

                                            <h4>Review This Product</h4>
                                            <hr>
                                            {{-- <div class="do-rating"></div> --}}
                                            <select name="rating" class="star-rating" required>
                                                <option {{ isset($customer_product_review) && $customer_product_review->rating == 1 ? 'selected' : '' }} value="1">1</option>
                                                <option {{ isset($customer_product_review) && $customer_product_review->rating == 2 ? 'selected' : '' }} value="2">2</option>
                                                <option {{ isset($customer_product_review) && $customer_product_review->rating == 3 ? 'selected' : '' }} value="3">3</option>
                                                <option {{ isset($customer_product_review) && $customer_product_review->rating == 4 ? 'selected' : '' }} value="4">4</option>
                                                <option {{ isset($customer_product_review) && $customer_product_review->rating == 5 ? 'selected' : '' }} value="5">5</option>
                                            </select>
                                            <br>
                                            <label for=""><strong>Write A Review</strong></label>
                                            <textarea name="review" class="form-control" id="" rows="5">{{ old('review') ? old('review') : (isset($customer_product_review) ? $customer_product_review->review : '') }}</textarea>
                                            <button class="main-button colored">Submit</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>

	                        </div>
	                    </div> 
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="related-product-wrapper pb40">
	        <div class="container">
	            <h3 class="main-title mb16"><span><strong>Related Products</strong></span></h3>
	            <div class="swiper-container related-products-swiper position-relative">
	                <div class="swiper-wrapper">
	                    @foreach ($related_products as $key => $relProduct)
                            @php
                                $relProduct_color_variations = $relProduct->product_colors;
                            @endphp 
                            {{-- <div class="swiper-slide">
                                @foreach ($relProduct_variation_colors as $relProduct_variation_color)
                                <div class="product">
                                    <div class="product-image">
                                        <div class="product-action-buttons">
                                            <a href="javascript:void(0)" class="action-button btn-add-to-wishlist"
                                                data-product-id="{{ $relProduct->id }}">
                                                <i class="fa fa-heart"></i>
                                                <span>Add to Wishlist</span>
                                            </a>
                                            <a href="#" class="action-button">
                                                <i class="fa fa-retweet"></i>
                                                <span>Add to Compare</span>
                                            </a>
                                        </div>
                                        <a href="{{ route('product-details', ['slug' => $relProduct->slug]) }}">
                                        <img src="{{ asset('storage/products/' . $relProduct->slug . '/variations/thumbs/thumb_' . $relProduct_variation_color->image) }}"
                                                        alt="{{ $relProduct->slug }}-{{ $relProduct_variation_color->id }}">
                                                    </a>

                                    </div>
                                    <div class="product-details">
                                        <div class="seen-product-details">
                                            <div>
                                                <p class="product-title">{{ $relProduct->title }}</p>
                                                <p class="product-sub">{{ $relProduct->category->title }}</p>
                                            </div>
                                            <div class="price">
                                                @if ($relProduct->offer_price != null || $relProduct->offer_price != 0)
                                                    <del>Nrs.{{ $relProduct->price }}</del>
                                                @endif
                                                
                                                <ins>
                                                    Nrs.{{ $relProduct->offer_price != null || $relProduct->offer_price != 0? $relProduct->offer_price: $relProduct->price }}
                                                </ins>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div> --}}

                                @foreach($relProduct_color_variations as $key => $product_color)
                                @php
                                    $product_size = $product_color->product_sizes->sortBy('price')->first();
                                    $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
                                    $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');
                                @endphp
                                <div class="swiper-slide">
                                    <div class="product grid-view jQueryEqualHeight">
                                        @if($product_color_quantity_count > 0)
                                            <span class="ribbon3 in-stock">In Stock</span>
                                        @elseif($product_color_preorder_stock_limit_count > 0)
                                            <span class="ribbon3 pre-order">Pre Order</span>
                                        @else
                                            <span class="ribbon3 sold-out">Sold Out</span>
                                        @endif
                                        <div class="product-image">
                                            <div class="product-action-buttons">
                                                <a href="javascript:void(0);" class="action-button btn-add-to-wishlist" data-product-id="{{ $product_color->product->id }}">
                                                    <i class="fa fa-heart"></i>
                                                    <span>Add to Wishlist</span>
                                                </a>
                                                <a href="javascript:void(0);" class="action-button">
                                                    <i class="fa fa-retweet"></i>
                                                    <span>Add to Compare</span>
                                                </a>
                                            </div>
                                            {{-- <span class="discount">20%</span> --}}
                                            <a href="{{ route('product-details',['slug' => $product_color->product->slug, 'c' => $product_color->color->code]) }}">
                                                @if($product_color->image != NULL)
                                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                                @else
                                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product-details">
                                            <div class="seen-product-details">
                                                <div>
                                                    <p class="product-title">{{ $product_color->product->title }}</p>
                                                    <p class="product-sub">{{ $product_color->product->category->title }}</p>
                                                </div>
                                                
                                                <div class="price">
                                                    
                                                   @if(!isset($product_size))
                                                        <del>Nrs.{{ $product_size->price }}</del>
                                                    @endif
            
                                                    <ins>
                                                        Nrs.{{ $product_size->offer_price != NULL || $product_size->offer_price != 0 ? $product_size->offer_price : $product_size->price }}
                                                    </ins>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                        @endforeach
	                	<!--@foreach($related_products as $key => $relProduct)
	                    <div class="swiper-slide">
	                        <div class="product">
	                            <div class="product-image">
	                                <div class="product-action-buttons">
	                                    <a href="javascript:void(0)" class="action-button btn-add-to-wishlist" data-product-id="{{ $relProduct->id }}">
	                                        <i class="fa fa-heart"></i>
	                                        <span>Add to Wishlist</span>
	                                    </a>
	                                    <a href="#" class="action-button">
	                                        <i class="fa fa-retweet"></i>
	                                        <span>Add to Compare</span>
	                                    </a>
	                                </div>
	                                {{-- <span class="discount">20%</span> --}}
	                                <a href="{{ route('product-details',['slug' => $relProduct->slug]) }}">
	                                    <img src="{{ asset('storage/products/'.$relProduct->slug.'/thumbs/small_'.$relProduct->image) }}" alt="{{ $relProduct->slug }}" class="img-fluid">
	                                </a>
	                            </div>
	                            <div class="product-details">
	                                <div class="seen-product-details">
	                                    <div>
	                                        <p class="product-title">{{ $relProduct->title }}</p>
                                        <p class="product-sub">{{ $relProduct->category->title }}</p>
	                                    </div>
	                                    <div class="price">
	                                        @if($relProduct->offer_price != NULL || $relProduct->offer_price != 0)
	                                            <del>Nrs.{{ $relProduct->price }}</del>
	                                        @endif

	                                        <ins>
	                                            Nrs.{{ $relProduct->offer_price != NULL || $relProduct->offer_price != 0 ? $relProduct->offer_price : $relProduct->price }}
	                                        </ins>
	                                    </div>
	                                </div>
	                                {{-- <div class="button-wrappers">
	                                    <a href="#" class="main-button lined"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
	                                    <a href="#" class="main-button colored">Buy Now</a>
	                                </div> --}}
	                            </div>
	                        </div>
	                    </div>
	                    @endforeach-->
	                </div>
	                <div class="swiper-button-next"></div>
	                <div class="swiper-button-prev"></div>
	            </div>
	        </div>
	    </div>
	    <div class="mobile-product-button">
	    	<a href="javascript:void(0)" id="add-to-cart-mobile" data-buy-now="0" data-product-id="{{ $product->id }}" class="mobile-button"><i class="fa fa-shopping-cart"></i><span> Add to Cart </span></a>
	    	<a href="javascript:void(0)" id="add-to-cart" data-buy-now="1" data-product-id="{{ $product->id }}" class="mobile-button"><span class="add-to-cart-btn-text">Buy Now</span></a>
	    </div>
	</main>
	
	@if($size_guide != NULL)
		@php
			$size_guide_units = json_decode($size_guide->units);
			$size_guide_sizes = json_decode($size_guide->sizes);
		@endphp
		<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="sizeGuideModalLabel">Size Guide for the product</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead class="thead-dark">
									<tr>
										<th scope="col">Sizes</th>
										@foreach($size_guide_units as $unit)
										<th scope="col">{{ $unit->name }}</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									@foreach($size_guide_sizes as $key => $size)
									<tr>
										<td>{{ $size->name }}</td>
										@foreach($size_guide_units as $unit)
											<td>{{ $unit->value[$key] }}</td>
										@endforeach
										
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

@push('post-scripts')
	<script src="{{ asset('frontend/js/jquery.star-rating-svg.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
	<!-- Barrating JS -->
    <script src="{{ asset('frontend/plugins/jquery.barrating.min.js') }}"></script>
	<script>


        $(document).ready(function () {
            $("#toogle").click(function () {
                $("footer").toggle();
                $(".footend").toggle();
                $('.arrow').toggleClass('transform-active');
            });
        });

        $(document).ready(function () {
            (function () {
                var showChar = 500;
                var ellipsestext = "...";

                $(".truncate").each(function () {
                    var content = $(this).html();
                    if (content.length > showChar) {
                        var c = content.substr(0, showChar);
                        var h = content;
                        var html =
                            '<div class="truncate-text" style="display:block">' +
                            c +
                            '<span class="moreellipses">' +
                            ellipsestext +
                            '&nbsp;&nbsp;<a href="" class="moreless more">Read more</a></span></span></div><div class="truncate-text" style="display:none">' +
                            h +
                            '<a href="" class="moreless lesss">Read less</a></span></div>';

                        $(this).html(html);
                    }
                });

                $(".moreless").click(function () {
                    var thisEl = $(this);
                    var cT = thisEl.closest(".truncate-text");
                    var tX = ".truncate-text";
                    if (thisEl.hasClass("lesss")) {
                        cT.prev(tX).toggle();
                        cT.toggle();
                        $(this).parent().parent().removeClass("whole");
                    } else {
                        cT.toggle();
                        cT.next(tX).toggle();
                        $(this).parent().parent().parent().parent().addClass("whole");
                    }
                    return false;
                });
                /* end iffe */
            })();

            /* end ready */
        });
        $(".do-rating").starRating({
            initialRating: 0,
            strokeColor: '#894A00',
            strokeWidth: 10,
            starSize: 25,
            useFullStars: true,
            disableAfterRate: false
        });
    </script>
	<script>

		$("#add-to-cart, #add-to-cart-mobile").click(function(){
		    var buy_now = $(this).data('buy-now');
		    var product_id = $(this).data('product-id');
		    var ordered_qty = $('#ordered-qty').val();
    
	        var product_color_id = $("#product-color li .selected").data('product-color-id');
	        var product_size_id = $("#product-variation-sizes li .selected").data('product-size-id');

		    console.log(product_id+ ' --- '  + ordered_qty+ ' --- ' + product_color_id+ ' --- ' + product_size_id);
		    add_to_cart(product_id, ordered_qty, product_color_id, product_size_id, buy_now);

		});


		// var product_price = '{{ $product->price }}';
		// var product_offer_price = '{{ $product->offer_price ? $product->offer_price : NULL }}';

		var swiperThumbs = new Swiper(".swiper-gallery", {
		    spaceBetween: 6,
		    slidesPerView: 6,
		});

		$(".gallery-item").on("click", function () {
		    $(".gallery-item").removeClass("gallery-item-active");
		    $(this).addClass("gallery-item-active");
		    var displayImage = $(this).data("imagesource");
		    var linkImage = $(this).data("linksrc");
		    // console.log(displayImage, linkImage);
		    $(".main-image").find("a").attr("href", linkImage);
		    $(".main-image").find("img").attr("src", displayImage);
		});

		$(".product-color li label").each(function(){

			if ($(this).hasClass('selected')) {

				var product_color_id = $(this).data('product-color-id');
				$(".gallery-item").removeClass("gallery-item-active");

				$(".swiper-gallery").find(".gallery-item").each(function () {

				    var matchId = $(this).data("color-id");

				    if (product_color_id === matchId) {
				        $(this).addClass("gallery-item-active");
				        $(this).trigger("click");
				    }
				});
			}
		});


		$(".product-color li label").click(function(){

			$(".product-color li label").removeClass("selected");
			$(this).addClass("selected");
			$(".gallery-item").removeClass("gallery-item-active");

			var product_color_id = $(this).data('product-color-id');

			get_related_sizes(product_color_id);

			$(".swiper-gallery").find(".gallery-item").each(function () {
			    var matchId = $(this).data("color-id");

			    if (product_color_id === matchId) {
			        $(this).addClass("gallery-item-active");
			        $(this).trigger("click");
			    }
			});

			// alert('test');
		});

		$(".product-sizes li label").each(function(){
			if ($(this).hasClass('selected')) {
				call_product_variation_function(this);
			}
		});

		$(".product-sizes li label").click(function(){
			$(".product-sizes li label").removeClass("selected");
			$(this).addClass("selected");

			call_product_variation_function(this);

		});

		function call_product_variation_function(that) {

			var stock_status = $(that).data('stock-status');
			var preorder_status = $(that).data('pre-order-status');
			var max_order_qty = $(that).data('stock-count');
			var variation_price = $(that).data('variation-price');
			var variation_offer_price = $(that).data('variation-offer-price');

			var price = variation_price;
			var offer_price = variation_offer_price;


			var priceResponse = '';
			if(offer_price != '' || offer_price != 0){
                priceResponse += '<del>Nrs.'+price+'</del>';
			}
            
			offer_price = offer_price != '' || offer_price != 0 ? offer_price : price;

            priceResponse += '<ins>Nrs.'+offer_price+'</ins>';

			$("#priceElement").html(priceResponse);

            $("#ordered-qty").val(1);
            $("#ordered-qty").attr('max',max_order_qty);

            if (stock_status == 1) {

            	$(".add-to-cart-btn-text").text('Buy Now');
            	$(".stock-status").removeClass('no-stock').addClass('stock show').html('In Stock');
            	$(".preorder").removeClass('show');
            	$(".preorder").css("display", "none");
            	$(".product-single-button").show();

            }else{

            	if (preorder_status == 1 && max_order_qty > 0) {

            		$(".add-to-cart-btn-text").text('Pre Order');
            		$(".stock-status").removeClass('show');
            		$(".preorder").addClass('show');
            		$(".preorder").html('Pre Order');
            		$(".product-single-button").show();
            	}else{
            		$(".stock-status").addClass('no-stock show').removeClass('stock').html('Out of Stock!');
            		$(".preorder").removeClass('show');
            		$(".product-single-button").hide();

            	}

            }
		}

		function add_to_cart(product_id, ordered_qty, product_color_id, product_size_id, buy_now = 0) {

            $.ajax({
                url : "{{ URL::route('add-to-cart') }}",
                type : "POST",
                data : { 
                            '_token': '{{ csrf_token() }}',
                            product_id: product_id,
                            ordered_qty: ordered_qty,
                            product_color_id: product_color_id,
                            product_size_id: product_size_id
                        },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                success : function(response){
                    $('#modal-loader').hide();
                    var obj = jQuery.parseJSON( response);
                    // console.log(response);
                    if (obj.status=='success') {

                        $('.item-count').html(obj.total_qty);
                        $('.cart-total-price').html(obj.total_price);
                        $('#miniCart').load(document.URL + ' #miniCart>*');
                        $('#cartTable').load(document.URL + ' #cartTable>*');

                        toastr['success']('Item Added to Cart');
                        
                        if (buy_now == 1) {
                        	window.location.replace("{{ route('cart') }}");
                        }
                        // alert('Item Added to Cart');
                    }else if(obj.status == 'stockerror') {

                        var stock = obj.stock;
                        var in_cart = obj.in_cart;

                        toastr["error"]("<span>Available : "+stock+"</span><br><span>In Cart : "+in_cart+"</span>", "Out of Stock!");
                        // alert("<span>Available : "+stock+"</span><br><span>In Cart : "+in_cart+"</span>", "Out of Stock!");
                    }else if(obj.status == 'prestockerror') {

                        var stock = obj.stock;
                        var in_cart = obj.in_cart;

                        toastr["error"]("<span>In Cart : "+in_cart+"</span>", "Only "+stock+" items per Order can be placed!");
                        // alert("<span>Available : "+stock+"</span><br><span>In Cart : "+in_cart+"</span>", "Out of Stock!");
                    }else if(obj.status == 'outofstock'){

                    	toastr["error"]("Sorry, Item is Sold Out!", "Out of Stock!");
                    }else if(obj.status == 'error'){
                    	
                    	toastr["error"]("Sorry, Variation Not Found!", "Product Variation Not Found!");
                    }

                }
            });
        }

		function get_related_sizes(product_color_id) {
			// console.log('test');
            $.ajax({
                url : "{{ URL::route('get-related-sizes') }}",
                type : "POST",
                data : { '_token': '{{ csrf_token() }}',
                            product_id: {{ $product->id }},
                            product_color_id: product_color_id
                        },
                cache : false,
                beforeSend : function (){
                    $('#modal-loader').show();
                },
                complete : function($response, $status){
                	$('#modal-loader').hide();
                    if ($status != "error" && $status != "timeout") {

                        var obj = jQuery.parseJSON($response.responseText);
                        $("#product-variation-sizes").html(obj.related_sizes);

                        // Size Select

                        $(".product-sizes li label").each(function(){
                        	if ($(this).hasClass('selected')) {
                        		call_product_variation_function(this);
                        	}
                        });

                		$(".product-sizes li label").click(function(){
        					$(".product-sizes li label").removeClass("selected");
        					$(this).addClass("selected");

        					call_product_variation_function(this);
        				});

                        $("#ordered-qty").val(1);
                        $("#ordered-qty").attr('max',obj.max_order_qty);
                    }
                }
            });
        }

        $('.num-in span').click(function () {
        	var $input = $(this).parents('.num-block').find('input.in-num');

        	if($(this).hasClass('minus')) {

        		var count = parseFloat($input.val()) - 1;
				count = count < 1 ? 1 : count;

        		if (count < 2) {
        			$(this).addClass('dis');
        		}else {
        			$(this).removeClass('dis');
        		}

        		$input.val(count);
        	}else {

        		var count = parseFloat($input.val()) + 1;

        		if (count > $('#ordered-qty').attr('max')) {
                    count = $('#ordered-qty').attr('max');
                }

        		$input.val(count);

        		if (count > 1) {
        			$(this).parents('.num-block').find(('.minus')).removeClass('dis');
        		}
        	}
        	
        	$input.change();
        	return false;
        });

	    $(".my-rating").starRating({
	        starSize: 15,
	        readOnly: true,

	    });
	</script>
@endpush