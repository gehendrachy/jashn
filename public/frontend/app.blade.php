<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $setting->title }} | @yield('title')</title>
    <meta name="description" content="{{ $setting->meta_description }}">
    <meta name="og:title" content="{{ $setting->og_title }}">
    <meta name="og:description" content="{{ $setting->og_description }}">
    <meta name="og:image" content="{{ asset('storage/setting/og_image/'.$setting->og_image) }}">
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
            integrity="sha512-doJrC/ocU8VGVRx3O9981+2aYUn3fuWVWvqLi1U+tA2MWVzsw+NVKq1PrENF03M+TYBP92PnYUlXFH1ZW0FpLw=="
            crossorigin="anonymous" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
            integrity="sha256-Vzbj7sDDS/woiFS3uNKo8eIuni59rjyNGtXfstRzStA=" crossorigin="anonymous" /> -->
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
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
        }
        .ribbon3 {
            width: 100px;
            height: 32px;
            line-height: 32px;
            padding-left: 23px;
            position: absolute;
            color: #fff;
            /*font-weight: 700;*/
            letter-spacing: 0.5px;
            left: -10px;
            top: 15px;
            z-index: 8;
            opacity: 0.75
        }

        .ribbon3:before,
        .ribbon3:after {
            content: "";
            position: absolute;
        }

        .ribbon3:before {
            height: 0;
            width: 0;
            top: -8.5px;
            left: 0.1px;
            border-bottom: 9px solid black;
            border-left: 9px solid transparent;
        }

        .ribbon3:after {
            height: 0;
            width: 0;
            right: -14.5px;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            /*border-left: 14px solid #7b7b7b;*/
        }
        .sold-out{            
            background: #7b7b7b;

        }.sold-out:after {
            border-left: 14px solid #7b7b7b;
        }
        .in-stock{            
            background: #2c7a53;
        }
        .in-stock:after {
            border-left: 14px solid #2c7a53;
        }
        .pre-order{            
            background: #653814;
        }
        .pre-order:after {
            border-left: 14px solid #653814;
        }
        #footer {
            background-color: #fafafa;
            border-top: 4px solid #eaeaea;
            border-bottom: 6px solid #eaeaea;
        }

        .footer-title,
        .footer-list li a {
            color: #131313;
        }

        .boxed-footer {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            justify-content: flex-start;
            flex-wrap: wrap;
            padding: 30px 0;

        }

        .boxed-footer .boxed-footer-box {
            width: 50%;
            border: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 15px 40px;
            background-color: #fff;
        }

        .footer-social-end li a {
            color: #131313;
        }

        .footer-pay {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            list-style-type: none;
            flex-wrap: wrap;
            padding: 8px 24px;
        }

        .footer-pay li img {
            height: 24px;
            width: auto;
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .final-list {
            text-align: center;
            list-style-type: none;
        }

        .final-list li {
            display: inline-block;
            padding: 2px 6px;
            position: relative;
        }

        .final-list li:before {
            content: '-';
            position: absolute;
            top: 50%;
            right: -5px;
            transform: translateY(-40%);
        }

        .final-list li:last-of-type::before {
            display: none;
        }

        .final-list li a {
            font-size: 13px;
            display: inline-block;
        }

    </style>
</head>

<body>
    <div id="modal-loader" >
        <div class="loadingio-spinner-eclipse-5n5ocxxlhe2">
            <div class="ldio-shhdvnglxrk">
                <div></div>
            </div>
        </div>
    </div>
    <nav>
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
                                                <a href="javascript:void(0)" class="{{ $item->parent_id == 0 ? 'main-menu' : 'has-sub' }}">{{ $item->title }} <i class="fa {{ $item->parent_id == 0 ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i></a>
                                                
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
                        <li>
                            <a href="javascript:void(0);" class="main-menu">Offers <i
                                    class="fa fa-chevron-down"></i></a>
                            <div class="menu-level-one">
                                <ul class="sub-level-one">
                                    <li><a href="categories.html">Topwear</a></li>
                                    <li><a href="categories.html">Bottomwear</a></li>
                                    <li><a href="categories.html">Footwear</a></li>
                                    <li><a href="categories.html">Innerwear & Sleepwear</a></li>
                                    <li><a href="categories.html">Sports & Activewear</a></li>
                                    <li><a href="categories.html">Fashion Accessories</a></li>
                                    <li><a href="categories.html">Plus Size</a></li>
                                    <li><a href="categories.html">Offers & Occassion</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="has-search" id="search">
                    <div class="search-wrapper">
                        <form action="">
                            <div class="search-group ui-widget">
                                <input type="text" class="input-style" placeholder="Search Here..." id="main-search">
                                <!-- <p id="empty-message"></p> -->
                                <button><i class="fa fa-search nav-search-icon"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="end-icons">
                    <div class="cart-wrapper">
                        <a href="" class="nav-button">
                            <i class="ti-shopping-cart"></i>
                            <span>My Cart</span>
                        </a>
                    </div>
                    @if(!Auth::check())
                        <div class="login-wrapper">
                            <a href="{{ route('user.login') }}" class="nav-button">
                                <i class="ti-user"></i>
                                <span>Login</span>
                            </a>
                        </div>
                    @else
                        
                        <div class="login-wrapper">
                            <a href="{{ route('customer.my-account') }}" class="nav-button">
                                <i class="ti-user"></i>
                                <span>My Profile</span>
                            </a>
                        </div>

                        <div class="login-wrapper">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-button">
                                <i class="fa fa-sign-out-alt"></i>
                                <span>Log Out</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                    @endif
                </div>

                <div class="" id="occassion">
                    <div class="toggle-menu">
                        <i class="ti-gift"></i> <span>Occassion</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="responsive-menu">
        <ul class="mobile-menu">
            <h5>Categories <span class="close-menu"><i class="ti ti-close"></i></span></h5>
            <hr>
            <li>
                <a href="javascript:void(0);" class="mobile-main-menu">Mens <i class="fa fa-chevron-down"></i></a>
                <div class="mobile-menu-level-one">
                    <ul class="mobile-sub-level-one">
                        <li>
                            <a href="javascript:void(0);" class="has-sub">Topwear <i
                                    class="fa fa-chevron-right"></i></a>
                            <div class="mobile-menu-level-two">
                                <ul class="mobile-sub-level-two">
                                    <li>
                                        <a href="categories.html" class="has-sub">T-Shirts
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                        <div class="mobile-menu-level-three">
                                            <ul class="mobile-sub-level-three">
                                                <li><a href="categories.html">Casual Shirts</a></li>
                                                <li><a href="categories.html">Formal Shirts</a></li>
                                                <li><a href="categories.html">Sweat Shirts</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li><a href="categories.html">Casual Shirts</a></li>
                                    <li><a href="categories.html">Formal Shirts</a></li>
                                    <li><a href="categories.html">Sweat Shirts</a></li>
                                    <li><a href="categories.html">Sweaters</a></li>
                                    <li><a href="categories.html">Jackets</a></li>
                                    <li><a href="categories.html">Blazers & Coats</a></li>
                                    <li><a href="categories.html">Suits</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="has-sub">Bottomwear <i
                                    class="fa fa-chevron-right"></i></a>
                            <div class="mobile-menu-level-two">
                                <ul class="mobile-sub-level-two">
                                    <li><a href="categories.html">Jeans</a></li>
                                    <li><a href="categories.html">Casual Trousers</a></li>
                                    <li><a href="categories.html">Formal Trousers</a></li>
                                    <li><a href="categories.html">Shorts</a></li>
                                    <li><a href="categories.html">Track Pants & Joggers</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="categories.html">Footwear</a></li>
                        <li><a href="categories.html">Innerwear & Sleepwear</a></li>
                        <li><a href="categories.html">Sports & Activewear</a></li>
                        <li><a href="categories.html">Fashion Accessories</a></li>
                        <li><a href="categories.html">Plus Size</a></li>
                        <li><a href="categories.html">Offers & Occassion</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" class="mobile-main-menu">Womens <i class="fa fa-chevron-down"></i></a>
                <div class="mobile-menu-level-one">
                    <ul class="mobile-sub-level-one">
                        <li><a href="categories.html">Topwear</a></li>
                        <li><a href="categories.html">Bottomwear</a></li>
                        <li><a href="categories.html">Footwear</a></li>
                        <li><a href="categories.html">Innerwear & Sleepwear</a></li>
                        <li><a href="categories.html">Sports & Activewear</a></li>
                        <li><a href="categories.html">Fashion Accessories</a></li>
                        <li><a href="categories.html">Plus Size</a></li>
                        <li><a href="categories.html">Offers & Occassion</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" class="mobile-main-menu">Kids <i class="fa fa-chevron-down"></i></a>
                <div class="mobile-menu-level-one">
                    <ul class="mobile-sub-level-one">
                        <li><a href="categories.html">Topwear</a></li>
                        <li><a href="categories.html">Bottomwear</a></li>
                        <li><a href="categories.html">Footwear</a></li>
                        <li><a href="categories.html">Innerwear & Sleepwear</a></li>
                        <li><a href="categories.html">Sports & Activewear</a></li>
                        <li><a href="categories.html">Fashion Accessories</a></li>
                        <li><a href="categories.html">Plus Size</a></li>
                        <li><a href="categories.html">Offers & Occassion</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" class="mobile-main-menu">Offers <i class="fa fa-chevron-down"></i></a>
                <div class="mobile-menu-level-one">
                    <ul class="mobile-sub-level-one">
                        <li><a href="categories.html">Topwear</a></li>
                        <li><a href="categories.html">Bottomwear</a></li>
                        <li><a href="categories.html">Footwear</a></li>
                        <li><a href="categories.html">Innerwear & Sleepwear</a></li>
                        <li><a href="categories.html">Sports & Activewear</a></li>
                        <li><a href="categories.html">Fashion Accessories</a></li>
                        <li><a href="categories.html">Plus Size</a></li>
                        <li><a href="categories.html">Offers & Occassion</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
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
        <div class="before-footer">
        <div class="container">
            <div class="col-sm-8 offset-sm-2">
                <div class="text-center newsletter-wrapper">
                    <h5>Sign Up For Jashn Updates & Emails</h5>
                    <p>Be the first to be notified about our offers, deals & events.</p>
                    <div class="subscription-box">
                        <input type="text" class="form-control" placeholder="Email Address" />
                        <button>Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <div class="container">
            <!--<div class="row">-->
            <!--    <div class="col-sm-12">-->
            <!--        <div class="footer-contact-wrapper">-->
            <!--            <div class="row">-->
            <!--                <div class="col-sm-3">-->
            <!--                    <div class="foot-contact-grid">-->
            <!--                        <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $setting->mobile)}}">-->
            <!--                            <div class="foot-contact-icon">-->
            <!--                                <i class="fa fa-mobile"></i>-->
            <!--                                <p> {{ $setting->mobile }}</p>-->
            <!--                            </div>-->
            <!--                            <p class="contact-info">-->
            <!--                                Feel Free to Call us with any queries you have.-->
            <!--                            </p>-->
            <!--                    </div>-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--                <div class="col-sm-3">-->
            <!--                    <div class="foot-contact-grid">-->
            <!--                        <a href="tel:{{ preg_replace("/[^0-9,+]/", "", $setting->phone)}}">-->
            <!--                            <div class="foot-contact-icon">-->
            <!--                                <i class="fa fa-phone-alt"></i>-->
            <!--                                <p> {{ $setting->phone }}</p>-->
            <!--                            </div>-->
            <!--                            <p class="contact-info">-->
            <!--                                Call our support number if you have any troubles.-->
            <!--                            </p>-->
            <!--                    </div>-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--                <div class="col-sm-3">-->
            <!--                    <div class="foot-contact-grid">-->
            <!--                        <a href="mailto:{{ $setting->email }}">-->
            <!--                            <div class="foot-contact-icon">-->
            <!--                                <i class="fa fa-envelope"></i>-->
            <!--                                <p>{{ $setting->email }}</p>-->
            <!--                            </div>-->
            <!--                            <p class="contact-info">-->
            <!--                                Drop us an email if you have any questions or any suggestions.-->
            <!--                            </p>-->
            <!--                    </div>-->
            <!--                    </a>-->
            <!--                </div>-->

            <!--                <div class="col-sm-3">-->
            <!--                    <div class="foot-contact-grid">-->
            <!--                        <a target="_blank" href="#" class="whatsappLink">-->
            <!--                            <div class="foot-contact-icon">-->
            <!--                                <i class="fab fa-whatsapp"></i>-->
            <!--                                <p>{{ $setting->mobile_whatsapp }}</p>-->
            <!--                            </div>-->
            <!--                            <p class="contact-info">-->
            <!--                                Don't Hesitate to chat with us through our whatsapp support.-->
            <!--                            </p>-->
            <!--                    </div>-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="actual-footer">
                <div class="container">
                    <div class="row">
                         <div class="col-sm-3">
                            <p class="footer-title">Contact Info</p>
                            <ul class="footer-list">
                                <li>
                                    <a href="tel:9841327018"><small><i class="fa fa-phone-alt"></i></small> 9841327018</a>
                                </li>
                                <li>
                                    <a href="tel:9802790090"><small><i class="fa fa-mobile"></i></small> 9802790090</a>
                                </li>
                                <li>
                                    <a href="mailto:jashn@shopatjashn.com"><small><i class="fa fa-envelope"></i></small> jashn@shopatjashn.com</a>
                                </li>
                                <!-- <li>
                                        <a href="#"><small><i class="fab fa-whatsapp"></i></small> +977 9814327018</a>
                                    </li> -->
                            </ul>
                        </div>
                        <div class="col-sm-3">
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
                        <div class="col-sm-3">
                            <p class="footer-title">Account</p>
                            <ul class="footer-list">
                                <li>
                                     <a href="{{ route('quick-links',['type' => 'return-policy']) }}">Return A Product</a>
                                </li>
                                @if(Auth::check())
                                    <li>
                                        <a href="{{ route('customer.my-account') }}">My Account</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customer.wishlist') }}">My Wishlist</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('user.login') }}">Log In</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.register') }}">Register</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-sm-3">
                            <p class="footer-title">Quick Links</p>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{ route('quick-links',['type' => 'jashn']) }}">About Jashn</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact-us') }}">Contact Us</a>
                                </li>
                                <li>
                                    <a href="#">Jashn Prime</a>
                                </li>
                            </ul>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        <!--<div class="col-sm-3">-->
                        <!--    <p class="footer-title">Quick Links</p>-->
                        <!--    <ul class="footer-list">-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('quick-links',['type' => 'jashn']) }}">About Jashn</a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('contact-us') }}">Contact Us</a>-->
                        <!--        </li>-->
                        <!--        {{-- <li>-->
                        <!--            <a href="#">Sitemap</a>-->
                        <!--        </li> --}}-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('quick-links',['type' => 'faq']) }}">FAQs</a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <!--<div class="col-sm-3">-->
                        <!--    <p class="footer-title">Our Policies</p>-->
                        <!--    <ul class="footer-list">-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('quick-links',['type' => 'return-policy']) }}">Return Policy</a>-->
                        <!--        </li>-->
                        <!--        {{-- <li>-->
                        <!--            <a href="#">Request Return</a>-->
                        <!--        </li> --}}-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('quick-links',['type' => 'terms-and-conditions']) }}">Terms & Conditions</a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a href="{{ route('quick-links',['type' => 'payment-policy']) }}">Payment Policy</a>-->
                        <!--        </li>-->
                        <!--    </ul>-->
                        <!--</div>-->
                        <!--<div class="col-sm-3">-->
                        <!--    <p class="footer-title">Support</p>-->
                        <!--    <ul class="footer-list">-->
                        <!--        {{-- <li>-->
                        <!--            <a href="#">Jashn Prime</a>-->
                        <!--        </li> --}}-->
                        <!--        <li>-->
                        <!--            <a href="#">How to Order</a>-->
                        <!--        </li>-->
                        <!--        <li>-->
                        <!--            <a href="{{ $setting->youtubeurl }}">Youtube Channel</a>-->
                        <!--        </li>-->

                                <!-- <li>
                        <!--            <a href="#">Privacy Policy</a>-->
                        <!--        </li> -->
                        <!--    </ul>-->
                        <!--</div>-->
                        <!--<div class="col-sm-3">-->
                        <!--    <p class="footer-title">Account</p>-->
                        <!--    <ul class="footer-list">-->
                        <!--        @if(Auth::check())-->
                        <!--            <li>-->
                        <!--                <a href="{{ route('customer.my-account') }}">My Account</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="{{ route('customer.wishlist') }}">My Wishlist</a>-->
                        <!--            </li>-->
                        <!--        @else-->
                        <!--            <li>-->
                        <!--                <a href="{{ route('user.login') }}">Log In</a>-->
                        <!--            </li>-->
                        <!--            <li>-->
                        <!--                <a href="{{ route('user.register') }}">Register</a>-->
                        <!--            </li>-->
                        <!--        @endif-->
                        <!--    </ul>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
            <!--<div class="text-center follow-text" style="padding:10px 0;">-->
            <!--     <p class="footer-title">Follow Us</p>-->
            <!--     <ul class="footer-social-end">-->
            <!--            <li>-->
            <!--                <a target="_blank" href="{{ $setting->facebookurl }}">-->
            <!--                    <i class="fab fa-facebook"></i>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--                <a target="_blank" href="{{ $setting->instagramurl }}">-->
            <!--                    <i class="fab fa-instagram"></i>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            {{-- <li>-->
            <!--                <a target="_blank" href="{{ $setting->linkedinurl }}">-->
            <!--                    <i class="fab fa-linkedin"></i>-->
            <!--                </a>-->
            <!--            </li> --}}-->
            <!--            <li>-->
            <!--                <a target="_blank" href="{{ $setting->twitterurl }}">-->
            <!--                    <i class="fab fa-twitter"></i>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--                <a target="_blank" href="{{ $setting->youtubeurl }}">-->
            <!--                    <i class="fab fa-youtube"></i>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <!--</div>-->
           
        </div>
        <div class="boxed-footer">
            <div class="boxed-footer-box">
                <p class="mb-0"><strong>Returning an item</strong></p>
                <p>We've updated our return policies in response to recent update. Read our <a href="#">Return
                        Policy</a></p>
            </div>
            <div class="boxed-footer-box">
                <p class="mb-0"><strong>Payment Methods</strong></p>
                <ul class="footer-pay">
                    <li>
                        <img src=" {{ asset('frontend/images/visa.png') }}" alt="">
                    </li>

                    <li>
                        <img src="{{ asset('frontend/images/esewa.png') }}" alt="">
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/khalti.svg') }}" alt="">
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/Fonepay.png') }}" alt="">
                    </li>
                </ul>
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
                        <a target="_blank" href="{{ $setting->linkedinurl }}">
                             <i class="fab fa-linkedin"></i>
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
                <p class="mb-0"><strong><i class="fab fa-whatsapp"></i>&nbsp;&nbsp;Whatsapp Support</strong></p>
                <p class="lead"><strong><a href="tel:+977 9814327018"><small></small> +977
                            9814327018</a></strong></p>
            </div>
        </div>
        <ul class="final-list">
            <li>
                <a href="{{ route('quick-links',['type' => 'return-policy']) }}">Return Policy</a>
            </li>
            <li>
                <a href="{{ route('quick-links',['type' => 'terms-and-conditions']) }}">Terms & Conditions</a>
            </li>
            <li>
                <a href="{{ route('quick-links',['type' => 'payment-policy']) }}">Payment Policy</a>
            </li>
        </ul>
        <hr>
        <p class=" text-center mb-0">
            @Jashn - {{ date('Y') }}. All Rights Reserved by
        </p>
        <p class="text-center">
            Coded with <i class="fa fa-heart" style="color:#880808"></i>
            by <a target="_blank" href="https://ktmrush.com">KTMRush</a>
        </p>
    </footer>

    <!--<div class="footend pt16 pb16">-->
    <!--    <div class="container">-->
    <!--        <div class="row align-items-center">-->
                
    <!--            <div class="col-sm-4">-->
    <!--                 <p class="text-lg-left text-center">-->
    <!--                    @All Rights Reserved by Jashn - {{ date('Y') }}-->
    <!--                </p>-->
    <!--            </div>-->
    <!--            <div class="col-sm-4">-->
    <!--                <p class="text-center">-->
    <!--                    <img src="{{ asset('frontend/images/payment.png') }}" height="24px" alt="jashn-payment">-->
    <!--                </p>-->
    <!--            </div>-->
    <!--            <div class="col-sm-4">-->
    <!--                <p class="text-lg-right text-center">-->
    <!--                    Coded with <i class="fa fa-heart" style="color:#880808"></i> -->
    <!--                    by <a target="_blank" href="https://ktmrush.com">KTMRush</a>-->
    <!--                </p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
   
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

                            <a href="javascript:void(0)" class="cart-action" onclick="cartDelete('{{ $item['cart_id'] }}')">
                                <i class="fa fa-times"></i>
                            </a>

                            <div class="cart-image">
                                <img src="{{ asset('storage/products/'.$cProd->slug.'/variations/thumbs/thumb_'.$product_color->image) }}" alt="{{ $cProd->slug }}">
                            </div>

                            <div class="cart-details">
                                <h6><a href="{{ route('product-details',['slug' => $cProd->slug, 'c' => $product_color->color->code]) }}">{{ $cProd->title }}</a></h6>

                                <div class="mx-auto">
                                    <p>
                                        Color Family : {{ $product_color->color->title }}, Size : {{ $product_size->size->name }}
                                    </p>
                                </div>

                                <p>Quantity : <span class="item-quantity-{{ $key }}">{{ $item['ordered_qty'] }}</span></p>

                                <p class="cart-price">Nrs. <span class="sub-total-{{ $key }}">{{ $item['sub_total'] }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="cart-total">
                    <div>Total : </div>
                    <div><strong>Nrs {{ $total_price }}</strong></div>
                </div>
                <hr>
                <div class="text-right">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-equal-height.min.js') }}"></script>
    <script src="{{ asset('frontend/js/functions.js') }}"></script>
    @stack('post-scripts')

    <!-- Toastr -->
    <script src="{{ asset('frontend/plugins/toastr/toastr.js') }}"></script>
    <script>

        $(".btn-add-to-wishlist").click(function(){

            var productId = $(this).data("product-id");

            add_to_wishlist(productId);

        });

        function add_to_wishlist(product_id) {

            $.ajax({
                url : "{{ URL::route('add-to-wishlist') }}",
                type : "POST",
                data :{ '_token': '{{ csrf_token() }}',
                        product_id: product_id
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
        toastr.options.positionClass = 'toast-top-right';
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
                $("#footer").toggle();
                $(".footend").toggle();
                $(".before-footer").toggle();
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