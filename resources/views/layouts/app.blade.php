<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $setting->title }} | @yield('title')</title>
    @stack('meta')
    <meta name="keywords" content="{{ $setting->meta_keywords }}" />
    <meta name="author" content="Shop At Jashn" />
    <meta name="copyright" content="www.shopatjashn.com" />
    
    <meta name="facebook-domain-verification" content="pvxhku8es9kr970rs2y7ctrwro7qq7" />
   
    <meta name="ROBOTS" content="INDEX,FOLLOW" />
    <meta name="creation_Date" content="05/26/2022" />
    <meta name="revisit-after" content="7 days" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/setting/favicon/'.$setting->favicon) }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no, user-scalable=no">
    <!-- Web Fonts  -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,600;0,800;0,900;1,100;1,300;1,400;1,600;1,700;1,800;1,900&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{ asset('frontend/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/spacing.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/newnav.css') }}">
    @stack('post-css')
    <style type="text/css">
        .product {
            position: relative;
            border: 1px solid #eaeaea;
        }
        .product .product-image{
            padding:8px;
            min-height:300px;
        }
        .scroll-loader img{
            width:20px;
            height:20px;
            display:block;
            margin:8px auto;
        }
        .actual-footer{
            position:relative;
        }
        .actual-footer:before{
            content:'';
            position:absolute;
            top:-20px;
            left:50%;
            transform:translateX(-50%);
            width:90%;
            height:1px;
            background-color:#eaeaea;
        }
        .product-home{
            padding-bottom:30px !important;
        }
        .pagination{
            justify-content:center;
        }
        .page-item.active .page-link{
            background-color: #6b3d18;
            border-color: #6b3d18;
        }
        .page-link{
            color:#6b3d18;
        }
        @media only screen and (min-width:600px){
            .sign-social .social{
                margin-top:22px;
            }
        }
        @media only screen and (max-width:600px){
            .product .product-image{
                padding:8px;
                min-height:150px;
            }
            .pagination{
                flex-wrap:wrap;
            }
        }
        
        
    </style>
    
    <!-- Global site tag (gtag.js) - Google Analytics --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-44788287-1"></script> <script>
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); 
    gtag('config', 'UA-44788287-1'); 
    </script>
    
    <!-- Meta Pixel Code -->
    <script>
    
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '679922266398442');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=679922266398442&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    
    <script src="https://cdn.gravitec.net/storage/3dac764d5bf01f097979a19afdce452a/client.js" async></script>
</head>

<body>
    
   <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "110164021733631");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v14.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

  
    <div id="modal-loader" >
        <div class="loadingio-spinner-eclipse-5n5ocxxlhe2">
            <div class="ldio-shhdvnglxrk">
                <div></div>
            </div>
        </div>
    </div>
    <nav id="header-Nav">
        <div class="container-fluid">
            <div id="mainNav">
                <div id="logo">
                    <picture>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/setting/logo/'.$setting->logo) }}" alt="{{ $setting->logo }}">
                        </a>
                    </picture>
                </div>
                <div class="" id="menu">
                    <div class="toggle-menu">
                        <i class="ti-menu"></i> <span>Categories</span>
                    </div>
                    <ul class="menu">
                        <li class="menu-title">Categories <span id="close-menu" class="float-right"><i class="fa fa-times"></i></span></li>
                        <?php
                            $appCategories = getFullListFromDB(__('front_details.branch_id'));
                            

                            function getFullListFromDB($parent_id = 0)
                            {
                                $categories =  DB::table('categories')->where([['display', 1],['parent_id', $parent_id]])->select('id','title','parent_id', 'child','slug')->orderBy('order_item')->get();
                                
                                foreach ($categories as &$value) {
                                    $subresult = getFullListFromDB( $value->id);

                                    if (count($subresult) > 0) {
                                        $value->children = $subresult;
                                    }
                                }

                                unset($value);

                                return $categories;
                            }

                            function displayList($list){

                                foreach ($list as $item){
                                    ?>
                                    <li>
                                        <?php
                                            if (property_exists($item, "children")) {
                                                ?>
                                                <a href="{{ $item->parent_id == 0 || (App\Models\Category::find($item->parent_id) !== null && App\Models\Category::find($item->parent_id)->parent_id == 0) ? 'javascript:void(0);' : route('category-products',['slug' => $item->slug]) }}" class="{{ $item->parent_id == 0 ? 'main-menu' : 'has-sub' }}">{{ $item->title }} <i class="fa {{ $item->parent_id == 0 ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i></a>
                                                
                                                <div class="menu-level-one">
                                                    <ul class="sub-level-one">
                                                        {{ displayList($item->children) }}
                                                    </ul>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="{{ route('category-products',['slug' => $item->slug]) }}"><span>{{ $item->title }}</span></a>
                                                <?php
                                            }
                                        ?>
                                    </li>
                                    <?php
                                }

                            }
                        ?>
                        {{ displayList($appCategories) }}
                        
                         @if(count($nav_occassion)>0)
                        <li class="d-none d-sm-block">
                            <a href="javascript:void(0);" class="main-menu">Occasions <i
                                    class="fa fa-chevron-down"></i></a>
                            <div class="menu-level-one">
                                <ul class="sub-level-one">
                                    @foreach ($nav_occassion as $occassion)
                                        <li><a href="{{ route('occassion', $occassion->slug) }}">{{ $occassion->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if(count($nav_offers)>0)
                        <li class="d-none d-sm-block">
                            <a href="javascript:void(0);" class="main-menu">Offers <i
                                    class="fa fa-chevron-down"></i></a>
                            <div class="menu-level-one">
                                <ul class="sub-level-one">
                                    @foreach ($nav_offers as $offer)
                                        <li><a href="{{ route('offer', $offer->slug) }}">{{ $offer->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
                 <div class="has-search" id="search">
                    <div class="search-wrapper">
                        <form action="{{ route('search') }}" method="GET" autocomplete="off">
                            <div class="search-group">
                                <input type="text" name="search" class="input-style" placeholder="Search Here..." id="">
                                <!-- <p id="empty-message"></p> -->
                                <button type="submit"><i class="fa fa-search nav-search-icon"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="end-icons">
                    
                    @if(!Auth::check())
                        <div class="login-wrapper">
                            <a href="{{ route('user.login') }}" class="nav-button">
                                <img src="{{asset('frontend/images/icons/login.svg')}}" alt="User Login" />
                                <span>Login</span>
                            </a>
                        </div>
                         <div class="login-wrapper">
                            <a href="{{ route('customer.wishlist') }}" class="nav-button">
                                <img src="{{asset('frontend/images/icons/heart.svg')}}" alt="User Login" />
                                <span>Wishlist</span>
                            </a>
                        </div>
                    @else
                        
                        <div class="login-wrapper">
                            <a href="{{ route('customer.my-account') }}" class="nav-button">
                                <img src="{{asset('frontend/images/icons/user.svg')}}" alt="User Login" />
                                <span>Profile</span>
                            </a>
                        </div>
                         <div class="login-wrapper">
                            <a href="{{ route('customer.wishlist') }}" class="nav-button">
                                <img src="{{asset('frontend/images/icons/heart.svg')}}" alt="User Login" />
                                <span>Wishlist</span>
                            </a>
                        </div>
                        
                       

                        <!--<div class="login-wrapper">-->
                        <!--    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-button">-->
                        <!--        <i class="fa fa-sign-out-alt"></i>-->
                        <!--        <span>Log Out</span>-->
                        <!--    </a>-->

                        <!--    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>-->
                        <!--</div>-->
                    @endif
                    <div class="cart-wrapper">
                        <a href="" class="nav-button">
                            <img src="{{asset('frontend/images/icons/cart.svg')}}" alt="User Login" />
                            <span>Cart</span>
                        </a>
                    </div>
                </div>

                <div class="cdropdown" id="occassion" >
                    <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-gift"></i> <span>Occassion</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         @foreach ($nav_occassion as $occassion)
                            <a class="dropdown-item" href="{{ route('occassion', $occassion->slug) }}">{{ $occassion->title }}</a>
                         @endforeach
                     
                    </div>
                </div>
                 @if(count($nav_offers)>0)
                <div class="cdropdown" id="offers" >
                    <a class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <img src="{{ asset('./frontend/images/sale-discount.svg') }}" style="width:20px;" /> <span>Offers</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        @foreach ($nav_offers as $offer)
                            <a class="dropdown-item" href="{{ route('offer', $offer->slug) }}">{{ $offer->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </nav>
   
    @php
        $whatsapp = preg_replace("/[^0-9]/", "", $setting->mobile_whatsapp);
        $currentUri = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    @endphp
    <input type="hidden" id="whatsappNumber" value="<?=$whatsapp ?>">
    <input type="hidden" id="currentUri" value="<?=$currentUri ?>">

    @yield('content')
    <section>
        <div id="toogle">
            <h3>See more about Jashn</h3>
            <i class="fa fa-chevron-down arrow" style="padding: 8px;"></i>
        </div>
    </section>
   
        <div id="foot-sho-hide">
            <div class="actual-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-3 mb-xl-0 mb-4">
                            <p class="footer-title">Contact Info</p>
                            <ul class="footer-list">
                                <li>
                                    <a href="tel:9841327018"><small><i class="fa fa-phone-alt"></i></small>&nbsp; 9841327018</a>
                                </li>
                                <li>
                                    <a href="tel:9802790090"><small><i class="fa fa-phone-alt"></i></small>&nbsp; 9802790090</a>
                                </li>
                                <li>
                                    <a href="mailto:jashn@shopatjashn.com"><small><i class="fa fa-envelope"></i></small>&nbsp;&nbsp; jashn@shopatjashn.com</a>
                                </li>
                            </ul>
                        </div>
                        <div class=" col-md-6 col-lg-6 col-xl-3 mb-xl-0 mb-4">
                            <p class="footer-title">Need Help ?</p>
                            <ul class="footer-list">
                                <li>
                                     <a href="{{ route('quick-links',['type' => 'faq']) }}">FAQs</a>
                                </li>
                                <li>
                                    <a href="#">How To Order</a>
                                </li>

                                <li>
                                   <a href="{{ $setting->youtubeurl }}">Youtube Channel</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-6  col-xl-3 mb-xl-0 mb-4">
                            <p class="footer-title">Account</p>
                            <ul class="footer-list">
                                @if(Auth::check())
                                    <li>
                                        <a href="{{ route('customer.my-account') }}">My Account</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('customer.wishlist') }}">My Wishlist</a>
                                    </li>
                                
                                    <li>
                                        <a href="{{ route('user.login') }}">Log In</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.register') }}">Register</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3 mb-xl-0 mb-4">
                            <p class="footer-title">Quick Links</p>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{ route('quick-links',['type' => 'jashn']) }}">About Jashn</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-us') }}">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="col-sm-12 text-center">
                        <hr>
                            <p class="mb-0"><strong>Payment Methods</strong></p>
                            <ul class="footer-pay mb-0">
                                <li>
                                    <img src=" {{ asset('frontend/images/visa.png') }}" class="visa" alt="">
                                </li>
            
                                <!--<li>-->
                                <!--    <img src="{{ asset('frontend/images/esewa.png') }}" class="esewa" alt="">-->
                                <!--</li>-->
                                <li>
                                    <img src="{{ asset('frontend/images/mastercard.png') }}" class="mastercard" alt="">
                                </li>
                                <li>
                                    <img src="{{ asset('frontend/images/icons/nic.png') }}" class="nic" alt="">
                                </li>
                                <li>
                                    <img src="{{ asset('frontend/images/icons/cod.png') }}" class="cod" alt="">
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        <div class="boxed-footer">
            <div class="boxed-footer-box">
                <p class="mb-0"><strong>Returning an item</strong></p>
                <p>We've updated our return policies in response to recent update. Read our <a href="{{ route('quick-links',['type' => 'return-policy']) }}"><strong>Order, Return & Exchange Policy</strong></a></p>
            </div>
            <div class="boxed-footer-box">
                 <p class="mb-0"><strong><img src={{asset('frontend/images/icons/viber.png')}} alt="viber-support" style="height:20px;width:auto;" />&nbsp;&nbsp;Viber Support</strong></p>
                <p class="lead"><strong><a href="viber://chat?number=+9779814327018" target="_blank"><small></small> +977-9814327018
                            </a></strong></p>
            </div>
            <div class="boxed-footer-box">
                <p class="mb-0"><strong>Follow Us</strong></p>
                <ul class="footer-social-end">
                    <li>
                        <a target="_blank" href="{{ $setting->facebookurl }}">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ $setting->instagramurl }}">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="{{ $setting->twitterurl }}">
                             <i class="fab fa-tiktok"></i>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ $setting->youtubeurl }}">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="boxed-footer-box">
                <p class="mb-0"><strong><img src={{asset('frontend/images/icons/whatsapp.png')}} alt="whatsapp-support" style="height:20px;width:auto;" />&nbsp;&nbsp;Whatsapp Support</strong></p>
                <p class="lead"><strong><a href="https://api.whatsapp.com/send?phone=9779814327018" target="_blank"><small></small> +977
                            9814327018</a></strong></p>
            </div>
        </div>
        <ul class="final-list">
            <li>
                <a href="{{ route('quick-links',['type' => 'terms-and-conditions']) }}">Terms & Conditions</a>
            </li>
            <li>
                <a href="{{ route('quick-links',['type' => 'payment-policy']) }}">Payment Policy</a>
            </li>
        </ul>
        </div>
        
        <hr>
        <p class=" text-center mb-0">
            @Jashn - {{ date('Y') }}. All Rights Reserved by
        </p>
        <p class="text-center">
            Coded with <i class="fa fa-heart" style="color:#880808"></i>
            by <a target="_blank" href="https://ktmrush.com">KTMRush</a>
        </p>
    </footer>

    
    <div id="cart">
        <div class="cart-heading">
            <h6>My Cart</h6>
            <a href="javascript:void(0)" id="cart-close"><i class="fa fa-times"></i></a>
        </div>
        <div id="miniCart">
            @php
                $cart_items = (array)session()->get('cart');
                $cart_total_price = session()->get('total_price');
                $total_price = 0;
                $cart_items_count =count($cart_items);
            @endphp
            @if($cart_items_count > 0)
                <div class="cart-item-wrapper">
                    @foreach($cart_items as $key => $item)
                        @php
                            $cProd = \App\Models\Product::where("id", $item["product_id"])->first();
                            $total_price += $item['sub_total'];
                            $product_color = \App\Models\ProductColor::where('id', $item['product_color_id'])->first();
                            $product_size = \App\Models\ProductSize::where('id', $item['product_size_id'])->first();
                            $max_order_qty = $product_size->quantity;
                        @endphp

                        <div class="cart-items cart-item-{{ $item['cart_id'] }}">
                            <div class="cart-image">
                                @if($product_color->image != NULL)
                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                @else
                                    <img src="{{ asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image) }}" alt="{{ $product_color->product->slug }}" class="img-fluid">
                                @endif
                            </div>

                            <div class="cart-details">
                                <h6><a href="{{ route('product-details',['slug' => $cProd->slug, 'c' => $product_color->color->code]) }}" title="{{ $cProd->title }}">{{ $cProd->title }}</a></h6>

                                <div class="mx-auto">
                                    <p>
                                        Color Family : {{ $product_color->color->title }}, Size : {{ $product_size->size->name }}
                                    </p>
                                </div>

                                <p>Quantity : <span class="item-quantity-{{ $key }}">{{ $item['ordered_qty'] }}</span></p>

                                <p class="cart-price">Nrs. <span class="sub-total-{{ $key }}">{{ $item['sub_total'] }}</span></p>
                            </div>
                            <hr>
                            <div class="cart-action">
                                <a href="javascript:void(0)" class="cart-action-button" onclick="cartDelete('{{ $item['cart_id'] }}')">
                                    <i class="fa fa-trash"></i>&nbsp;Delete From Cart
                                </a>
                                <a href="javascript:void(0)" class="cart-action-button btn-add-to-wishlist"
                                                product-color-id="{{ $item['product_color_id'] }}" >
                                    <i class="fa fa-heart"></i>&nbsp;Add To Wishlist
                                </a>
                           
                            
                        </div>
                        
                    @endforeach
                </div>
                <hr>
                <div class="cart-total">
                    <div>Total : </div>
                    <div><strong class="cart-total-price">Nrs {{ $total_price }}</strong></div>
                </div>
                <hr>
                <div class="text-left">
                    <a href="{{ route('cart') }}" class="main-button lined"><i class="fa fa-shopping-cart"></i>View
                        Cart</a>&nbsp;&nbsp;&nbsp;<a href="{{ route('checkout-process') }}" class="main-button colored"> Checkout</a>
                </div>
            @else
                <div class="top-cart-items text-center">
                    <strong>No Items in the Cart</strong>
                    <p>Keep Shopping</p>
                </div>
            @endif
        </div>
    </div>
    
        

    
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-equal-height.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.5/umd/popper.min.js" integrity="sha512-8cU710tp3iH9RniUh6fq5zJsGnjLzOWLWdZqBMLtqaoZUA6AWIE34lwMB3ipUNiTBP5jEZKY95SfbNnQ8cCKvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.2.4/jquery.jscroll.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.js" integrity="sha512-AgWDJkG13uHcgm8NoCl1qcTk5gml73x2ZAkIe7ljOgT/pRdYYLbcGG1cY8GDOEQt/se3kdBf8t6IaAl8XFPOiw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/js/functions.js') }}"></script>
    @stack('post-scripts')

    <!-- Toastr -->
    <script src="{{ asset('frontend/plugins/toastr/toastr.js') }}"></script>
    <script>

        $(".btn-add-to-wishlist").click(function(){

            var productColorId = $(this).data("product-color-id");

            add_to_wishlist(productColorId);

        });

        function add_to_wishlist(product_color_id) {

            $.ajax({
                url : "{{ URL::route('add-to-wishlist') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        product_color_id: product_color_id
                    },
                beforeSend: function(){                

                },
                success : function(response)
                {
                    var obj = jQuery.parseJSON(response);

                    if (obj.status=='success') {

                        toastr['success']('Product added to Wishlist Successfully!');

                    }else if (obj.status=='exist') {

                        toastr['warning']('Product already exists in your Wishlist!');

                        $('#wishlistItems').load(document.URL + ' #wishlistItems>*');

                    }else if (obj.status=='error') {

                        toastr['error']('Something went wrong!');

                    }else if(obj.status == 'login-error') {
                        
                        toastr['error']('Please Login First!');

                    }else if(obj.status == 'not-a-customer') {

                        toastr['error']('You must be logged in as a customer!!');

                    };
                }
            });
        }

        function cartDelete(cart_item_id) {

            $.ajax({
                url: "{{ URL::route('delete-cart-item') }}",
                type: "POST",
                data: {
                    '_token': '{{ csrf_token() }}',
                    action: 'delete',
                    item_id: cart_item_id
                },
                beforeSend: function () {
                    $('#modal-loader').show();
                },
                success: function (response) {
                    // console.log("success");
                    // console.log("response " + response);
                    $('#modal-loader').hide();
                    var obj = jQuery.parseJSON(response);

                    if (obj.status == 'deleted') {
                        var totalQty = obj.totalQty;

                        $('.item-count').html(obj.total_qty);
                        $('.cart-total-price').html(obj.total_price);
                        $(".cart-item-"+cart_item_id).remove();
                        // $('#miniCart').load(document.URL + ' #miniCart>*');
                        // $('#cartTable').load(document.URL + ' #cartTable>*');

                        toastr['error']('Product Removed from Cart!');


                    }
                    ;
                }
            });
        }
    </script>

    <script type="text/javascript">
        toastr.options.timeOut = "4000";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.preventDuplicates= true;
        toastr.options.progressBar= true;

    </script>
    {{-- <script>
        toastr['success']('Item Added to Cart Successfully', 'Success!');
    </script> --}}
    @if (session('status'))
        <script>
            toastr['success']('{{ session('status') }}', 'Success!');
        </script>
    @elseif (session('error'))
        <script>
            toastr['error']('{{ session('error') }}');
        </script>

    @elseif (session('log_status'))
        <script>
            toastr['error']('{{ session('log_status') }}', '');
        </script>
    @elseif (session('stock_error'))
        <script>
            toastr['error']('{{ session('stock_error') }}', '');
        </script>

    @elseif (session("parent_status"))
        <script>
            toastr['error']('{{ session("parent_status")["secondary"] }}', '{{ session("parent_status")["primary"] }}');
        </script>

    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $key=>$error)
            <script>
                toastr['error']('{{ $error }}');
            </script>
        @endforeach

        <script>
            var $alert = $('.cart-alert-message');
            $alert.hide();

            var i = 0;
            setInterval(function () {
                $($alert[i]).show();
                $($alert[i]).addClass('flipInX');
                i++;
            }, 500);

            // $(".cart-alert-message").fadeTo((($alert.length)+1)*1000, 0.1).slideUp('slow');
            setTimeout(function () {
                $('.cart-alert-message').addClass('fadeOutRight');
            }, $alert.length * ($alert.length == 1 ? 5000 : 2000));
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $("#toogle").click(function () {
                $("#foot-sho-hide").toggle();
                $('.arrow').toggleClass('transform-active');
            });

            number = $("#whatsappNumber").val();
            uri = $("#currentUri").val();

            if ($( window ).width() < 769) {
                
                $(".whatsappLink").attr('href','https://api.whatsapp.com/send?phone='+number);
            }else{

                $(".whatsappLink").attr('href','https://web.whatsapp.com/send?phone='+number);
            }

        });
    </script>
    
    

</body>

</html>