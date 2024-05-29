@extends('layouts.app')
@section('title', $category->title)
@push('post-css')
	<style>
	    .filter-boxes ul li label {
	        font-size: 12px;
	        margin-bottom: 0;
	    }

	    .filter-boxes ul li label:hover {
	        cursor: pointer;
	        color: #832323;
	    }

	    .sizes li {
	        display: inline-block;
	        border: 1px solid #832323;
	        font-size: 12px;
	        margin-bottom: 4px;
	    }

	    .sizes li label {
	        font-size: 12px;
	        padding: 4px 8px;
	    }

	    .sizes li label:hover {
	        /* border-color: #; */
	        color: #832323;
	        cursor: pointer;
	    }

	    .sizes li label.active {
	        background-color: #832323;
	        color: #fff;
	    }
	    .sizes li label.active:hover {
	        color: #fff;
	    }


	    .price-filter #slider-range {
            margin-top: 32px;
        }

        .price-number {
            position: absolute;
            top: -30px;
            padding: 4px;
            border: none !important;
            outline: none !important;
            left: -10px;
        }

        .ui-widget-content .ui-state-active .price-number {
            border: none;
            color: #000;
            outline: none;
            padding: 4px;
        }
	</style>
@endpush

@push('meta')
    <meta name="title" content="{{ $setting->meta_title }} - {{ $category->title }}">
    <meta name="description" content="{{ $setting->meta_description }}">
    <meta name="og:title" content="{{ $setting->og_title }} - {{ $category->title }}">
    <meta name="og:description" content="{{ $setting->og_description }}">
    <meta name="image" content="{{ asset('storage/setting/og_image/'.$setting->og_image) }}">
    <meta name="og:image" content="{{ asset('storage/setting/og_image/'.$setting->og_image) }}">
@endpush

@section('content')
	<main>
	    <div class="page-title pt32 pb32 bg-light">
	        <div class="container">
	            <div class="row">
	                <div class="col-sm-8">
	                    <h3 class="page-title-head">
	                        {{ $category->title }}
	                    </h3>
	                    <div class="page-list">
	                        <ul class="breadcrumb">
	                            <li><a href="{{ route('home') }}">Home /</a></li>
	                            <li><a href="{{ route('category-products',['slug' => $category->slug]) }}">{{ $category->title }} /</a></li>
	                            <li>Products</li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="product-home product-list pt40 pb40">
	        <div class="container">
	        	@php

	        	    $next_page_url = $product_size_variations->nextPageUrl();
	        	    parse_str(parse_url($next_page_url, PHP_URL_QUERY), $url_attributes);

	        	    $url_attributes['category_id'] = $category->id;
	        	    // dd($url_attributes);
	        	@endphp
	            @if($product_size_variations->count() > 0)
		            <?php
		                $cur_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : $min_price;
	                        // dd($min_price);
						$cur_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : $max_price;

		                function generate_url($filter_key, $ignore_id = 0, $add_id = 'not-set'){

		                    $currentUrl = url()->current();
		                    $parametersArray = array();

		                    if (isset($_GET['color'])) {
		                        $parametersArray['color'] = $_GET['color'];
		                    }

		                    if (isset($_GET['size'])) {
		                        $parametersArray['size'] = $_GET['size'];
		                    }

		                    if (isset($_GET['occassion'])) {
		                        $parametersArray['occassion'] = $_GET['occassion'];
		                    }
		                    
		                     if (isset($_GET['fabric'])) {
		                        $parametersArray['fabric'] = $_GET['fabric'];
		                    }

		                    if (isset($_GET['delivery_time'])) {
		                        $parametersArray['delivery_time'] = $_GET['delivery_time'];
		                    }

		                    if (isset($_GET['gender'])) {
		                        $parametersArray['gender'] = $_GET['gender'];
		                    }

		                    if (isset($_GET['min_price'])) {
		                        $parametersArray['min_price'] = $_GET['min_price'];
		                        $parametersArray['max_price'] = $_GET['max_price'];
		                    }

		                    if (isset($_GET['sort'])) {
		                        $parametersArray['sort'] = $_GET['sort'];
		                    }

		                    // return $parametersArray;
		                    if (isset($parametersArray[$filter_key])) {

		                        if (is_array($parametersArray[$filter_key])) {

		                            $pos = array_search($ignore_id, $parametersArray[$filter_key]);
		                            // return $pos;
		                            
		                            if ($pos !== false) {
		                                // return 'abcd';
		                                unset($parametersArray[$filter_key][$pos]);
		                                $parametersArray[$filter_key] = array_values($parametersArray[$filter_key]);
		                            }

		                            if ($add_id != 'not-set') {
		                                array_push($parametersArray[$filter_key],$add_id);
		                            }

		                        }else{
		                            $pos = array_search($ignore_id, $parametersArray);
		                            if ($pos !== false) {
		                                unset($parametersArray[$pos]);
		                                // $parametersArray = array_values($parametersArray);
		                            }
		                            // return $parametersArray;
		                            if ($add_id != 'not-set') {
		                                $parametersArray[$filter_key] = $add_id;
		                            }
		                        }

		                    }else{
		                        
		                        if ($filter_key == 'price' ) {
		                            if (isset($_GET['min_price']) && $_GET['min_price'] == $ignore_id) {
		                                unset($parametersArray['min_price']);
		                                unset($parametersArray['max_price']);
		                            }else{
		                                $parametersArray['min_price'] = $ignore_id;
		                                $parametersArray['max_price'] = $add_id;
		                            }
		                            
		                            
		                        }elseif ($filter_key == 'sort' ) {
                                    $parametersArray[$filter_key] = $add_id;
                                }else{
		                            $parametersArray[$filter_key][] = $add_id;
		                        }

		                    }

		                    $counter = 0;
		                    foreach ($parametersArray as $key => $par) {

		                        if (is_array($par)) {

		                            for ($i=0; $i < count($par); $i++) { 
		                                if ($counter == 0) {
		                                    $currentUrl .= '?'.$key.'[]='.$par[$i];
		                                }else{
		                                    $currentUrl .= '&'.$key.'[]='.$par[$i];
		                                }
		                                $counter++;
		                            }

		                        }else{

		                            if ($counter == 0) {
		                                $currentUrl .= '?'.$key.'='.$par;
		                            }else{
		                                $currentUrl .= '&'.$key.'='.$par;
		                            }
		                            $counter++;

		                        }
		                    }

		                    

		                    return $currentUrl;
		                }
		            ?>
		            <div class="row">
		                <div class="col-lg-3">
	                        <div class="filter-wrapper">
	                            <span class="filter-close">
	                                <i class="fa fa-times"></i>
	                            </span>
	                            <div class="filter-boxes">
	                            	<hr>
	                            	<ul>
	                            		@foreach($filter_delivery_times as $key => $delivery_time)
			                            	<li>
			                            		<a href="{{ isset($_GET['delivery_time']) && in_array($delivery_time, $_GET['delivery_time']) ? generate_url('delivery_time', $delivery_time) : generate_url('delivery_time', 'not-set', $delivery_time) }}">
				                        			<span class="check-status {{ isset($_GET['delivery_time']) && in_array($delivery_time, $_GET['delivery_time']) ? 'active' : '' }}"></span> 
				                        			{{ $delivery_time == 0 ? 'In Stock' : 'Pre - Order' }}
			                        			</a>
			                            	</li>
		                            	@endforeach
		                            </ul>
		                        </div>
	                            <div class="filter-boxes">
	                            	
	                            	<h6>Colors</h6>
	                            	<hr>
	                            	<ul class="color-filter">
	                            		@foreach($filter_colors as $key => $color)
			                            	<li>
			                            		<a href="{{ isset($_GET['color']) && in_array($color->id, $_GET['color']) ? generate_url('color', $color->id) : generate_url('color', 'not-set', $color->id) }}">
			                        			<span class="check-status {{ isset($_GET['color']) && in_array($color->id, $_GET['color']) ? 'active' : '' }}"></span> 
			                        			<span class="color-box" style="background-color:{{ $color->code }};"></span>{{ $color->title }}
			                        			</a>
			                            	</li>
		                            	@endforeach

		                            	@if(count($filter_colors) > 4)
		                            		<li class="more-less"><span class="more">See All</span><span class="less">See Less</span></li>
		                            	@endif
		                            </ul>
		                        </div>
		                        <div class="filter-boxes">

	                                <h6>Sizes</h6>
	                                <hr>
	                                <ul class="sizes">
	                                    @foreach($filter_sizes as $key => $size)
	                                    <li>
	                                    	<a href="{{ isset($_GET['size']) && in_array($size->id, $_GET['size']) ? generate_url('size', $size->id) : generate_url('size', 'not-set', $size->id) }}">
		                                        <input type="checkbox" hidden>
		                                        <label class="{{ isset($_GET['size']) && in_array($size->id, $_GET['size']) ? 'active' : '' }}">{{ $size->name }}</label>
	                                        </a>
	                                    </li>
	                                    @endforeach

	                                </ul>
	                            </div>

	                            <div class="filter-boxes">
	                                <h6>Price</h6>
	                                <hr>
	                                <div class="price-filter">
	                                	<input type="hidden" id="filter-min-price" value="{{ $cur_min_price }}">
	                                	<input type="hidden" id="filter-max-price" value="{{ $cur_max_price }}">
	                                    <div id="slider-range"></div>
	                                    <input type="hidden" id="amount" data-min-price="{{ $min_price }}" data-max-price="{{ $max_price }}" data-cur-min-price="{{ $cur_min_price }}" data-cur-max-price="{{ $cur_max_price }}" name="price" placeholder="Add Your Price" />
	                                </div>
	                            </div>

	                            <div class="filter-boxes">
	                            	<h6>Occassions</h6>
	                            	<hr>
	                            	<ul class="occasstion-filter">
	                            		@foreach($filter_occassions as $key => $occassion)
			                            	<li>
			                            		<a href="{{ isset($_GET['occassion']) && in_array($occassion->id, $_GET['occassion']) ? generate_url('occassion', $occassion->id) : generate_url('occassion', 'not-set', $occassion->id) }}">
				                        			<span class="check-status {{ isset($_GET['occassion']) && in_array($occassion->id, $_GET['occassion']) ? 'active' : '' }}"></span> 
				                        			{{ $occassion->title }}
			                        			</a>
			                            	</li>
		                            	@endforeach
		                            	@if(count($filter_occassions) > 4)
		                            		<li class="more-less"><span class="more">See All</span><span class="less">See Less</span></li>
		                            	@endif
		                            </ul>
		                        </div>
		                        
		                        @if(count($filter_fabrics) > 0)
		                        <div class="filter-boxes">
	                            	<h6>Fabrics</h6>
	                            	<hr>
	                            	<ul class="fabric-filter">
	                            		@foreach($filter_fabrics as $key => $fabric)
			                            	<li>
			                            		<a href="{{ isset($_GET['fabric']) && in_array($fabric->id, $_GET['fabric']) ? generate_url('fabric', $fabric->id) : generate_url('fabric', 'not-set', $fabric->id) }}">
				                        			<span class="check-status {{ isset($_GET['fabric']) && in_array($fabric->id, $_GET['fabric']) ? 'active' : '' }}"></span> 
				                        			{{ $fabric->title }}
			                        			</a>
			                            	</li>
		                            	@endforeach
		                            	@if(count($filter_fabrics) > 4)
		                            		<li class="more-less"><span class="more">See All</span><span class="less">See Less</span></li>
		                            	@endif
		                            </ul>
		                        </div>
		                        @endif

		                        

		                        <div class="filter-boxes">
	                            	<h6>Gender</h6>
	                            	<hr>
	                            	<ul>
	                            		@foreach($filter_genders as $key => $gender)
			                            	<li>
			                            		<a href="{{ isset($_GET['gender']) && in_array($gender, $_GET['gender']) ? generate_url('gender', $gender) : generate_url('gender', 'not-set', $gender) }}">

				                        			<span class="check-status {{ isset($_GET['gender']) && in_array($gender, $_GET['gender']) ? 'active' : '' }}"></span> 
				                        			{{ $gender }}
			                        			</a>
			                            	</li>
		                            	@endforeach
		                            </ul>
		                        </div>
	                          
	                        </div>
	                    </div>
		                <div class="col-lg-9">
		                    <div class="option-category">
		                        <div class="row align-items-center">
		                            <div class="col-8 col-lg-12">
		                                <div class="display-style">
                                            
                                            @if(count($_GET) > 0)
                                                <div class="inner-flex" style="margin-right: 20px;">
                                                    <a href="{{ url()->current() }}"><small>Clear All Filter <i class="fa fa-times-circle"></i></small> </a>
                                                </div>
                                            @endif

                                            <div class="inner-flex">
                                                <div>
                                                    <a href="" id="grid-view">
                                                        <i class="ti-layout-grid2"></i>
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="" id="list-view">
                                                        <i class=" ti-layout-list-thumb"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <button onclick="myFunction()" class="dropbtn">
                                                    Sort By <i class="fa fa-chevron-down"></i>
                                                </button>

                                                <div id="myDropdown" class="dropdown-content">
                                                    @if(isset($_GET['sort']))
                                                        <a href="{{ generate_url('sort', $_GET['sort']) }}" >Default </a>
                                                    @endif

                                                    <a href="{{ generate_url('sort', 'not-set', 'alphaAZ') }}">Name (A - Z)</a>

                                                    <a href="{{ generate_url('sort', 'not-set', 'alphaZA') }}">Name (Z - A)</a>
                                                    <a href="{{ generate_url('sort', 'not-set', 'priceLH') }}">Price (Low &gt; High)</a>
                                                    <a href="{{ generate_url('sort', 'not-set', 'priceHL') }}">Price (High &gt; Low)</a>
                                                    <a href="{{ generate_url('sort', 'not-set', 'latest') }}"> Latest First</a>
                                                    <a href="{{ generate_url('sort', 'not-set', 'oldest') }}"> Oldest First</a>
                                                    {{-- <a href="#">Price - Ascending</a>
                                                    <a href="#">Price - Descending</a>
                                                    <a href="#">Aphabetical Order</a> --}}
                                                </div>
                                            </div>
                                        </div>
		                            </div>
		                            <div class="col-4 col-lg-6" id="mobile-filter-button">
		                                <div class="filter-button">
		                                    <a href="#" class="main-button colored">
		                                        Filter
		                                    </a>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="infinite-scroll">
		                        <div class="row" id="loadMoreProducts">
		                    		@php
		                    			
		                    			if (!isset($_GET['sort'])) {

		                    			    $product_size_items = collect($product_size_variations->all())->shuffle();
		                    			}else{

		                    			    $product_size_items = $product_size_variations;
		                    			}

		                    		@endphp
			                    	@foreach($product_size_items as $key => $product_size)
					                    @php
					                    	// if(isset($_GET['sort']) && $_GET['sort'] == 'priceHL'){
					                     //    	$product_size = $product_color->product_sizes()->orderByRaw('IFNULL(offer_price, price) DESC')->first();
					                    	// }else{
					                    	// 	$product_size = $product_color->product_sizes()->orderByRaw('IFNULL(offer_price, price) ASC')->first();
					                    	// }

					                    	$product_color = $product_size->product_color;

					                        $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
					                        $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');
					                    @endphp
					                    <div class="col-6 col-sm-6 col-md-6 col-lg-4 product-bootstrap">
					                        <div class="product grid-view jQueryEqualHeight">

					                        	@if(isset($_GET['delivery_time']))

					                        		@if(isset($_GET['delivery_time']) && count($_GET['delivery_time']) == 1 && in_array(1, $_GET['delivery_time']))
					                            		<span class="ribbon3 pre-order">Pre Order</span>
					                            	@elseif(isset($_GET['delivery_time']) && count($_GET['delivery_time']) == 0 && in_array(0, $_GET['delivery_time']))
					                            		<span class="ribbon3 in-stock">In Stock</span>
					                            	@else
					                                	<span class="ribbon3 in-stock">In Stock</span>
					                            	@endif

					                            @elseif($product_color_quantity_count > 0)

					                            	<span class="ribbon3 in-stock">In Stock</span>
					                            @elseif($product_color_preorder_stock_limit_count > 0)

					                                <span class="ribbon3 pre-order">Pre Order</span>
					                            @else

					                                <span class="ribbon3 sold-out">Sold Out</span>
					                            @endif

					                            <div class="product-image">
					                                <div class="product-action-buttons">
					                                    <a href="javascript:void(0);" class="action-button btn-add-to-wishlist" data-product-color-id="{{ $product_color->id }}">
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
					                                        {{-- <p>
					                                            @foreach($product_color->product->occassions as $occassion)
					                                                <small>{{ $occassion->title }}</small><br>
					                                            @endforeach
					                                        </p> --}}
					                                    </div>
					                                    <div class="price">
					                                        @if($product_size->offer_price != NULL || $product_size->offer_price != 0)
					                                            <del>Nrs.{{ $product_size->price }}</del>
					                                        @endif

					                                        <ins>
					                                            Nrs.{{ $product_size->offer_price != NULL || $product_size->offer_price != 0 ? $product_size->offer_price : $product_size->price }}
					                                        </ins>
					                                    </div>
					                                </div>
					                                {{-- <div class="button-wrappers">
					                                    <a href="javascript:void(0);" class="main-button lined">
					                                        <i class="fa fa-shopping-cart"></i>Add to Cart
					                                    </a>
					                                    <a href="javascript:void(0);" class="main-button colored">Buy Now</a>
					                                </div> --}}
					                            </div>
					                        </div>
					                    </div>
					                @endforeach

			                    </div> 

			                    @if($product_size_variations->nextPageUrl() != NULL)
				                    <div class="text-center my-3">
				                        <a href="javascript:void(0)" class="main-button colored order-tab" id="seeMoreBtn" data-url-par="{{ base64_encode(json_encode($url_attributes)) }}" data-layout="grid-view">
				                            <span class="add-to-cart-btn-text" > See More</span>
				                        </a>
				                    </div>
			                    @endif
		                    </div>
		                   
		                </div>

		            </div>
		            
		            
	            @else
	            	<div class="row">
	            		<div class="col-md-12">
	            			<div class="product-soon text-center">
	            			    <img src="{{ asset('frontend/images/icons/empty.svg') }}">
	            			    <p>Products Coming Soon!!</p>
	            			</div>
	            		</div>
	            	</div>
	            @endif
	        </div>
	    </div>
	</main>
@endsection

@push('post-scripts')
    <script>
        $(".color-filter li").slice(4).css('display', 'none');
        $(".occasstion-filter li").slice(4).css('display', 'none');
        $(".fabric-filter li").slice(4).css('display', 'none');
        $(".more-less").css('display', 'block');
        $(".more-less .more").on('click', function(){
            $(this).hide();
            $(this).next().show();
            $(this).parent().parent().find('li').show();
        });
        $(".more-less .less").on('click', function(){
            $(this).hide();
            $(this).prev().show();
            $(this).parent().parent().find('li').slice(4).css('display', 'none');
            $(".more-less").css('display', 'block');
        })
    </script>
	<script>

		var sliderrange = $('#slider-range');
		var amountprice = $('#amount');
		$(function () {

			sliderrange.slider({
				range: true,
				min: amountprice.data('min-price'),
				max: amountprice.data('max-price'),
				values: [
							amountprice.data('cur-min-price'), 
							amountprice.data('cur-max-price')
						],
				slide: function (event, ui) {
					amountprice.val('Nrs.' + ui.values[0] + ' - Nrs.' + ui.values[1]);
					$(".ui-slider-handle:first-of-type > .price-number").html('Nrs.'+ui.values[0]);
                    $(".ui-slider-handle:last-of-type > .price-number").html('Nrs.'+ui.values[1]);
				},
				stop: function (event, ui) {
					$("#filter-min-price").val(ui.values[0]);
					$("#filter-max-price").val(ui.values[1]);
					var min_value = ui.values[0];
					var max_value = ui.values[1];
					// var attirbutes = '( "price", '+min_value+','+max_value+')';
					get_url_with_price(min_value, max_value);
					{{-- var url = '{{ generate_url}}'+attirbutes; --}}
					// console.log(url);
					// filter_products();
					
				}
			}); 
			$(".ui-slider-handle").html('<span class="price-number"></span>');
            $(".ui-slider-handle:first-of-type > .price-number").html(sliderrange.slider('values', 0));
            $(".ui-slider-handle:last-of-type > .price-number").html(sliderrange.slider('values', 1));

			amountprice.val('Nrs.' + sliderrange.slider('values', 0) + ' - Nrs.' + sliderrange.slider('values', 1));
		});

		function get_url_with_price(min_value, max_value) {
			$.ajax({
			    url : "{{ URL::route('get-url-with-price') }}",
			    type : "POST",
			    data :{ '_token': '{{ csrf_token() }}',
			            min_price: min_value,
			            max_price: max_value,
			            current_url: '{{ url()->current() }}',
			            full_url: '{{ base64_encode(url()->full()) }}'
			        },
			    beforeSend: function(){                

			    },
			    success : function(response)
			    {
			        var obj = jQuery.parseJSON(response);
			        // console.log(obj.url);
			        window.location.replace(obj.url);
			    }
			});
		}

		

	    $(".filter-boxes ul li label").on("click", function (e) {
	        $(this).prev().prev().toggleClass("active");
	    });

	    $(".sizes li").each(function () {

	        $(this).find("label").on("click", function () {
	            console.log("Change This Advice");
	            $(this).toggleClass("active");
	        })
	    });

	    $("#seeMoreBtn").click(function(){

            var url_parameters = $(this).attr('data-url-par');
            var layout = $(this).attr('data-layout');
            // url_parameters = jQuery.parseJSON(url_parameters);
            // console.log(url_parameters);
            // return;

            $.ajax({
                url : "{{ URL::route('see-more-products') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        url_parameters: url_parameters,
                        layout: layout
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    var obj = jQuery.parseJSON(response);

                    $("#loadMoreProducts").append(obj.productsResponse);

                    if(obj.has_more_product == 1){
                        $("#seeMoreBtn").attr('data-url-par', obj.url_parameters);
                    }else{
                        $("#seeMoreBtn").hide()
                    }

                    $(".btn-add-to-wishlist").click(function(){

                        var productColorId = $(this).data("product-color-id");

                        add_to_wishlist(productColorId);

                    });

                }
            });

        });
	</script>
@endpush