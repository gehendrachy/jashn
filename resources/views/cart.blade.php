@extends('layouts.app')
@section('title', "Shopping Cart")
@push('post-css')

@endpush
@section('content')
	<div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Shopping Cart
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li>My Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cart mb-5">
        <div class="container">
            <!-- <h2 class="title">
                Shopping Cart
            </h2> -->
            @if(count($cart) > 0)
            
                <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                <div class="table-wrapper">
                    <table id="check-out">
                        <tr>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>MRP</th>
                            <th>Offer Price</th>
                            <th>Total</th>
                            <th>Estimated Delivery Date</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                        @php
                            $total_price = 0;
                        @endphp
                        @foreach($cart as $key => $item)
                        @php
                            $cProd = \App\Models\Product::where("id", $item["product_id"])->first();
                            $total_price += $item['sub_total'];
                            $product_color = \App\Models\ProductColor::where('id', $item['product_color_id'])->first();
                            $product_size = \App\Models\ProductSize::where('id', $item['product_size_id'])->first();
                            $max_order_qty = $product_size->quantity > 0 ? $product_size->quantity : $product_size->preorder_stock_limit; ;

                            if ($product_size) {

                                if ($product_size->quantity >= $item['ordered_qty']) {

                                    $out_of_stock = 0;
                                } else {

                                    if ($product_size->preorder == 1 && $product_size->preorder_stock_limit >= $item['ordered_qty']) {

                                        $out_of_stock = 0;
                                    } else {
                                        
                                        $out_of_stock = 1;
                                    }
                                }
                            }

                            // $max_order_qty = $product_size->quantity;

                        @endphp
                        <tr class="cart-item-{{ $item['cart_id'] }}" style="{{ $out_of_stock == 1 ? 'background-color: #ffd8d8;' : '' }}">
                            <td>
                                <div class="list">
                                    <div>
                                        @if($product_color->image != NULL)
                                            <img src="{{ asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                        @else
                                            <img src="{{ asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="detail">
                                        <p>
                                            <a href="{{ route('product-details',['slug' => $cProd->slug, 'c' => $product_color->color->code]) }}">{{ $cProd->title }}</a>
                                        </p>
                                        <p>{{ $product_size->sku }}</p>
                                        @if($out_of_stock == 1)
                                        <i style="font-size: 10px; color: red;">Out of Stock</i>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mx-auto">
                                    {{-- <p>{{ $product_color->color->title }}</p> --}}
                                    <p>{{ $product_size->size->name }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="mx-auto">
                                    <div class="cart-items mb-2">
                                        <div class="items-center">
                                            <div class="num-block skin-5">
                                                <div class="num-in">
                                                    <span class="minus dis" data-key="{{ $key }}" data-cart-id="{{ $item['cart_id'] }}">-</span>
                                                    <input type="text" class="in-num ordered-qty-{{ $key }}" value="{{ $item['ordered_qty'] }}" max="{{ $max_order_qty }}" readonly>
                                                    <span class="plus" data-key="{{ $key }}" data-cart-id="{{ $item['cart_id'] }}">+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mrp">
                                    <p>
                                    	Nrs.
                                    	<span class="price-{{ $key }}">
                                    		
                                    		{{ $product_size->price }}
                                    	</span>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="offer-price">
                                	@if($product_size->price != '' || $product_size->price != 0)
                                		@if($product_size->offer_price != '' || $product_size->offer_price != 0)
    		                                <p>
    		                                	Nrs.
    		                                	<span class="offer-price-{{ $key }}">
    		                                		{{ $product_size->offer_price }}
    		                                	</span>
    		                                </p>
    	                                @endif
                                    @else
                                    	@if($cProd->offer_price != '' || $cProd->offer_price != 0)
    	                                <p>
    	                                	Nrs.
    	                                	<span class="offer-price-{{ $key }}"> 
    	                                		{{ $cProd->offer_price }}
    	                                	</span>
    	                                </p>
    	                                @endif
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="total-price">
                                    <p>
                                    	Nrs.
                                    	<span class="sub-total-{{ $key }}">
                                    		{{ $item['sub_total'] }}
                                    	</span>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="delivery">
                                    <p>{{$product_size->quantity <= 0 &&  $product_size->preorder == 1 ? '10-15 Days' : '2-5 Days'}}</p>

                                    @if($product_size->quantity <= 0 && $product_size->preorder == 1)
                                        <p style="font-size: 10px;">
                                            {{ 
                                                \Carbon\Carbon::today()->addDays(10)->format('jS') 
                                                . ' - '. 
                                                \Carbon\Carbon::today()->addDays(15)->format('jS M, Y') 
                                            }}
                                        </p>
                                    @else
                                        <p style="font-size: 10px;">
                                            {{ 
                                                \Carbon\Carbon::today()->addDays(2)->format('jS') 
                                                . ' - '. 
                                                \Carbon\Carbon::today()->addDays(5)->format('jS M, Y') 
                                            }}
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="order-date">
                                    <p>{{ date('jS M, Y') }}</p>
                                </div>
                            </td>
                            <td class="">
                                <div class="mx-auto">
                                    <a class="table-delete" href="javascript:void(0)" onclick="cartDelete('{{ $item['cart_id'] }}')">
                                        <i class="mx-3 ti-trash"></i>
                                    </a>

                                    {{-- <a class="table-refresh" href="javascript:void(0)">
                                        <i class="mx-3 ti-reload"></i>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5">Total Price</td>
                            <th colspan="1">Nrs. <span class="cart-total-price">{{ $total_price }}</span></th>

                        </tr>
                    </table>
                </div>

                <p class="table-message"><small>Please scroll horizontally on table to view full table</small></p>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{ route('home') }}" class="main-button colored mt-4">Continue Shopping</a>
                    </div>
                    <div class="col-sm-6 text-sm-right">
                        {{-- <button type="submit" class="main-button colored mt-4">
                            Clear Cart <i class="mx-2 pt-2 fa fa-trash"></i>
                        </button> --}}
                        <a href="{{ route('checkout') }}" class="main-button colored mt-4">
                            Checkout <i class="mx-2 ti-arrow-right"></i>
                        </a>
                        <!-- <button type="submit" class="main-button colored mt-4">Checkout <i
                                class="mx-2 ti-arrow-right"></i></button> -->
                    </div>

                </div>
            @else 
                <div class="text-center">
                    <h3>No items in the cart!!! </h3>
                    <a href="{{ route('home') }}" class="main-button colored mt-4">Continue Shopping</a>
                </div>
            @endif
        </div>
    </section>
@endsection
@push('post-scripts')
	<script>

		$('.num-in span').click(function () {
        	var $input = $(this).parents('.num-block').find('input.in-num');
        	var old_value = $input.val();

        	var cart_key = $(this).data('key');
        	var cart_id = $(this).data('cart-id');

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

        		if (count > $input.attr('max')) {
                    count = $input.attr('max');
                }

        		$input.val(count);

        		if (count > 1) {
        			$(this).parents('.num-block').find(('.minus')).removeClass('dis');
        		}
        	}


        	if (old_value != count) {
        		update_cart(count, cart_id, cart_key);
        	}

        	
        	$input.change();
        	return false;
        });

        function update_cart(quantity, cart_id, cart_key) {

        	var price_class = 'price-'+cart_key;
        	var offer_price_class = 'offer-price-'+cart_key;
        	var sub_total_class = 'sub-total-'+cart_key;

        	$.ajax({
                url : "{{ URL::route('update-cart') }}",
                type : "POST",
                data : { 
                            '_token': '{{ csrf_token() }}',
                            ordered_qty: quantity,
                            cart_id: cart_id,
                            cart_key: cart_key
                        },
                cache : false,
                beforeSend : function (){``
                    $('#modal-loader').show();
                },
                success : function(response){
                    $('#modal-loader').hide();
                    var obj = jQuery.parseJSON( response);
                    // console.log(response);
                    if (obj.status=='success') {

                        $('.item-count').html(obj.total_qty);
                        $('.cart-total-price').html(obj.total_price);
                        $('.sub-total-'+cart_key).html(obj.item_sub_total);
                        $('.item-quantity-'+cart_key).html(quantity);

                        // $('#miniCart').load(document.URL + ' #miniCart>*');
                        // $('#cartTable').load(document.URL + ' #cartTable>*');

                        toastr['success']('Cart Updated!');
                        
                    }


                }
            });
        }
	</script>
@endpush