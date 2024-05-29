@extends('layouts.app')
@section('title', "Wishlists")
@push('post-css')

@endpush
@section('content')
    <div class="page-title pt32 pb32 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="page-title-head">
                        Wishlists
                    </h3>
                    <div class="page-list">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home /</a></li>
                            <li><a href="{{ route('customer.my-account') }}">My Account /</a></li>
                            <li>Wishlists</li>

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
                        <div class="row" id="wishlistItems">
                            @if($wishlists->count() > 0)
                                @foreach($wishlists as $key => $wishlist)
                                    @php
                                        $product_size = $wishlist->product_color->product_sizes->sortBy('price')->first();
                                    @endphp
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4 product-bootstrap">
                                        <div class="product jQueryEqualHeightChanging">
                                            <div class="product-image">
                                                <div class="product-action-buttons">
                                                    <a href="javascript:void(0)" onclick="removeFromWishlist('{{ $wishlist->id }}')" class="action-button">
                                                        <i class="fa fa-trash"></i>
                                                        <span>Remove</span>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-button">
                                                        <i class="fa fa-retweet"></i>
                                                        <span>Add to Compare</span>
                                                    </a>
                                                </div>
                                                {{-- <span class="discount">20%</span> --}}
                                                <a href="{{ route('product-details',['slug' => $wishlist->product_color->product->slug, 'c' => $wishlist->product_color->color->code]) }}">
                                                    @if($wishlist->product_color->image != NULL)
                                                        <img src="{{ asset('storage/products/'.$wishlist->product_color->product->slug.'/variations/thumbs/small_'.$wishlist->product_color->image) }}" alt="{{ $wishlist->product_color->product->slug }}" class="img-fluid">
                                                    @else
                                                        <img src="{{ asset('storage/products/'.$wishlist->product_color->product->slug.'/thumbs/small_'.$wishlist->product_color->product->image) }}" alt="{{ $wishlist->product_color->product->slug }}" class="img-fluid">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-details">
                                                <div class="seen-product-details">
                                                    <div>
                                                        <p class="product-title">{{ $wishlist->product_color->product->title }}</p>
                                                        <p class="product-sub">{{ $wishlist->product_color->product->category->title }}</p>
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
                                                    <a href="#" class="main-button lined"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                                                    <a href="#" class="main-button colored">Buy Now</a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <p class="alert alert-danger text-center">
                                        You don't have any products in your Wishlist.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('post-scripts')
    <script>
        function removeFromWishlist(id) {
            $.ajax({
                url: "{{ URL::route('customer.remove-from-wishlist') }}",
                type: "POST",
                data: {
                        '_token': '{{ csrf_token() }}', 
                        action: 'delete', 
                        wishlist_id: id
                },
                beforeSend: function () {

                },
                success: function (response) {
                    // console.log("success");
                    // console.log("response " + response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.status == 'removed') {
                        $('#wishlistItems').load(document.URL + ' #wishlistItems');
                        toastr['success']('Product removed from Wishlist Successfully.','Removed');

                    }else{
                        toastr['error']('Something Went Wrong!','Error');
                    }
                }
            });
        }
    </script>
@endpush