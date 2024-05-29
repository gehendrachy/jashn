<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductColor;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\COD;
use App\Models\ProductCare;
use App\Models\Content;
use App\Models\Offer;
use App\Models\ProductSize;
use App\Models\SizeGuide;
use App\Models\Order;
use App\Models\Occassion;
use App\Services\ModelHelper;
use App\Services\ProductPaginator;
use Illuminate\Support\Facades\Validator;
use SoapClient;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        
        $sliders = Slider::where('display',1)->get();
        $banners = Banner::all();
        $product_color_variations = ProductColor::has('product')->where('status',1)->inRandomOrder()->limit(8)->get();


        // dd($product_variations);
        // $products = Product::where('display',1)->inRandomOrder()->limit(8)->get();
        // dd($products);
        return view('home', compact('sliders', 'banners', 'product_color_variations'));
    }

    public function category_products($slug)
    {
        // $url = 'http://127.0.0.1:8000/category/formal-shirts?color[]=3&color[]=2&size[]=1&size[]=6';
        // parse_str(parse_url($url, PHP_URL_QUERY), $attributes);

        // dd($attributes);
        $category = Category::with('products.product_variations.color')->where('slug',$slug)->first();
        
        if($category->child != 0){
            
            $allcategory = Category::where('parent_id',$category->id)->pluck('id');
            
          
            
            $category = Category::with('products.product_variations.color')->whereIn('id', $allcategory)->first();
            
            
                
            
        }
        
        

        if (!$category) {
            return redirect()->back()->with('error', 'Category Not Found!');
        }

        // $category_products = $category->products()->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();

        // $category_products = ProductColor::whereHas('product', function(Builder $query) use ($category){
        //                                         $query->where('category_id', $category->id);
        //                                     })->where('status',1)->inRandomOrder()->get();

        $product_size_variations = ProductSize::whereHas('product_color', function(Builder $query) use ($category){

                                            $query->whereHas('product', function(Builder $query) use ($category){
                                                $query->where([['display',1],['category_id', $category->id]]);
                                            });

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();


        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');
        // dd($product_color_variations);
        $min_price = $product_size_variations->min('final_price');
        $max_price = $product_size_variations->max('final_price');

        $filter_colors = $product_color_variations->unique('color_id')->pluck('color')->sortBy('id')->all();
        $filter_sizes = $product_size_variations->unique('size_id')->pluck('size')->sortBy('id')->all();
        $filter_occassions = $product_color_variations->pluck('product.occassions')->flatten()->unique('id')->all();

        $filter_fabrics = $product_color_variations->pluck('product.fabrics')->flatten()->unique('id')->all();
        // dd($filter_fabrics);
        $filter_delivery_times = $product_size_variations->unique('preorder')->pluck('preorder')->all();
        $filter_genders = $product_color_variations->pluck('product')->unique('gender')->pluck('gender')->all();
        

        // $products = $category->products;
        // $products = $category->products()->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');
        $product_size_variations = ProductSize::with('product_color.product')
                                        ->whereHas('product_color', function(Builder $query) use ($category){

                                            $query->whereHas('product', function(Builder $query) use ($category){

                                                $query->where([['display',1], ['category_id', $category->id]]);

                                                if (isset($_GET['occassion'])) {

                                                    $query->whereHas('occassions', function(Builder $query){
                                                        $query->whereIn('occassion_products.occassion_id', $_GET['occassion']);
                                                    });
                                                }
                                                
                                                if (isset($_GET['fabric'])) {

                                                    $query->whereHas('fabrics', function(Builder $query){
                                                        $query->whereIn('fabric_products.fabric_id', $_GET['fabric']);
                                                    });
                                                }


                                                if (isset($_GET['gender'])) {
                                                    $query->whereIn('gender', $_GET['gender']);
                                                }

                                            });

                                            if (isset($_GET['color'])) {
                                                $query->whereIn('color_id', $_GET['color']);
                                            }

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');

        // dd($product_size_variations->get());

        if (isset($_GET['size'])) {
            $product_size_variations->whereIn('size_id', $_GET['size']);
        }

        if (isset($_GET['delivery_time'])) {

            $product_size_variations->where(function($query){

                if (in_array(1, $_GET['delivery_time'])) {
                    
                    $query->where([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);

                    if (in_array(0, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity', '>', 0]]);
                    }

                }elseif (in_array(0, $_GET['delivery_time'])) {

                    $query->where([['quantity', '>', 0]]);
                    
                    if (in_array(1, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);
                    }
                }

            });

        }

        // dd($product_size_variations->get());

        // dd($product_size_variations->orderBy('final_price')->limit(10)->get());

        if (@$_GET['sort'] == 'priceHL') {

            $product_size_variations->orderBy('final_price', 'desc');    

        }elseif (@$_GET['sort'] == 'priceLH') {

            $product_size_variations->orderBy('final_price');

        }

        // $products->selectRaw('IFNULL(offer_price, price) AS final_price')->where('final_price','>',2400);
        // dd($products->get());
        


        $product_size_variations = $product_size_variations->get();

        if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
            
            $product_size_variations = $product_size_variations->whereBetween('final_price', [$_GET['min_price'], $_GET['max_price']]);
        }

        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');

        if (@$_GET['sort'] == 'alphaAZ') {

            $product_size_variations = $product_size_variations->sortBy('product_color.product.title');

        }elseif (@$_GET['sort'] == 'alphaZA') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.title');
        }elseif (@$_GET['sort'] == 'latest') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.id');

        }
        elseif(@$_GET['sort'] == 'oldest'){
            $product_size_variations = $product_size_variations->sortBy('product_color.product.id');
        }

        // if (!isset($_GET['sort'])) {
        //     $product_size_variations = $product_size_variations->sortBy('product_color.product.created_at');
        // }

        $product_size_variations = $product_size_variations->unique('product_color_id');
        // dd($product_size_variations);

        // echo $_GET['min_price'];
        // dd($products->pluck('final_price'));

        // $product_variations = $products->pluck('product_variations')
        
        // Product Pagination =========================================================
        
        $pageDetails = ProductPaginator::get_current_page();
        $currentPage = $pageDetails['currentPage'];
        $perPage = $pageDetails['perPage'];

        $product_size_variations = ProductPaginator::paginate_products($product_size_variations, $currentPage, $perPage);

        $product_size_variations = $product_size_variations->appends(request()->except('page'));

        return view('category-products', compact('category', 'product_size_variations', 'min_price', 'max_price', 'filter_colors', 'filter_sizes', 'filter_occassions', 'filter_fabrics', 'filter_delivery_times', 'filter_genders'));
    }

    public function product_details($slug)
    {

        // session()->flush();
        // session()->save();

        $product = Product::where('slug',$slug)->firstOrFail();

        
        // $offers = Offer::with('products')->where('id', 1)->where('products.id', 11)->get(); 
        // dd($offers);

        // $offer = Offer::check_offer(3, 30000, 12);
        
        // $offers = Offer::where([['start_date', '<=', date('Y-m-d')], ['expire_date', '>=', date('Y-m-d')]])->get();

        // if ($offers->count() > 0) {

        //     $offers = Offer::where('minimum_quantity', '<=', 5)->orWhere('minimum_spend', '<=', 1)->get();

        //     if ($offers->count()) {
                
        //         $offers = Offer::where([['minimum_quantity', '<=', 1],['discount_on', '<=', 3],['offer_type', '!=', 3]])->orWhere([['minimum_spend', '<=', 1],['discount_on', '<=', 3],['offer_type', '!=', 3]])->get();

        //         if ($offers->count() == 0) {
        //             $offers = Offer::where([['minimum_quantity', '<=', 5]])->orWhere([['minimum_spend', '<=', 30000]])
        //                             ->WhereHas('products', function(Builder $query){
        //                                 $query->where('id', 12);
        //                             })
        //                             ->orWhereHas('categories', function(Builder $query){
        //                                 $query->whereHas('products', function(Builder $query){
        //                                     $query->where('id', 12);
        //                                 });
        //                             })->get();

        //             if ($offers->count() > 0) {
        //                 echo "test";
        //                 $valid_offer = Offer::where([['minimum_quantity', '<=', 5]])->orWhere([['minimum_spend', '<=', 30000]])
        //                                 ->WhereHas('products', function(Builder $query){
        //                                     $query->where('id', 12);
        //                                 })
        //                                 ->orWhereHas('categories', function(Builder $query){
        //                                     $query->whereHas('products', function(Builder $query){
        //                                         $query->where('id', 12);
        //                                     });
        //                                 })->first();
        //             }
                    
                    
        //         }else{
        //             echo "string";
        //             $valid_offer = Offer::where([['minimum_quantity', '<=', 1],['discount_on', '<=', 3],['offer_type', '!=', 3]])->orWhere([['minimum_spend', '<=', 1],['discount_on', '<=', 3],['offer_type', '!=', 3]])->orderBy('discount_percentage','desc')->first();
        //         }
        //     }

        //     dd($valid_offer);

        //     if ($offers->count() > 0) {
                
        //         $valid_offer = Offer::where([['discount_on', 3],['offer_type', '!=', 3]])
        //                             ->orWhereHas('products', function(Builder $query){
        //                                 $query->where('id', 12);
        //                             })
        //                             ->orWhereHas('categories', function(Builder $query){
        //                                 $query->whereHas('products', function(Builder $query){
        //                                     $query->where('id', 12);
        //                                 });
        //                             })->orderBy('discount_percentage', 'desc')->pluck('id')->all();
                
        //     }
        // }

        // dd($valid_offer);

        // $offers = Offer::with('products', 'product_offers')->where([
                                                    
        //                                             ['minimum_quantity', '<=', 5],
        //                                             ['start_date', '<=', date('Y-m-d')],
        //                                             ['expire_date', '>=', date('Y-m-d')]
        //                                         ])
        //                                 ->orWhere([
                                                    
        //                                             ['minimum_spend', '<=', 30000],
        //                                             ['start_date', '<=', date('Y-m-d')],
        //                                             ['expire_date', '>=', date('Y-m-d')]
        //                                         ])
        //                                 ->orWhere([
                                                    
        //                                             ['minimum_spend', '<=', 30000],
        //                                             ['start_date', '<=', date('Y-m-d')],
        //                                             ['expire_date', '>=', date('Y-m-d')]
        //                                         ])
        //                                 ->orWhere('discount_on', 3)
        //                                 ->whereHas('products', function(Builder $query){
        //                                         $query->where('id', 12);
        //                                     })
        //                                 ->whereHas('categories', function(Builder $query){
        //                                         $query->whereHas('products', function(Builder $query){
        //                                             $query->where('id', 12);
        //                                         });
        //                                     })
        //                                 ->pluck('id')->all();
        // dd($offers);
        // $product_offer = Offer::whereHas('products', function(Builder $query){
        //     $query->where('id', 12);
        // })->get();
        // dd($product_offer);
        // $product_offer = $product->offers()->where('minimum_quantity','<=', 10)->orWhere('discount_on', 3)->orderBy('minimum_quantity', 'desc')->get();
        // $product_offer = $product->offers()->where('minimum_spend','<=', 300000)->orderBy('minimum_spend', 'desc')->first();

        // dd($product_offer);
        $product_variation_colors = $product->product_colors;

        // foreach ($product_variation_colors as $color_key => $product_color) {

        //     echo $product_color->color->id.'->'.$product_color->color->title.'->'.$product_color->color->code.'<br>';
            
        //     if (isset($_GET['c']) && $product_color->color->code == $_GET['c']) {

        //        $firstColorId = $product_color->id;  

        //     }elseif ($color_key == 0) {

        //         $firstColorId = $product_color->id; 
        //     }
        // }

        // echo $firstColorId;

        // dd($product_variation_colors);
        // $product_variation_colors = $product->product_variations()->groupBy('color_id')->get();
        $related_products = $product->category->products()->where('id', '!=', $product->id)->get();
        $product_cares = ProductCare::whereIn('id', json_decode($product->product_cares))->get();

        $product_reviews = $product->product_reviews()->where('display',1)->orderBy('created_at','desc')->get();
        $product->rating_stars = ModelHelper::get_rating_stars($product_reviews->sum('rating'));

        $customer_product_review = NULL;

        if (Auth::check()) {

            $has_ordered_product = Auth::user()->whereHas('ordered_products', function(Builder $query) use ($product){
                                        $query->where('product_id', $product->id);
                                    })->exists();

            $customer_product_review = Auth::user()->product_reviews()->where('product_id',$product->id)->first();
            
            $product->has_ordered_product = $has_ordered_product ? 1 : 0;            
        }

        $size_guide_id = $product->size_guide_id;

        if ($size_guide_id != NULL) {
            $size_guide = SizeGuide::find($size_guide_id);
        }else{
            $size_guide = NULL;
        }

        // dd($related_products);
        // $size_ids = $product->product_variations()->groupBy('size_id')->get()->pluck('size_id')->all();

        $shipping_address = NULL;
        $shipping_charge_per_item = 0;
        $cod_availability = 0;

        if (Auth::check()) {

            $customer = Auth::user();
            $shipping_address = $customer->customer_addresses()->where('is_shipping_address', 1)->first();
            if (isset($shipping_address)) {

                $shipping_charge_per_item = Order::calculate_delivery_charge($shipping_address->district_id, $product->weight);

                $cod = City::where([['id', $shipping_address->city_id],['cod',1]])->first();

                if (isset($cod)) {

                    $cod_availability = 1;
                }else{

                    $cod_availability = 0;
                }

            }else{

                $shipping_address = NULL;
            }
        }

        return view('product-details', compact('product','product_variation_colors','related_products', 'product_cares','product_reviews','customer_product_review', 'size_guide', 'shipping_address', 'shipping_charge_per_item', 'cod_availability'));
    }

    public function get_related_sizes(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::where('id',$product_id)->first();

        $product_color_id = $request->product_color_id;

        $product_variation_sizes = $product->product_colors()->where('id', $product_color_id)->first()->product_sizes;
        $sResponse = '';

        foreach ($product_variation_sizes as $size_key => $product_variation_size) {

            if ($size_key == 0) {
                $firstSize = $product_variation_size;
                $firstSizeMaxQty = $firstSize->quantity > 0 ? $firstSize->quantity : $firstSize->preorder_stock_limit;
            }
            
            $selectedStatus = $size_key == 0 ? 'selected' : '';
            $max_order_qty = $product_variation_size->quantity > 0 ? $product_variation_size->quantity : $product_variation_size->preorder_stock_limit;
            $stock_status = $product_variation_size->quantity > 0 ? 1 : 0;
            $sResponse .= '<li>
                                <label data-product-size-id="'.$product_variation_size->id.'" data-variation-price="'.$product_variation_size->price.'" data-variation-offer-price="'.$product_variation_size->offer_price.'" data-stock-status="'.$stock_status.'" data-pre-order-status="'.$product_variation_size->preorder.'" data-stock-count="'.$max_order_qty.'" for="size'.$size_key.'" class="'.$selectedStatus.'">
                                    <input type="radio" name="product-size" id="size'.$size_key.'" hidden>
                                    '.$product_variation_size->size->name.'
                                </label>
                            </li>';

        }

        $response = array('related_sizes' => $sResponse, 'max_order_qty' => $firstSizeMaxQty);

        echo json_encode($response);
    }
    
    public function search(Request $request){

        $q = $request->search;

        // $product_color_variations = ProductColor::whereHas('product', function(Builder $query) use ($q){

        //     $query->where([['title', 'LIKE', '%'. $q .'%'],['display',1],['deleted_at',NULL]])
        //             ->orWhereHas('product_sizes', function(Builder $query) use ($q){
        //                 $query->where([['product_sizes.sku', 'LIKE', '%'. $q .'%']]);
        //             });
        // })->where([['status',1]])->get();

        $product_size_variations = ProductSize::whereHas('product_color', function(Builder $query) use ($q){

                                            $query->whereHas('product', function(Builder $query) use ($q){

                                                $query->where([['title', 'LIKE', '%'. $q .'%'],['display',1],['deleted_at',NULL]])
                                                    ->orWhereHas('product_sizes', function(Builder $query) use ($q){
                                                            $query->where([['product_sizes.sku', 'LIKE', '%'. $q .'%']]);
                                                        });
                                            });

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();

        // dd($product_size_variations->pluck('final_price'));
        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');
        // dd($product_color_variations);
        $min_price = $product_size_variations->min('final_price');
        $max_price = $product_size_variations->max('final_price');

        $filter_colors = $product_color_variations->unique('color_id')->pluck('color')->sortBy('id')->all();
        $filter_sizes = $product_size_variations->unique('size_id')->pluck('size')->sortBy('id')->all();

        $filter_occassions = $product_color_variations->pluck('product.occassions')->flatten()->unique('id')->all();
        $filter_fabrics = $product_color_variations->pluck('product.fabrics')->flatten()->unique('id')->all();


        $filter_delivery_times = $product_size_variations->unique('preorder')->pluck('preorder')->all();
        $filter_genders = $product_color_variations->pluck('product')->unique('gender')->pluck('gender')->all();
        

        
        $product_size_variations = ProductSize::with('product_color.product')
                                        ->has('product_color.product')
                                        ->whereHas('product_color', function(Builder $query) use ($q){

                                            $query->whereHas('product', function(Builder $query) use ($q){

                                                $query->where([['title', 'LIKE', '%'. $q .'%'],['display',1],['deleted_at',NULL]])
                                                    ;

                                                if (isset($_GET['occassion'])) {

                                                    $query->whereHas('occassions', function(Builder $query){
                                                        $query->whereIn('occassion_products.occassion_id', $_GET['occassion']);
                                                    });
                                                }

                                                if (isset($_GET['fabric'])) {

                                                    $query->whereHas('fabrics', function(Builder $query){
                                                        $query->whereIn('fabric_products.fabric_id', $_GET['fabric']);
                                                    });
                                                }

                                                if (isset($_GET['gender'])) {
                                                    $query->whereIn('gender', $_GET['gender']);
                                                }

                                            });

                                            if (isset($_GET['color'])) {
                                                $query->whereIn('color_id', $_GET['color']);
                                            }

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');

        // dd($product_size_variations->count());
        // dd($product_size_variations->pluck('final_price'));
        if (isset($_GET['size'])) {
            $product_size_variations->whereIn('size_id', $_GET['size']);
        }

        if (isset($_GET['delivery_time'])) {

            $product_size_variations->where(function($query){

                if (in_array(1, $_GET['delivery_time'])) {
                    
                    $query->where([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);

                    if (in_array(0, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity', '>', 0]]);
                    }

                }elseif (in_array(0, $_GET['delivery_time'])) {

                    $query->where([['quantity', '>', 0]]);
                    
                    if (in_array(1, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);
                    }
                }

            });

        }

        // dd($product_size_variations->get());

        // dd($product_size_variations->orderBy('final_price')->limit(10)->get());

        if (@$_GET['sort'] == 'priceHL') {

            $product_size_variations->orderBy('final_price', 'desc');    

        }elseif (@$_GET['sort'] == 'priceLH') {

            $product_size_variations->orderBy('final_price');

        }

        // $products->selectRaw('IFNULL(offer_price, price) AS final_price')->where('final_price','>',2400);
        // dd($products->get());
        


        $product_size_variations = $product_size_variations->get();

        // foreach ($product_size_variations as $key => $prodSizeVar) {
        //     echo "id=".$prodSizeVar->product_color->id." --------- price=".$prodSizeVar->final_price."<br>";
        // }
        // dd($product_size_variations->unique('product_color_id'));

        if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
            
            $product_size_variations = $product_size_variations->whereBetween('final_price', [$_GET['min_price'], $_GET['max_price']]);
        }

        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');

        // foreach ($product_color_variations as $key => $pcV) {

        //     if (isset($pcV->product->title)) {

        //         $title = $pcV->product->title;
        //     }else{
        //         $title = 'n-a';
        //     }
        //     echo $title.'----'.$pcV->id.'<br>';
        // }

        // dd($product_color_variations);


        if (@$_GET['sort'] == 'alphaAZ') {

            $product_size_variations = $product_size_variations->sortBy('product_color.product.title');

        }elseif (@$_GET['sort'] == 'alphaZA') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.title');

        }elseif (@$_GET['sort'] == 'latest') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.id');

        }elseif(@$_GET['sort'] == 'oldest'){
            
            $product_size_variations = $product_size_variations->sortBy('product_color.product.id');
        }

        // if (!isset($_GET['sort'])) {
        //     $product_size_variations = $product_size_variations->sortBy('product_color.product.created_at');
        // }

        $product_size_variations = $product_size_variations->unique('product_color_id');
        // dd($product_size_variations);
        $pageDetails = ProductPaginator::get_current_page();
        $currentPage = $pageDetails['currentPage'];
        $perPage = $pageDetails['perPage'];

        $product_size_variations = ProductPaginator::paginate_products($product_size_variations, $currentPage, $perPage);

        // echo $_GET['min_price'];
        // dd($products->pluck('final_price'));

        // $product_variations = $products->pluck('product_variations')
        $product_size_variations = $product_size_variations->appends(request()->except('page'));
        // dd($product_size_variations->nextPageUrl());
        return view('search', compact('product_size_variations', 'q', 'min_price', 'max_price', 'filter_colors', 'filter_sizes', 'filter_occassions', 'filter_fabrics', 'filter_delivery_times', 'filter_genders'));

        // $products = ProductColor::with('product_sizes')->where('sku', 'LIKE', '%' . $q . '%')
        //     ->orWhere(function ($query) use ($q){
        //         $query->whereHas('product_sizes', function($que) use ($q){
        //             $que->where('product_sizes.sku', 'LIKE', '%' . $q . '%');
        //     });
        // })
        // ->orWhere(function ($query) use ($q){
        //     $query->with('product')->whereHas('product', function($que) use ($q){
        //         $que->where('title', 'LIKE', '%' . $q . '%');
        // });
        // })->get();

        // $products = Product::where('title', 'LIKE', '%' . $q . '%')->with(["product_sizes" =>function($query, $q){
        //     $query->where('sku', 'LIKE', '%' .$q. '%');
        // }])->get();
        // dd($product_color_variations->pluck('product'));
        // return view('search', compact('product_color_variations', 'q'));
    }
    
    public function offer($slug){
       
        
        $offer = Offer::where('slug', $slug)->first();
        if($offer->discount_on==2){
             $products_id = $offer->products->pluck('id')->toArray();
        
        }
        
        if($offer->discount_on==1){
            $categories_id = $offer->categories->pluck('id')->toArray();
            $products_id = Product::whereIn('category_id', $categories_id)->pluck('id')->toArray();
            $products = ProductColor::whereIn('product_id', $products_id)->paginate(8);
             

        }
        
        if($offer->discount_on==3){
            //  $products = ProductColor::has('product')->where('status',1)->inRandomOrder()->paginate(8);

            $products_id = Product::where('display', 1)->pluck('id')->toArray();
            $status =1;
        }

         $product_size_variations = ProductSize::whereHas('product_color', function(Builder $query) use ($products_id){

                                        $query->whereHas('product', function(Builder $query) use ($products_id){

                                            $query->whereIn('id', $products_id)->where('display',1);
                                                
                                        });

                                    })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();
                                    
                                    
        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');
        // dd($product_color_variations);
        $min_price = $product_size_variations->min('final_price');
        $max_price = $product_size_variations->max('final_price');

        $filter_colors = $product_color_variations->unique('color_id')->pluck('color')->sortBy('id')->all();
        $filter_sizes = $product_size_variations->unique('size_id')->pluck('size')->sortBy('id')->all();

        $filter_occassions = $product_color_variations->pluck('product.occassions')->flatten()->unique('id')->all();
        $filter_fabrics = $product_color_variations->pluck('product.fabrics')->flatten()->unique('id')->all();
        $filter_delivery_times = $product_size_variations->unique('preorder')->pluck('preorder')->all();
        $filter_genders = $product_color_variations->pluck('product')->unique('gender')->pluck('gender')->all();
        

        
        $product_size_variations = ProductSize::with('product_color.product')
                                        ->whereHas('product_color', function(Builder $query) use ($products_id){

                                            $query->whereHas('product', function(Builder $query) use ($products_id){

                                                $query->whereIn('id', $products_id)->where('display', 1);
                                                    

                                                if (isset($_GET['occassion'])) {

                                                    $query->whereHas('occassions', function(Builder $query){
                                                        $query->whereIn('occassion_products.occassion_id', $_GET['occassion']);
                                                    });
                                                }

                                                if (isset($_GET['gender'])) {
                                                    $query->whereIn('gender', $_GET['gender']);
                                                }

                                            });

                                            if (isset($_GET['color'])) {
                                                $query->whereIn('color_id', $_GET['color']);
                                            }

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');
        
        if (isset($_GET['size'])) {
            $product_size_variations->whereIn('size_id', $_GET['size']);
        }

        if (isset($_GET['delivery_time'])) {

            $product_size_variations->where(function($query){

                if (in_array(1, $_GET['delivery_time'])) {
                    
                    $query->where([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);

                    if (in_array(0, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity', '>', 0]]);
                    }

                }elseif (in_array(0, $_GET['delivery_time'])) {

                    $query->where([['quantity', '>', 0]]);
                    
                    if (in_array(1, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);
                    }
                }

            });

        }

        // dd($product_size_variations->get());

        // dd($product_size_variations->orderBy('final_price')->limit(10)->get());

        if (@$_GET['sort'] == 'priceHL') {

            $product_size_variations->orderBy('final_price', 'desc');    

        }elseif (@$_GET['sort'] == 'priceLH') {

            $product_size_variations->orderBy('final_price');

        }

        // $products->selectRaw('IFNULL(offer_price, price) AS final_price')->where('final_price','>',2400);
        // dd($products->get());
        


        $product_size_variations = $product_size_variations->get();

        if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
            
            $product_size_variations = $product_size_variations->whereBetween('final_price', [$_GET['min_price'], $_GET['max_price']]);
        }

        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');

        if (@$_GET['sort'] == 'alphaAZ') {

            $product_color_variations = $product_color_variations->sortBy('product.title');

        }elseif (@$_GET['sort'] == 'alphaZA') {

            $product_color_variations = $product_color_variations->sortByDesc('product.title');
        }
        
        if (@$_GET['sort'] == 'latest') {

            $product_color_variations = $product_color_variations->sortByDesc('product.id');

        }
        elseif(@$_GET['sort'] == 'oldest'){
            $product_color_variations = $product_color_variations->sortBy('product.id');
        }

        $product_size_variations = $product_size_variations->unique('product_color_id');

        $pageDetails = ProductPaginator::get_current_page();
        $currentPage = $pageDetails['currentPage'];
        $perPage = $pageDetails['perPage'];

        $product_size_variations = ProductPaginator::paginate_products($product_size_variations, $currentPage, $perPage);

        $product_size_variations = $product_size_variations->appends(request()->except('page'));

        // echo $_GET['min_price'];
        // dd($products->pluck('final_price'));

        // $product_variations = $products->pluck('product_variations')
      

        return view('offer-products', compact('product_size_variations', 'offer', 'min_price', 'max_price', 'filter_colors', 'filter_sizes', 'filter_occassions', 'filter_delivery_times', 'filter_genders', 'filter_fabrics'));

       
    }

    public function occassion($slug){
        $occassion = Occassion::where('slug', $slug)->first();
      
        $products_id = $occassion->products->pluck('id')->toArray();
        $products = ProductColor::whereIn('product_id', $products_id)->paginate(8);
        
        $product_size_variations = ProductSize::whereHas('product_color', function(Builder $query) use ($products_id){

                                            $query->whereHas('product', function(Builder $query) use ($products_id){

                                                $query->whereIn('id', $products_id);
                                                    
                                            });

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price')->get();
                                        
                                        
        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');
        // dd($product_color_variations);
        $min_price = $product_size_variations->min('final_price');
        $max_price = $product_size_variations->max('final_price');

        $filter_colors = $product_color_variations->unique('color_id')->pluck('color')->sortBy('id')->all();
        $filter_sizes = $product_size_variations->unique('size_id')->pluck('size')->sortBy('id')->all();

        $filter_occassions = $product_color_variations->pluck('product.occassions')->flatten()->unique('id')->all();
        $filter_fabrics = $product_color_variations->pluck('product.fabrics')->flatten()->unique('id')->all();

        $filter_delivery_times = $product_size_variations->unique('preorder')->pluck('preorder')->all();
        $filter_genders = $product_color_variations->pluck('product')->unique('gender')->pluck('gender')->all();
        

        
        $product_size_variations = ProductSize::with('product_color.product')
                                        ->whereHas('product_color', function(Builder $query) use ($products_id){

                                            $query->whereHas('product', function(Builder $query) use ($products_id){

                                                $query->whereIn('id', $products_id);
                                                    

                                                if (isset($_GET['occassion'])) {

                                                    $query->whereHas('occassions', function(Builder $query){
                                                        $query->whereIn('occassion_products.occassion_id', $_GET['occassion']);
                                                    });
                                                }

                                                if (isset($_GET['fabric'])) {

                                                    $query->whereHas('fabrics', function(Builder $query){
                                                        $query->whereIn('fabric_products.fabric_id', $_GET['fabric']);
                                                    });
                                                }

                                                if (isset($_GET['gender'])) {
                                                    $query->whereIn('gender', $_GET['gender']);
                                                }

                                            });

                                            if (isset($_GET['color'])) {
                                                $query->whereIn('color_id', $_GET['color']);
                                            }

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');
                                        
        if (isset($_GET['size'])) {
            $product_size_variations->whereIn('size_id', $_GET['size']);
        }

        if (isset($_GET['delivery_time'])) {

            $product_size_variations->where(function($query){

                if (in_array(1, $_GET['delivery_time'])) {
                    
                    $query->where([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);

                    if (in_array(0, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity', '>', 0]]);
                    }

                }elseif (in_array(0, $_GET['delivery_time'])) {

                    $query->where([['quantity', '>', 0]]);
                    
                    if (in_array(1, $_GET['delivery_time'])) {
                        $query->orWhere([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);
                    }
                }

            });

        }

        // dd($product_size_variations->get());

        // dd($product_size_variations->orderBy('final_price')->limit(10)->get());

        if (@$_GET['sort'] == 'priceHL') {

            $product_size_variations->orderBy('final_price', 'desc');    

        }elseif (@$_GET['sort'] == 'priceLH') {

            $product_size_variations->orderBy('final_price');

        }

        // $products->selectRaw('IFNULL(offer_price, price) AS final_price')->where('final_price','>',2400);
        // dd($products->get());
        


        $product_size_variations = $product_size_variations->get();

        if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
            
            $product_size_variations = $product_size_variations->whereBetween('final_price', [$_GET['min_price'], $_GET['max_price']]);
        }

        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');

        if (@$_GET['sort'] == 'alphaAZ') {

            $product_color_variations = $product_color_variations->sortBy('product.title');

        }elseif (@$_GET['sort'] == 'alphaZA') {

            $product_color_variations = $product_color_variations->sortByDesc('product.title');
        }elseif (@$_GET['sort'] == 'latest') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.id');

        }
        elseif(@$_GET['sort'] == 'oldest'){
            $product_size_variations = $product_size_variations->sortBy('product_color.product.id');
        }

        $product_size_variations = $product_size_variations->unique('product_color_id');

        $pageDetails = ProductPaginator::get_current_page();
        $currentPage = $pageDetails['currentPage'];
        $perPage = $pageDetails['perPage'];

        $product_size_variations = ProductPaginator::paginate_products($product_size_variations, $currentPage, $perPage);

        $product_size_variations = $product_size_variations->appends(request()->except('page'));

        // echo $_GET['min_price'];
        // dd($products->pluck('final_price'));

        // $product_variations = $products->pluck('product_variations')
      

        return view('offer1', compact('occassion' ,'product_size_variations', 'min_price', 'max_price', 'filter_colors', 'filter_sizes', 'filter_occassions', 'filter_delivery_times', 'filter_genders', 'filter_fabrics'));

        
        return view('offer', compact('offer', 'products'));

    }

    public function login()
    {
        if (!Auth::check()) {

            return view('login');

        } else {

            if (Auth::user()->hasRole(['Super Admin'])) {

                return redirect()->route('admin.index')->with('error', 'Already Logged In as a Administrator!');

            } else {

                return redirect('/')->with('error', 'You are Already Logged In as Customer!');
            }

        }
    }

    public function register()
    {
        if (!Auth::check()) {
            $countries = Country::where('display',1)->get();
            return view('register', compact('countries'));

        } else {


            if (Auth::user()->hasRole(['Super Admin'])) {

                return redirect()->route('admin.index')->with('error', 'Already Logged In as a Administrator!');

            } else {

                return redirect('/')->with('error', 'You are Already Logged In as Customer!');
            }

        }
    }
    
    public function check_user_email_availability(Request $request)
    {
        $checkUserEmailAvailability = User::where('email', $request->email)->doesntExist();

        if ($checkUserEmailAvailability) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_states(Request $request)
    {
        $country_id = $request->country_id;
        $state_id = $request->state_id;

        $country = Country::find($country_id);

        $responseText = "<option value='' disabled selected>Select State/Region</option>";

        if ($country) {

            $states = $country->states;
            // $states = DB::table('states')->where('country_id', $country_id)->get();
        
            
            foreach ($states as $stat) {

                if ($stat->id == $state_id) {

                    $selectFlag = 'selected';
                }else{
                    $selectFlag = '';
                }

                $responseText .= "<option ".$selectFlag." value='".$stat->id."' >".$stat->name."</option>";
            }
        }else{
            $responseText = "<option value='' disabled selected>Select Country First</option>";
        }
        

        return $responseText;
    }

    public function get_districts(Request $request)
    {
        $state_id = $request->state_id;
        $district_id = $request->district_id;

        $state = State::find($state_id);
        $districts = $state->districts;

        $responseText = "<option value='' disabled selected>Select District</option>";
        
        foreach ($districts as $district) {

            if ($district->id == $district_id) {

                $selectFlag = 'selected';
            }else{
                $selectFlag = '';
            }

            $responseText .= "<option ".$selectFlag." value='".$district->id."' >".$district->name."</option>";
        }

        return $responseText;
    }

    public function get_cities(Request $request)
    {
        $district_id = $request->district_id;
        $city_id = $request->city_id;

        $district = District::find($district_id);
        $cities = $district->cities;

        $responseText = "<option value='' disabled selected>Select City</option>";
        
        foreach ($cities as $city) {

            if ($city->id == $city_id) {

                $selectFlag = 'selected';
                $selectedPinCode = $city->pin_code;
            }else{
                $selectFlag = '';
                $selectedPinCode = '';
            }

            $responseText .= "<option ".$selectFlag." data-pin-code='".$city->pin_code."' value='".$city->id."' >".$city->name."</option>";
        }

        return $responseText;
    }
    
    public function get_billing_pincode(Request $request)
    {
        $city_id = $request->city_id;
        $billing_pincode = City::select('pin_code')->where('id', $city_id)->first();
        return $billing_pincode;
    }
    
    public function get_shipping_pincode(Request $request)
    {
        $city_id = $request->city_id;
        $shipping_pincode = City::select('pin_code')->where('id', $city_id)->first();
        return $shipping_pincode;
    }

    public function check_cod_availability(Request $request)
    {
        $city_id = $request->city_id;

        $cod = City::where([['id',$city_id],['cod',1]])->first();

        if (isset($cod)) {

            $response = 'available';
        }else{

            $response = 'not-available';
        }

        echo $response;
    }

    public function get_url_with_price(Request $request)
    {
        $current_url = $request->current_url;
        $full_url = base64_decode($request->full_url);
        $generated_url = $this->generate_url($current_url, $full_url, 'price', $request->min_price, $request->max_price);
        $data = array('url'=> $generated_url);

        echo json_encode($data);
        exit();
    }

    public static function generate_url($current_url, $full_url, $filter_key, $ignore_id = 0, $add_id = 'not-set'){

        $currentUrl = $current_url;
        parse_str(parse_url($full_url, PHP_URL_QUERY), $attributes);

        // var_dump($attributes);
        // exit();

        $parametersArray = array();

        if (isset($attributes['color'])) {
            $parametersArray['color'] = $attributes['color'];
        }

        if (isset($attributes['size'])) {
            $parametersArray['size'] = $attributes['size'];
        }

        if (isset($attributes['stid'])) {
            $parametersArray['stid'] = $attributes['stid'];
        }

        if (isset($attributes['brand'])) {
            $parametersArray['brand'] = $attributes['brand'];
        }

        if (isset($attributes['cType'])) {
            $parametersArray['cType'] = $attributes['cType'];
        }

        if (isset($attributes['min_price'])) {
            $parametersArray['min_price'] = $attributes['min_price'];
            $parametersArray['max_price'] = $attributes['max_price'];
        }

        if (isset($attributes['sort'])) {
            $parametersArray['sort'] = $attributes['sort'];
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

                // if (isset($attributes['min_price']) && $attributes['min_price'] == $ignore_id) {
                //     unset($parametersArray['min_price']);
                //     unset($parametersArray['max_price']);
                // }else{
                    $parametersArray['min_price'] = $ignore_id;
                    $parametersArray['max_price'] = $add_id;
                // }
                
            }elseif ($filter_key == 'sort' ) {
                $parametersArray[$filter_key] = $add_id;
            }else{
                $parametersArray[$filter_key][] = $add_id;
            }

        }

        // var_dump($parametersArray);

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

    public function store_product_review(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'rating' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();;
        }

        if (Auth::check()) {
            $reviewInsertArray = [
                                'review' => $request->review,
                                'rating' => $request->rating,
                                'display' => 1
                            ];

            $review_created = Auth::user()->product_reviews()->updateOrCreate(
                                                                ['product_id' => $request->product_id], 
                                                                $reviewInsertArray
                                                            );

            if ($review_created) {
                return redirect()->back()->with('status', 'Your Review has been submitted Successfully!');
            }
        }else{
            return redirect()->back()->with('error', 'Please Login to Submit your Review for this product!');
        }

        
    }

    public function about($type)
    {
        // dd($type);

        if ($type == 'jashn') {

            $content = Content::where('id', 1)->firstOrFail();

        }elseif ($type == 'terms-and-conditions') {

            $content = Content::where('id', 2)->firstOrFail();

        }elseif ($type == 'return-policy') {

            $content = Content::where('id', 3)->firstOrFail();

        }elseif ($type == 'payment-policy') {

            $content = Content::where('id', 4)->firstOrFail();

        }elseif ($type == 'faq') {

            $content = Content::where('id', 5)->firstOrFail();
        }else{

            return redirect()->route('home')->with('error', 'Page Under Construction!');
        }

        return view('about', compact('content'));
    }

    public function contact_us()
    {
        return view('contact-us');
    }

    public function see_more_trending_products(Request $request)
    {
        $loaded_product_color_ids = json_decode($request->loaded_product_color_ids);
        $product_color_variations = ProductColor::has('product')->where('status',1)->whereNotIn('id', $loaded_product_color_ids)->inRandomOrder()->limit(8)->get();
        $has_more_product = 1;
        $productsResponse = '';

        if ($product_color_variations->count() > 0) {

            foreach($product_color_variations as $key => $product_color){

                $product_size = $product_color->product_sizes->sortBy('price')->first();
                $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
                $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');
                if($product_color->image != NULL){
                    $productImage = asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image);
                }else{
                    $productImage = asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image);
                }

                $productsResponse .= '<div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="product ">';
                                if($product_color_quantity_count > 0){
                                    $productsResponse .= '<span class="ribbon3 in-stock">In Stock</span>';
                                }elseif($product_color_preorder_stock_limit_count > 0){
                                    $productsResponse .= '<span class="ribbon3 pre-order">Pre Order</span>';
                                }else{
                                    $productsResponse .= '<span class="ribbon3 sold-out">Sold Out</span>';
                                }
                                
                                $productsResponse .= '<div class="product-image">
                                    <div class="product-action-buttons">
                                        <a href="javascript:void(0);" class="action-button btn-add-to-wishlist" data-product-color-id="'.$product_color->id.'">
                                            <i class="fa fa-heart"></i>
                                            <span>Add to Wishlist</span>
                                        </a>
                                        <a href="javascript:void(0);" class="action-button">
                                            <i class="fa fa-retweet"></i>
                                            <span>Add to Compare</span>
                                        </a>
                                    </div>
                                    
                                    <a href="'.route('product-details',['slug' => $product_color->product->slug, 'c' => $product_color->color->code]).'">
                                        <img src="'.$productImage.'" alt="'.$product_color->product->slug.'" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-details">
                                    <div class="seen-product-details">
                                        <div>
                                            <p class="product-title">'.$product_color->product->title.'</p>
                                            <p class="product-sub">'.$product_color->product->category->title.'</p>
                                        </div>
                                        <div class="price">';

                                            if($product_size->offer_price != NULL || $product_size->offer_price != 0){
                                                $productsResponse .= '<del>Nrs.'.$product_size->price.'</del>';
                                            }
                                            
                                            $tempPrice = $product_size->offer_price != NULL || $product_size->offer_price != 0 ? $product_size->offer_price : $product_size->price;
                                            $productsResponse .= '<ins>
                                                Nrs.'.$tempPrice.'
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        
        $total_remaining_product_color_count = ProductColor::has('product')->where('status',1)->whereNotIn('id', $loaded_product_color_ids)->count();

        $remaining_product_colors = $total_remaining_product_color_count - 8;

        if ($remaining_product_colors > 0) {
            $has_more_product = 1;
        }else{
            $has_more_product = 0;
        }

        $loaded_product_color_ids = array_merge($loaded_product_color_ids, $product_color_variations->pluck('id')->all());

        $data = array('productsResponse' => $productsResponse, 'has_more_product' => $has_more_product, 'loaded_product_color_ids' => json_encode($loaded_product_color_ids));

        echo json_encode($data);

    }

    public function see_more_products(Request $request)
    {
        $attributes = (array)json_decode(base64_decode($request->url_parameters));
        
        // if (isset($attributes['category_id'])) {
        //     $attributes['category_id'] = $category
        // }
        // $q = $attributes['search'];
        
        $product_size_variations = ProductSize::with('product_color.product')
                                        ->has('product_color.product')
                                        ->whereHas('product_color', function(Builder $query) use ($attributes){

                                            $query->whereHas('product', function(Builder $query) use ($attributes){

                                                if (isset($attributes['category_id'])) {
                                                    
                                                    $query->where([['display',1], ['category_id', $attributes['category_id']]]);

                                                }elseif (isset($attributes['occassion_id'])) {

                                                    $occassion = Occassion::where('id', $attributes['occassion_id'])->first();
                                                    $products_id = $occassion->products->pluck('id')->toArray();

                                                    $query->whereIn('id', $products_id);

                                                }elseif (isset($attributes['offer_id'])) {

                                                    $offer = Offer::where('id', $attributes['offer_id'])->first();
                                                    if($offer->discount_on==2){
                                                         $products_id = $offer->products->pluck('id')->toArray();
                                                    
                                                    }
                                                    
                                                    if($offer->discount_on==1){
                                                        $categories_id = $offer->categories->pluck('id')->toArray();
                                                        $products_id = Product::whereIn('category_id', $categories_id)->pluck('id')->toArray();
                                                        $products = ProductColor::whereIn('product_id', $products_id)->paginate(8);
                                                         

                                                    }
                                                    
                                                    if($offer->discount_on==3){
                                                        //  $products = ProductColor::has('product')->where('status',1)->inRandomOrder()->paginate(8);

                                                        $products_id = Product::where('display', 1)->pluck('id')->toArray();
                                                        $status =1;
                                                    }

                                                    $query->whereIn('id', $products_id);

                                                }elseif (isset($attributes['search'])) {
                                                    
                                                    $query->where([['title', 'LIKE', '%'. $attributes['search'] .'%'],['display',1],['deleted_at',NULL]]);
                                                }
                                                    

                                                if (isset($attributes['occassion'])) {

                                                    $query->whereHas('occassions', function(Builder $query) use ($attributes){
                                                        $query->whereIn('occassion_products.occassion_id', $attributes['occassion']);
                                                    });
                                                }

                                                if (isset($attributes['fabric'])) {

                                                    $query->whereHas('fabrics', function(Builder $query) use ($attributes){
                                                        $query->whereIn('fabric_products.fabric_id', $attributes['fabric']);
                                                    });
                                                }

                                                if (isset($attributes['gender'])) {
                                                    $query->whereIn('gender', $attributes['gender']);
                                                }

                                            });

                                            if (isset($attributes['color'])) {
                                                $query->whereIn('color_id', $attributes['color']);
                                            }

                                        })->select('*')->selectRaw('IFNULL(offer_price, price) AS final_price');

        // dd($product_size_variations->get());
        
        if (isset($attributes['size'])) {
            $product_size_variations->whereIn('size_id', $attributes['size']);
        }

        if (isset($attributes['delivery_time'])) {

            $product_size_variations->where(function($query) use ($attributes){

                if (in_array(1, $attributes['delivery_time'])) {
                    
                    $query->where([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);

                    if (in_array(0, $attributes['delivery_time'])) {
                        $query->orWhere([['quantity', '>', 0]]);
                    }

                }elseif (in_array(0, $attributes['delivery_time'])) {

                    $query->where([['quantity', '>', 0]]);
                    
                    if (in_array(1, $attributes['delivery_time'])) {
                        $query->orWhere([['quantity','<=', 0], ['preorder',1], ['preorder_stock_limit', '>', 0]]);
                    }
                }

            });

        }

        // dd($product_size_variations->get());

        if (@$attributes['sort'] == 'priceHL') {

            $product_size_variations->orderBy('final_price', 'desc');    

        }elseif (@$attributes['sort'] == 'priceLH') {

            $product_size_variations->orderBy('final_price');

        }


        $product_size_variations = $product_size_variations->get();
        
        if (isset($attributes['min_price']) && isset($attributes['max_price'])) {
            
            $product_size_variations = $product_size_variations->whereBetween('final_price', [$attributes['min_price'], $attributes['max_price']]);
        }

        $product_color_variations = $product_size_variations->pluck('product_color')->unique('id');

        if (@$attributes['sort'] == 'alphaAZ') {

            $product_size_variations = $product_size_variations->sortBy('product_color.product.title');

        }elseif (@$attributes['sort'] == 'alphaZA') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.title');

        }elseif (@$attributes['sort'] == 'latest') {

            $product_size_variations = $product_size_variations->sortByDesc('product_color.product.id');

        }elseif(@$attributes['sort'] == 'oldest'){
            
            $product_size_variations = $product_size_variations->sortBy('product_color.product.id');
        }

        // if (!isset($_GET['sort'])) {
        //     $product_size_variations = $product_size_variations->sortBy('product_color.product.created_at');
        // }

        $product_size_variations = $product_size_variations->unique('product_color_id');



        // $pageDetails = ProductPaginator::get_current_page();
        $currentPage = $attributes['page'];
        $perPage = 9;

        // dd($product_size_variations);

        $product_size_variations = ProductPaginator::paginate_products($product_size_variations, $currentPage, $perPage);

        // if (!isset($attributes['sort'])) {
        //     $product_size_variations->shuffle();
        // }

        $has_more_product = 1;
        $productsResponse = '';

        if ($product_size_variations->count() > 0) {
            
            if (!isset($attributes['sort'])) {
                $product_size_items = collect($product_size_variations->all())->shuffle();
            }else{
                $product_size_items = $product_size_variations;
            }

            foreach($product_size_items as $key => $product_size){

                // if(isset($attribute['sort']) && $attribute['sort'] == 'priceHL'){
                //     $product_size = $product_color->product_sizes()->orderByRaw('IFNULL(offer_price, price) DESC')->first();
                // }else{
                //     $product_size = $product_color->product_sizes()->orderByRaw('IFNULL(offer_price, price) ASC')->first();
                // }
                $product_color = $product_size->product_color;

                $product_color_quantity_count = $product_color->product_sizes->sum('quantity');
                $product_color_preorder_stock_limit_count = $product_color->product_sizes->sum('preorder_stock_limit');


                if($product_color->image != NULL){
                    $productImage = asset('storage/products/'.$product_color->product->slug.'/variations/thumbs/small_'.$product_color->image);
                }else{
                    $productImage = asset('storage/products/'.$product_color->product->slug.'/thumbs/small_'.$product_color->product->image);
                }

                if ($request->layout == 'list-view') {
                    
                    $productsResponse .= '<div class="col-6 col-sm-6 col-md-6 product-bootstrap col-lg-6 list-view">';
                }else{
                    
                    $productsResponse .= '<div class="col-6 col-sm-6 col-md-6 col-lg-4 product-bootstrap">';
                }

                $productsResponse .= '<div class="product grid-view jQueryEqualHeight">';
                                if(isset($attributes['delivery_time'])){

                                    if(isset($attributes['delivery_time']) && count($attributes['delivery_time']) == 1 && in_array(1, $attributes['delivery_time'])){

                                        $productsResponse .= '<span class="ribbon3 pre-order">Pre Order</span>';
                                    }elseif(isset($attributes['delivery_time']) && count($attributes['delivery_time']) == 0 && in_array(0, $attributes['delivery_time'])){

                                        $productsResponse .= '<span class="ribbon3 in-stock">In Stock</span>';
                                    }else{

                                        $productsResponse .= '<span class="ribbon3 in-stock">In Stock</span>';
                                    }
                                    

                                }elseif($product_color_quantity_count > 0){
                                    $productsResponse .= '<span class="ribbon3 in-stock">In Stock</span>';
                                }elseif($product_color_preorder_stock_limit_count > 0){
                                    $productsResponse .= '<span class="ribbon3 pre-order">Pre Order</span>';
                                }else{
                                    $productsResponse .= '<span class="ribbon3 sold-out">Sold Out</span>';
                                }
                                
                                $productsResponse .= '<div class="product-image">
                                    <div class="product-action-buttons">
                                        <a href="javascript:void(0);" class="action-button btn-add-to-wishlist" data-product-color-id="'.$product_color->id.'">
                                            <i class="fa fa-heart"></i>
                                            <span>Add to Wishlist</span>
                                        </a>
                                        <a href="javascript:void(0);" class="action-button">
                                            <i class="fa fa-retweet"></i>
                                            <span>Add to Compare</span>
                                        </a>
                                    </div>
                                    
                                    <a href="'.route('product-details',['slug' => $product_color->product->slug, 'c' => $product_color->color->code]).'">
                                        <img src="'.$productImage.'" alt="'.$product_color->product->slug.'" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-details">
                                    <div class="seen-product-details">
                                        <div>
                                            <p class="product-title">'.$product_color->product->title.'</p>
                                            <p class="product-sub">'.$product_color->product->category->title.'</p>
                                        </div>
                                        <div class="price">';

                                            if($product_size->offer_price != NULL || $product_size->offer_price != 0){
                                                $productsResponse .= '<del>Nrs.'.$product_size->price.'</del>';
                                            }
                                            
                                            $tempPrice = $product_size->offer_price != NULL || $product_size->offer_price != 0 ? $product_size->offer_price : $product_size->price;
                                            $productsResponse .= '<ins>
                                                Nrs.'.$tempPrice.'
                                            </ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }

        $remaining_product_colors = $product_size_variations->total() - ($currentPage * $perPage);

        if ($remaining_product_colors > 0) {
            $has_more_product = 1;
        }else{
            $has_more_product = 0;
        }

        $attributes['page'] = $attributes['page'] +1;

        // dd($attributes);

        $data = array('productsResponse' => $productsResponse, 'has_more_product' => $has_more_product, 'url_parameters' => base64_encode(json_encode($attributes)));

        echo json_encode($data);

    }

    public function thank_you(Request $request)
    {
        // echo "string";
        dd(session()->get('cart'));
        // dd($request);

        $access = "db5ff28911b9380e88d8745d5ad3acab";
        $profile_id = "24278DDF-212B-4A9E-B5C9-EA233FADBF5A";

        $user = auth()->user();
        // dd($user);
        $res = $request->all();
        // dd($res);

        $order = Order::where('order_no', $res['req_reference_number'])->first();
        dd(Auth::loginUsingId($order->customer_id));
        
        if($res['decision'] === "ACCEPT" && $res['reason_code'] === "100" && $res['req_access_key'] === $access && $res['req_profile_id'] === $profile_id){

            $fieldValues = array();

            foreach(explode(',', $res['signed_field_names']) as $test){
                $text = $test . "=" . $res[$test];
                array_push($fieldValues, $text);
            }

            $joinedValue = join(',', $fieldValues);


            
            $hash = base64_encode(hash_hmac('sha256', $joinedValue, '59a829a47af34eacb304ec884b669665f6d358e66d1246d69f2cdbc038d90779147bd6c5fabd4f6d9f63a6133a1a701f97eff1cb4ad548c3b34b55ec702d006010ecce1630eb40b3bde0adbe914c38e9c74931a73a224216bc38d05ec5e4a2d6ee4ea2089be6480cb8d23e77191c0bb6107f7725f79245888f74c322dad0729f', true));
            $order = Order::where('order_no', $res['req_reference_number'])->first();
            // dd($hash === $res['signature']);
            if($hash === $res['signature']){

                
                $order->payment_status = 1;
                $order->save();

                if($order != null && $order){

                    $paymentArray = [
                                        'order_id' => $order->id,
                                        'total_price' => $order->total_price,
                                        'response' => json_encode($res),
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => NULL
                                    ];

                    NICPayment::create($paymentArray);

                    return redirect()->route('nic.payment-status', ['order_no' => $order->order_no, 'status' => 'success']);
                }
            }
        }

        dd('imhere');
        return redirect()->route('nic.payment-status', ['order_no' => $order->order_no, 'status' => 'failed']);
    }


    public function create_shipment()
    {
        // phpinfo();
        // dd('test');
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        // dd(public_path('/backend/shipping-services-api-wsdl.wsdl'));
        $soapClient = new SoapClient(public_path('/backend/shipping-services-api-wsdl.wsdl'));
        // echo '<pre>';
        // print_r($soapClient->__getFunctions());

        $params = array(
                'Shipments' => array(
                    'Shipment' => array(
                            'Shipper'   => array(
                                            'Reference1'    => 'Jashn 111112',
                                            'Reference2'    => 'Jashn 222223',
                                            'AccountNumber' => '102331',
                                            'PartyAddress'  => array(
                                                'Line1'                 => '93-95 Central Mall',
                                                'Line2'                 => 'Main Road',
                                                'Line3'                 => '',
                                                'City'                  => 'Sundarharaicha',
                                                'StateOrProvinceCode'   => 'Morang',
                                                'PostCode'              => '56613',
                                                'CountryCode'           => 'NP'
                                            ),
                                            'Contact'       => array(
                                                'Department'            => 'Jashn',
                                                'PersonName'            => 'Gajanan Enterprises',
                                                'Title'                 => '',
                                                'CompanyName'           => 'Gajanan Enterprises',
                                                'PhoneNumber1'          => '+9779802790090',
                                                'PhoneNumber1Ext'       => '',
                                                'PhoneNumber2'          => '',
                                                'PhoneNumber2Ext'       => '',
                                                'FaxNumber'             => '',
                                                'CellPhone'             => '+9779802790090',
                                                'EmailAddress'          => 'jashn@shopatjashn.com',
                                                'Type'                  => ''
                                            ),
                            ),
                                                    
                            'Consignee' => array(
                                            'Reference1'    => 'Jashn 333333',
                                            'Reference2'    => 'Jashn 444444',
                                            'AccountNumber' => '102331',
                                            'PartyAddress'  => array(
                                                'Line1'                 => 'Hasanpur',
                                                'Line2'                 => '',
                                                'Line3'                 => '',
                                                'City'                  => 'Dhangadhi',
                                                'StateOrProvinceCode'   => 'Kailali',
                                                'PostCode'              => '10900',
                                                'CountryCode'           => 'NP'
                                            ),
                                            
                                            'Contact'       => array(
                                                'Department'            => '',
                                                'PersonName'            => 'Gehendra Chaudhary',
                                                'Title'                 => '',
                                                'CompanyName'           => 'Gehendra Chaudhary',
                                                'PhoneNumber1'          => '+9779801374870',
                                                'PhoneNumber1Ext'       => '',
                                                'PhoneNumber2'          => '',
                                                'PhoneNumber2Ext'       => '',
                                                'FaxNumber'             => '',
                                                'CellPhone'             => '+9779801374870',
                                                'EmailAddress'          => 'gehendra.chy@gmail.com',
                                                'Type'                  => ''
                                            ),
                            ),
                            
                            
                            'Reference1'                => 'Shpt 0001',
                            'Reference2'                => '',
                            'Reference3'                => '',
                            'ForeignHAWB'               => 'JASHNTEST0001',
                            'TransportType'             => 0,
                            'ShippingDateTime'          => time(),
                            'DueDate'                   => time(),
                            'PickupLocation'            => 'Reception',
                            'PickupGUID'                => '',
                            'Comments'                  => 'Shpt 0001',
                            'AccountingInstrcutions'    => '',
                            'OperationsInstructions'    => '',
                            
                            'Details' => array(
                                            'Dimensions' => array(
                                                'Length'                => 10,
                                                'Width'                 => 10,
                                                'Height'                => 10,
                                                'Unit'                  => 'cm',
                                                
                                            ),
                                            
                                            'ActualWeight' => array(
                                                'Value'                 => 0.5,
                                                'Unit'                  => 'Kg'
                                            ),
                                            
                                            'ProductGroup'          => 'DOM',
                                            'ProductType'           => 'OND',
                                            'PaymentType'           => 'P',
                                            'PaymentOptions'        => '',
                                            'Services'              => '',
                                            'NumberOfPieces'        => 1,
                                            'DescriptionOfGoods'    => 'Clothes',
                                            'GoodsOriginCountry'    => 'GB',
                                            
                                            'CashOnDeliveryAmount'  => array(
                                                'Value'                 => 0,
                                                'CurrencyCode'          => ''
                                            ),
                                            
                                            'InsuranceAmount'       => array(
                                                'Value'                 => 0,
                                                'CurrencyCode'          => ''
                                            ),
                                            
                                            'CollectAmount'         => array(
                                                'Value'                 => 0,
                                                'CurrencyCode'          => ''
                                            ),
                                            
                                            'CashAdditionalAmount'  => array(
                                                'Value'                 => 0,
                                                'CurrencyCode'          => ''                           
                                            ),
                                            
                                            'CashAdditionalAmountDescription' => '',
                                            
                                            'CustomsValueAmount' => array(
                                                'Value'                 => 0,
                                                'CurrencyCode'          => ''                               
                                            ),
                                            
                                            'Items'                 => array(
                                                
                                            )
                            ),
                    ),
                ),
            
                'ClientInfo'            => array(
                                            'AccountCountryCode'    => 'GB',
                                            'AccountEntity'         => 'LON',
                                            'AccountNumber'         => '102331',
                                            'AccountPin'            => '321321',
                                            'UserName'              => 'testingapi@aramex.com',
                                            'Password'              => 'R123456789$r',
                                            'Version'               => 'v1.0'
                                        ),

                'Transaction'           => array(
                                            'Reference1'            => '001',
                                            'Reference2'            => '', 
                                            'Reference3'            => '', 
                                            'Reference4'            => '', 
                                            'Reference5'            => '',                                  
                                        ),
                'LabelInfo'             => array(
                                            'ReportID'              => 9201,
                                            'ReportType'            => 'URL',
                ),
        );
        
        $params['Shipments']['Shipment']['Details']['Items'][] = array(
            'PackageType'   => 'Box',
            'Quantity'      => 1,
            'Weight'        => array(
                    'Value'     => 0.5,
                    'Unit'      => 'Kg',        
            ),
            'Comments'      => 'Docs',
            'Reference'     => ''
        );
        // echo '<pre>';
        // print_r($params);
        
        try {
            $auth_call = $soapClient->CreateShipments($params);
            echo '<pre>';
            print_r($auth_call);
            dd($auth_call);
            die();
        } catch (SoapFault $fault) {
            die('Error : ' . $fault->faultstring);
        }
        dd('test');
    }

    public function print_label()
    {
        // phpinfo();
        // dd('test');
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        // dd(public_path('/backend/shipping-services-api-wsdl.wsdl'));
        $soapClient = new SoapClient(public_path('/backend/shipping-services-api-wsdl.wsdl'));
        // echo '<pre>';
        // print_r($soapClient->__getFunctions());

        $params = array(
            
                'ClientInfo'            => array(
                                            'AccountCountryCode'    => 'GB',
                                            'AccountEntity'         => 'LON',
                                            'AccountNumber'         => '102331',
                                            'AccountPin'            => '321321',
                                            'UserName'              => 'testingapi@aramex.com',
                                            'Password'              => 'R123456789$r',
                                            'Version'               => 'v1.0'
                                        ),

                'Transaction'           => array(
                                            'Reference1'            => '001',
                                            'Reference2'            => '', 
                                            'Reference3'            => '', 
                                            'Reference4'            => '', 
                                            'Reference5'            => '',                                  
                                        ),
                'LabelInfo'             => array(
                                            'ReportID'              => 9201,
                                            'ReportType'            => 'URL',
                ),
                'ShipmentNumber'        => '46718857636'

        );


        try {
            $auth_call = $soapClient->PrintLabel($params);
            echo '<pre>';
            print_r($auth_call);
            dd($auth_call);
            die();
        } catch (SoapFault $fault) {
            die('Error : ' . $fault->faultstring);
        }
        dd('test');
    }
}
