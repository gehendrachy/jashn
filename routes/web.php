<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/create-shipment', 'HomeController@create_shipment')->name('create-shipment');
    Route::get('/print-label', 'HomeController@print_label')->name('print-label');

    Route::get('/sitemap.xml','HomeController@sitemap')->name('sitemap');
    Route::post('see-more-trending-products', 'HomeController@see_more_trending_products')->name('see-more-trending-products');
    Route::get('/category/{slug}', 'HomeController@category_products')->name('category-products');

    Route::get('/product/{slug}', 'HomeController@product_details')->name('product-details');
    Route::post('view-size-guide', 'HomeController@view_size_guide')->name('view-size-guide');
    Route::post('get-related-sizes', 'HomeController@get_related_sizes')->name('get-related-sizes');
    Route::post('add-to-cart', 'CartController@add_to_cart')->name('add-to-cart');
    
    Route::get('search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
    
    Route::post('see-more-products', [App\Http\Controllers\HomeController::class, 'see_more_products'])->name('see-more-products');

    Route::get('/offer/{slug}', [App\Http\Controllers\HomeController::class, 'offer'])->name('offer');
    Route::get('/occassion/{slug}', [App\Http\Controllers\HomeController::class, 'occassion'])->name('occassion');

    Route::post('/buy-cart', 'OrderController@buyNow')->name('buy-now');
    Route::get('cart', 'CartController@cart')->name('cart');
    Route::post('update-cart', 'CartController@update_cart')->name('update-cart');
    Route::post('delete-cart-item', 'CartController@delete_cart_item')->name('delete-cart-item');
    

    Route::post('apply-coupon', 'CartController@apply_coupon')->name('apply-coupon');
    Route::get('checkout', 'CartController@checkout')->name('checkout');
    Route::get('/checkout-login', 'CartController@checkoutProcess')->name('checkout-process');
    Route::post('/checkout-save-details', 'CartController@checkoutSaveDetails')->name('checkout-save-details');
    Route::get('/checkout-confirmation', 'CartController@checkoutConfirmation')->name('checkout-confirmation');

    Route::post('place-order', 'OrderController@place_order')->name('place-order');
    Route::post('get-cities-checkout', 'CartController@get_cities')->name('get-cities-checkout');
    
    Route::get('checkout-success/{order_no}', 'OrderController@checkout_success')->name('checkout-success');
    

    Route::post('add-to-wishlist', 'CustomerController@add_to_wishlist')->name('add-to-wishlist');

    Route::get('user/login', 'HomeController@login')->name('user.login');
    Route::get('user/register', 'HomeController@register')->name('user.register');

    Route::get('login/{provider}', 'SocialLoginRegisterController@redirect')->name('social.login');
    Route::get('login/{provider}/callback', 'SocialLoginRegisterController@callback')->name('social.login.callback');

    Route::post('get-states', 'HomeController@get_states')->name('get-states');
    Route::post('get-districts', 'HomeController@get_districts')->name('get-districts');
    Route::post('get-cities', 'HomeController@get_cities')->name('get-cities');
    Route::post('check-cod-availability', 'HomeController@check_cod_availability')->name('check-cod-availability');
    Route::post('get-shipping-pincode', [App\Http\Controllers\HomeController::class, 'get_shipping_pincode'])->name('get-shipping-pincode');
    Route::post('get-billing-pincode', [App\Http\Controllers\HomeController::class, 'get_billing_pincode'])->name('get-billing-pincode');

    Route::post('get-url-with-price', 'HomeController@get_url_with_price')->name('get-url-with-price');
    Route::post('get-search-url-with-price', 'HomeController@get_search_url_with_price')->name('get-search-url-with-price');

    Route::post('store-product-review', 'HomeController@store_product_review')->name('store-product-review');

    Route::get('about/{type}', 'HomeController@about')->name('quick-links');
    Route::get('contact-us', 'HomeController@contact_us')->name('contact-us');

    // Email verification
    Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('/email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
    Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    
    Route::post('/verify/otp', 'Auth\OTPController@verifyOTP')->name('verify-otp');
    Route::get('/resend/otp', 'Auth\OTPController@resendOTP')->name('otp.resend');

    Route::post('/login', 'UserAuthController@login')->name('login');
    Route::post('/register', 'UserAuthController@register')->name('register');
    
   
    Route::get('/password-reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot');
    Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgot-send');
    Route::get('/password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('verification.reset');
    Route::post('/password/reset', 'Auth\ResetPassword@reset')->name('password.reset');

    Route::get('/admin/login', 'Auth\LoginController@loginForm')->name('admin.login');
    Route::post('/securelogin', 'Auth\LoginController@login')->name('securelogin');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::post('/checkout/payment/thank-you', 'PaymentController@thank_you')->name('nic.thank-you');
    Route::get('/checkout/payment/custom', 'PaymentController@custom')->name('nic.custom');

    Route::get('/checkout/{order_no}/payment-status/{status}', 'PaymentController@payment_status')->name('nic.payment-status');

    // Customer Routes
    Route::name('customer.')->middleware(['auth', 'role:customer', 'verified'])->prefix('customer/')->group(function () {
        

        Route::get('account/profile','CustomerController@my_account')->name('my-account');
        Route::get('information','CustomerController@account_information')->name('information');
        Route::post('information/update','CustomerController@update_account_information')->name('update-account-information');
        Route::get('addresses','CustomerController@customer_addresses')->name('addresses');

        Route::post('store-new-address','CustomerController@store_new_address')->name('store-new-address');
        Route::post('edit-saved-address','CustomerController@edit_saved_address')->name('edit-saved-address');
        Route::post('update-saved-address','CustomerController@update_saved_address')->name('update-saved-address');
        Route::post('make-default-address','CustomerController@make_default_address')->name('make-default-address');

        Route::get('change-default-address','CustomerController@change_default_address')->name('change-default-address');

        // Route::post('create-update-addresses','CustomerController@create_update_addresses'])->name('create-update-addresses');

        Route::get('orders','CustomerController@orders')->name('orders');
        Route::get('view/order/{order_no}','CustomerController@view_order')->name('view-order');

        Route::get('wishlist','CustomerController@wishlist')->name('wishlist');
        Route::post('remove-from-wishlist', 'CustomerController@remove_from_wishlist')->name('remove-from-wishlist');
        Route::get('available-coupons','CustomerController@available_coupons')->name('available-coupons');

        Route::get('return-requests','CustomerController@return_requests')->name('return-requests');
        Route::get('create-return-request','CustomerController@create_return_request')->name('create-return-request');
        Route::post('store-return-request', 'CustomerController@store_return_request')->name('store-return-request');
        Route::post('get-related-ordered-products', 'CustomerController@get_related_ordered_products')->name('get-related-ordered-products');

        Route::post('post-return-request', 'CustomerController@post_return_request')->name('post-return-request');
        Route::get('view/return-request/{return_request_no}','CustomerController@view_return_request')->name('view-return-request');

        Route::get('pay-now/{order_no}', 'CustomerController@pay_now')->name('pay-now');
        
    });
    // Customer Routes End

    // Admin Routes
    Route::middleware(['auth'])->namespace('Backend')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/', 'DashboardController@index')->name('index');

        Route::post('products/show-related-sizes', 'ProductController@show_related_sizes')->name('products.show-related-sizes');
        Route::post('/delete-gallery-image', 'ProductController@delete_gallery_image')->name('products.delete-gallery-image');

        Route::get('products/delete/{id}', 'ProductController@destroy')->name('products.delete');
        Route::get('roles/delete/{id}', 'RolePermissionController@destroy')->name('roles.delete');
        
        Route::get('/products/{product_id}/variation/delete/{color_id}', 'ProductController@deleteVariation')->name('products.variation.delete');
         Route::get('products/add-color/{index}', 'ProductController@addColor')->name('products.add-color');
        Route::post('products/get-variation-details', 'ProductController@getVariationDetails')->name('products.get-variation-details');
        Route::get('products/out-of-stock', 'ProductController@outOfStockProducts')->name('products.out-of-stock');
        Route::get('products/inactive', 'ProductController@inactiveProducts')->name('products.inactive');

        Route::post('orders/change-order-status', 'OrderController@change_order_status')->name('orders.change-order-status');

        Route::post('orders/change-ordered-product-status', 'OrderController@change_ordered_product_status')->name('orders.change-ordered-product-status');

        Route::post('orders/change-selected-ordered-product-status', 'OrderController@change_selected_ordered_product_status')->name('orders.change-selected-ordered-product-status');

        Route::post('orders/save-order-note', 'OrderController@save_order_note')->name('orders.save-order-note');

        Route::post('orders/change-payment-select', 'OrderController@change_payment_select')->name('orders.change-payment-select');

        Route::post('orders/cancel-ordered-product', 'OrderController@cancel_ordered_product')->name('orders.cancel-ordered-product');


        Route::post('return-requests/change-return-request-status', 'ReturnRequestController@change_return_request_status')->name('return-requests.change-return-request-status');

        Route::post('return-requests/change-return-request-product-status', 'ReturnRequestController@change_return_request_product_status')->name('return-requests.change-return-request-product-status');

        Route::post('products/edit-product-variation-stocks', 'ProductController@edit_product_variation_stocks')->name('products.edit-product-variation-stocks');

        Route::post('products/update-product-variation-stocks', 'ProductController@update_product_variation_stocks')->name('products.update-product-variation-stocks');
        
        Route::post('products/update-product-variation-stocks', 'ProductController@update_product_variation_stocks')->name('products.update-product-variation-stocks');
        Route::get('products/export', 'ProductController@export')->name('products.export');
        Route::get('orders/export', 'OrderController@export')->name('orders.export');
        
        Route::get('rts/export', 'OrderController@exportRts')->name('rts.export');
        Route::get('shipment/export', 'OrderController@exportShipment')->name('shipment.export');

        Route::post('contents/set_order', 'ContentController@set_order')
                    ->name('contents.order');
        Route::get('contents/delete/{id}', 'ContentController@destroy')
                    ->name('contents.delete');

        Route::prefix('sales-reports')->name('reports.')->group(function(){
            Route::get('/', 'ReportController@sales_reports')->name('sales');
        });

        // Route::get('/customers', 'UserController@customers')->name('customers.index');
        Route::resource('roles', 'RolePermissionController')->except(['destroy']);

        Route::resources([
            'roles' => RolePermissionController::class,
            'users' => UserController::class,
            'customers' => CustomerController::class,
            'products' => ProductController::class,
            'sliders'=>SliderController::class,
            'banners'=>BannerController::class,
            'blogs'=>BlogController::class,
            'orders' => OrderController::class,
            'return-requests' => ReturnRequestController::class,
            'contents' => ContentController::class,
            'offers' => OfferController::class,
            'discount-coupons' => DiscountCouponController::class,
        ]);
        
        Route::get('users/delete/{id}', 'UserController@destroy')->name('users.delete');
        
        Route::get('customer/export', 'CustomerController@export')->name('customer.export');
        Route::get('return/export', 'ReturnRequestController@export')->name('return.export');
        
        Route::post('discount-coupons/get-discount-on-items', 'DiscountCouponController@get_discount_on_items')->name('discount-coupons.get-discount-on-items');

        Route::get('discount-coupons/delete/{id}', 'OfferController@destroy')->name('discount-coupons.delete');

        Route::post('offers/get-discount-on-items', 'OfferController@get_discount_on_items')->name('offers.get-discount-on-items');

        Route::get('offers/delete/{id}', 'OfferController@destroy')->name('offers.delete');

        Route::prefix('orders/status')->name('orders.')->group(function(){
            
            Route::get('on-route', 'OrderController@on_route')->name('on-route');

            Route::prefix('on-route')->name('on-route.')->group(function(){
                Route::get('create', 'OrderController@create_on_route')->name('create');
                Route::post('store', 'OrderController@store_on_route')->name('store');

                Route::get('edit/{id}', 'OrderController@edit_on_route')->name('edit');
                Route::put('{on_route}/update', 'OrderController@update_on_route')->name('update');

                Route::get('view/{id}', 'OrderController@view_on_route')->name('view');

                Route::post('change-on-route-status', 'OrderController@change_on_route_status')->name('change-on-route-status');

                Route::post('get-related-ordered-products', 'OrderController@get_related_ordered_products')->name('get-related-ordered-products');
                Route::post('add-more-orders', 'OrderController@add_more_orders')->name('add-more-orders');
                Route::post('add-more-products', 'OrderController@add_more_products')->name('add-more-products');
                Route::post('delete-order', 'OrderController@delete_order')->name('delete-order');
            });
            Route::get('arrived', 'OrderController@arrived')->name('arrived');
            Route::get('canceled', [\App\Http\Controllers\Backend\OrderController::class, 'canceled'])->name('canceled');
            Route::get('returned', [\App\Http\Controllers\Backend\OrderController::class, 'returned'])->name('returned');
            Route::prefix('arrived')->name('arrived.')->group(function(){

                Route::get('view/{id}', 'OrderController@view_arrived')->name('view');
                Route::post('change-arrived-status', 'OrderController@change_arrived_status')->name('change-arrived-status');
                Route::post('change-arrived-product-status', 'OrderController@change_arrived_product_status')->name('change-arrived-product-status');

            });
            // Route::get('arrived/create', 'OrderController@create_arrived')->name('arrived.create');

            Route::get('rts', 'OrderController@rts')->name('rts');
            Route::post('rts/manifest', 'OrderController@manifest')->name('manifest');

            Route::get('shipment', 'OrderController@shipment')->name('shipment');
            Route::post('orders/change-shipment-status', 'OrderController@change_shipment_status')->name('change-shipment-status');

            Route::post('orders/failed-shipment-ordered-product', 'OrderController@failed_shipment_ordered_product')->name('failed-shipment-ordered-product');

        });

        Route::prefix('orders/new')->name('orders.')->group(function(){
            Route::get('add-new-order', 'OrderController@add_new_order')->name('add-new-order');

            Route::get('add-product/{index}', 'OrderController@addProduct')->name('orders.add-product');
            Route::post('get-color', 'OrderController@getColor')->name('get-color');
            Route::post('get-size', 'OrderController@getSize')->name('get-size');
        });

        Route::prefix('logistics')->group(function(){

            Route::resources([
                'countries' => CountryController::class,
                'states' => StateController::class,
                'districts' => DistrictController::class,
                'cities' => CityController::class,
                'couriers'=>CourierController::class,
                'courier-rates'=>CourierRateController::class,
                'cods'=>CODController::class,
                
            ]);

            // Route::get('info-pages/delete/{id}', 'InfoPageController@destroy')
            // ->name('info-pages.delete');

            Route::get('countries/delete/{id}', 'CountryController@destroy')
            ->name('countries.delete');

            Route::get('states/delete/{id}', 'StateController@destroy')
            ->name('states.delete');

            Route::get('districts/delete/{id}', 'DistrictController@destroy')
            ->name('districts.delete');

            Route::get('cities/delete/{id}', 'CityController@destroy')
            ->name('cities.delete');

            Route::get('couriers/delete/{id}', 'CourierController@destroy')
            ->name('couriers.delete-it');

            Route::post('get_related_states', 'CourierRateController@get_related_states')->name('get_related_states');

            Route::post('get_related_city', 'CODController@get_related_city')->name('get_related_city');
            Route::post('get_related_district', 'CODController@get_related_district')->name('get_related_district');

            Route::post('change-cod-availability-status', 'CODController@change_cod_availability_status')->name('cods.change-cod-availability-status');

            // Route::get('info-pages/delete-image/{id}', 'InfoPageController@delete_image')->name('info-pages.delete-image');

            Route::get('cods/delete/{id}', 'CourierController@destroy')
            ->name('cods.delete');

            Route::get('courier-rates/delete/{id}', 'CourierRateController@destroy')
            ->name('courier-rates.delete-it');

            Route::get('courier-rate/filters/', 'CourierRateController@filters')
            ->name('courier-rates.filters');

            Route::post('get-district-courier-rates', 'CourierRateController@get_district_courier_rates')->name('get-district-courier-rates');

            Route::post('create-update-courier-rates', 'CourierRateController@create_update_courier_rates')->name('courier-rates.create-update');
        });

        Route::prefix('product-groups')->group(function(){

            Route::post('categories/set_order', 'CategoryController@set_order')
                    ->name('categories.order');
            Route::get('categories/delete/{id}', 'CategoryController@destroy')
                    ->name('categories.delete');

            Route::post('occassions/set_order', 'OccassionController@set_order')
                    ->name('occassions.order');
            Route::get('occassions/delete/{id}', 'OccassionController@destroy')
                    ->name('occassions.delete');
            
            Route::post('fabrics/set_order', 'FabricController@set_order')
                    ->name('fabrics.order');
            Route::get('fabrics/delete/{id}', 'FabricController@destroy')
                    ->name('fabrics.delete');

            Route::post('colors/set_order', 'ColorController@set_order')
                    ->name('colors.order');
            Route::get('colors/delete/{id}', 'ColorController@destroy')
                    ->name('colors.delete');

            Route::get('product-cares/delete/{id}', 'ProductCareController@destroy')
                    ->name('product-cares.delete');

            Route::post('size-groups/delete-size', 'SizeGroupController@delete_size')->name('size-groups.delete-size');
            Route::get('size-groups/delete/{id}', 'SizeGroupController@destroy')
                    ->name('size-groups.delete');

            Route::post('size-guides/get-sizes', 'SizeGuideController@get_sizes')->name('size-guides.get-sizes');
            Route::post('size-guides/delete-size', 'SizeGuideController@delete_size')->name('size-guides.delete-size');
            Route::get('size-guides/delete/{id}', 'SizeGuideController@destroy')
                    ->name('size-guides.delete');
            Route::post('size-guides/view-size-guide', 'SizeGuideController@view_size_guide')->name('size-guides.view-size-guide');

            Route::post('products/get-sizes', 'SizeGuideController@get_sizes')->name('products.get-sizes');
            
            

            Route::resources([
                'categories' => CategoryController::class,
                'occassions' => OccassionController::class,
                'fabrics' => FabricController::class,
                'colors' => ColorController::class,
                'size-groups' => SizeGroupController::class,
                'size-guides' => SizeGuideController::class,
                'product-cares' => ProductCareController::class
            ]);

        });

        Route::get('/setting', 'SiteSettingController@index')->name('setting')->middleware('can:sitesetting-list');
        Route::post('/setting/update', 'SiteSettingController@update')->name('setting.update')->middleware('can:sitesetting-update');
    });   
});




