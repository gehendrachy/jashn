@extends('layouts.app')
@section('title','Home')
@section('content')
    <main style="overflow:hidden">
        <div class="container-fluid">
            <div class="main-slider">
                <div class="swiper-container swiper1 position-relative">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)   
                        <div class="swiper-slide">
                            <a href="{{ $slider->url }}">
                                <img src="{{ asset('storage/sliders/'.$slider->image) }}" class="img-fluid" alt="{{ $slider->title }}">
                            </a>
                        </div>
                        @endforeach
                       
                    </div>
                     <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="banner-wrappers">
                <div class="banners banner-1">
                   <a href="{{ $banners[0]->url }}">
                        <img src="{{ asset('storage/banners/'.$banners[0]->image) }}" class="img-fluid" alt="{{ $banners[0]->title }}">
                    </a> 
                </div>
                <div class="banners banner-2">
                    <a href="{{ $banners[1]->url }}">
                        <img src="{{ asset('storage/banners/'.$banners[1]->image) }}" class="img-fluid" alt="{{ $banners[1]->title }}">
                    </a>
                </div>
                <div class="banners-flow banner-half">
                    <div class="banners banner-3">
                        <a href="{{ $banners[2]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[2]->image) }}" class="img-fluid" alt="{{ $banners[2]->title }}">
                        </a>
                    </div>
                    <div class="banners banner-4">
                        <a href="{{ $banners[3]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[3]->image) }}" class="img-fluid" alt="{{ $banners[3]->title }}">
                        </a>
                    </div>
                </div>
                <div class="banners-flow banner-fourth">
                    <div class="banners banner-7">
                        <a href="{{ $banners[4]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[4]->image) }}" class="img-fluid" alt="{{ $banners[4]->title }}">
                        </a>
                    </div>
                    <div class="banners banner-8">
                        <a href="{{ $banners[5]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[5]->image) }}" class="img-fluid" alt="{{ $banners[5]->title }}">
                        </a>
                    </div>
                    <div class="banners banner-9">
                        <a href="{{ $banners[6]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[6]->image) }}" class="img-fluid" alt="{{ $banners[6]->title }}">
                        </a>
                    </div>
                    <div class="banners banner-10">
                        <a href="{{ $banners[7]->url }}">
                            <img src="{{ asset('storage/banners/'.$banners[7]->image) }}" class="img-fluid" alt="{{ $banners[7]->title }}">
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <br>
        <div class="product-home pt40 pb40" style="padding-bottom:120px;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="main-title mb16"><span>Trending Products</span></h3>
                    </div>
                    <div class="col-6 text-right">
                        {{-- <a href="categories.html" class="main-button linked">See More <i
                                class="fa fa-arrow-right"></i></a> --}}
                    </div>
                </div>
                <div class="row" id="trendingProducts">
                    @foreach($product_color_variations as $key => $product_color)
                        @php
                            $product_size = $product_color->product_sizes->sortBy('price')->first();
                            $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
                            $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');
                        @endphp
                        <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="product ">
                                @if($product_color_quantity_count > 0)
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--{{ $product_color_variations }}-->
                <div class="text-center my-3">
                    <a href="javascript:void(0)" class="main-button colored order-tab" id="seeMoreBtn" data-loaded-product-color-ids="{{ json_encode($product_color_variations->pluck('id')->all()) }}">
                        <span class="add-to-cart-btn-text" > See More</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    
  
@endsection

@push('post-scripts')
    <script>

        $("#seeMoreBtn").click(function(){

            var loaded_product_color_ids = $(this).attr('data-loaded-product-color-ids');
            // loaded_product_color_ids = jQuery.parseJSON(loaded_product_color_ids);
            // console.log(loaded_product_color_ids);
            // return;

            $.ajax({
                url : "{{ URL::route('see-more-trending-products') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        loaded_product_color_ids: loaded_product_color_ids
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    var obj = jQuery.parseJSON(response);

                    $("#trendingProducts").append(obj.productsResponse);

                    if(obj.has_more_product == 1){
                        $("#seeMoreBtn").attr('data-loaded-product-color-ids', obj.loaded_product_color_ids);
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

        // $('ul.pagination').hide();
        //     $(function() {
        //         $('.infinite-scroll').jscroll({
        //         autoTrigger: true,
        //         loadingHtml: '<div class="scroll-loader"><img src="https://kinniho.com/frontend/img/loading.gif" alt="loader"></div>',
        //         padding: 0,
        //         debug:true,
        //         // loadingFunction : true,
        //         nextSelector: '.pagination li.active + li > a',  
        //         contentSelector: '.infinite-scroll',
        //         callback: function() {
        //             $('ul.pagination').remove();
        //          }
        //     });
        // });
        
    </script>
@endpush
