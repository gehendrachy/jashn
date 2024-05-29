@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <main>
        <div class="page-title pt32 pb32 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="page-title-head">
                            {{ $offer->name }}
                        </h3>
                        <div class="page-list">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">Home /</a></li>
                                <li>Offer / {{ $offer->name }}</li>
                            </ul>
                        </div>
                        @if($offer->offer_type == 1)
                            <p>Buy {{ $offer->minimum_quantity }} to get {{ $offer->discount_percentage }}% off upto NRs.{{ $offer->maximum_discount }} </p>
                        @elseif($offer->offer_type == 2)
                            <p>Spend {{ $offer->minimum_spend }} to get {{ $offer->discount_percentage }}% off upto NRs.{{ $offer->maximum_discount }} </p>
                        @elseif($offer->offer_type == 3)
                            @if($offer->shipping_condition == 1)
                            <p>Get Free Shipping</p>
                            @elseif($offer->shipping_condition == 2)
                            <p>Spend {{ $offer->minimum_spend }} to get Free Shipping</p>
                            @elseif($offer->shipping_condition == 3)
                            <p>Buy {{ $offer->minimum_quantity }} to get Free Shipping</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="product-home pt40 pb40">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="main-title mb16"><span>Products</span></h3>
                            </div>
                            <div class="col-6 text-right">
                                {{-- <a href="categories.html" class="main-button linked">See More <i
                        class="fa fa-arrow-right"></i></a> --}}
                            </div>
                        </div>
                        @if ($products->count() > 0)
                          
                                <div class="row">
                                    @foreach ($products as $key => $product_color)
                                        @php
                                            $product_size = $product_color->product_sizes->sortBy('price')->first();
                                            $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
                                            $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');
                                        @endphp
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                            <div class="product grid-view jQueryEqualHeight">
                                                @if ($product_color_quantity_count > 0)
                                                    <span class="ribbon3 in-stock">In Stock</span>
                                                @elseif($product_color_preorder_stock_limit_count > 0)
                                                    <span class="ribbon3 pre-order">Pre Order</span>
                                                @else
                                                    <span class="ribbon3 sold-out">Sold Out</span>
                                                @endif
                                                <div class="product-image">
                                                    <div class="product-action-buttons">
                                                        <a href="javascript:void(0);"
                                                            class="action-button btn-add-to-wishlist"
                                                            data-product-id="{{ $product_color->product->id }}">
                                                            <i class="fa fa-heart"></i>
                                                            <span>Add to Wishlist</span>
                                                        </a>
                                                        <a href="javascript:void(0);" class="action-button">
                                                            <i class="fa fa-retweet"></i>
                                                            <span>Add to Compare</span>
                                                        </a>
                                                    </div>
                                                    {{-- <span class="discount">20%</span> --}}
                                                    <a
                                                        href="{{ route('product-details', ['slug' => $product_color->product->slug, 'c' => $product_color->color->code]) }}">
                                                        @if ($product_color->image != null)
                                                            <img src="{{ asset('storage/products/' . $product_color->product->slug . '/variations/thumbs/small_' . $product_color->image) }}"
                                                                alt="{{ $product_color->product->slug }}"
                                                                class="img-fluid">
                                                        @else
                                                            <img src="{{ asset('storage/products/' . $product_color->product->slug . '/thumbs/small_' . $product_color->product->image) }}"
                                                                alt="{{ $product_color->product->slug }}"
                                                                class="img-fluid">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product-details">
                                                    <div class="seen-product-details">
                                                        <div>
                                                            <p class="product-title">
                                                                {{ $product_color->product->title }}</p>
                                                            <p class="product-sub">
                                                                {{ $product_color->product->category->title }}</p>
                                                        </div>
                                                        <div class="price">
                                                            @if ($product_size->offer_price != null || $product_size->offer_price != 0)
                                                                <del>Nrs.{{ $product_size->price }}</del>
                                                            @endif

                                                            <ins>
                                                                Nrs.{{ $product_size->offer_price != null || $product_size->offer_price != 0? $product_size->offer_price: $product_size->price }}
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

                                

                        
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Sorry, No Results Found!</p>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
            <div class="pagination-wrap">
                {!! $products->links() !!}
            </div>
        </div>
    </main>
    <style>
        .pagination-wrap nav{
            position: static !important; 

        }

    </style>
@endsection
