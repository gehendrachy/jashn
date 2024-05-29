<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Offer;
use App\Services\ModelHelper;
use Validator;
use Illuminate\Validation\Rule;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::all();
        
        $discount_on_array = Offer::$discount_on;
        return view('backend.offers.list-offers', compact('offers', 'discount_on_array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.offers.create-update-offers');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:offers',
            'offer_type' => 'required|numeric',
            'discount_percentage' => Rule::requiredIf(!in_array($request->offer_type, [3,4])),
            'minimum_quantity' => Rule::requiredIf($request->offer_type == 1 || ($request->offer_type == 3 && $request->shipping_condition == 3)),
            'minimum_spend' => Rule::requiredIf($request->offer_type == 2 || ($request->offer_type == 3 && $request->shipping_condition == 2)),
            'maximum_discount' => Rule::requiredIf(!in_array($request->offer_type, [3,4])),
            "start_date" => 'required|date|after_or_equal:today',
            // "start_time" => 'required',
            "expire_date" => 'required|date|after_or_equal:start_date',
            // "expire_time" => 'required',
            'discount_on' => 'required',
            'discount_items.*' => 'sometimes'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $slug = ModelHelper::createSlug('\App\Models\Offer', $request->name);

        $createArray = [
                        'name' => $request->name,
                        'slug' => $slug,
                        'offer_type' => $request->offer_type,
                        'discount_percentage' => $request->discount_percentage,
                        'maximum_discount' => $request->maximum_discount,
                        'start_date' => $request->start_date,
                        // 'start_time' => $request->start_time,
                        'expire_date' => $request->expire_date,
                        // 'expire_time' => $request->expire_time,
                        'discount_on' => $request->discount_on
                    ];

        if ($request->offer_type == 1) {
            $createArray['minimum_quantity'] = $request->minimum_quantity;
        }elseif ($request->offer_type == 2) {
            $createArray['minimum_spend'] = $request->minimum_spend;
        }elseif($request->offer_type == 3){
            $createArray['shipping_condition'] = $request->shipping_condition;
            if ($request->shipping_condition == 2) {
                $createArray['minimum_spend'] = $request->minimum_spend;
            }elseif ($request->shipping_condition == 3) {
                $createArray['minimum_quantity'] = $request->minimum_quantity;
            }
        }
        // dd($createArray);
        $offer_created = Offer::create($createArray);
        if ($offer_created) {

            if ($request->discount_on == 1) {

                $discount_items = $request->discount_items;

                for ($i=0; $i < count($discount_items); $i++) { 
                    
                    $offer_created->category_offers()->updateOrCreate(['category_id' => $discount_items[$i]]);
                }

            }elseif ($request->discount_on == 2) {

                $discount_items = $request->discount_items;

                for ($i=0; $i < count($discount_items); $i++) { 
                    
                    $offer_created->product_offers()->updateOrCreate(['product_id' => $discount_items[$i]]);
                }

            }

            return redirect()->route('admin.offers.index')->with('status','Offer Created Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::find(base64_decode($id));
        // if ($offer->start_date <= date('Y-m-d') && $offer->expire_date >= date('Y-m-d')) {
        //     return back()->with('error', 'On-going offer | Can not edit');
        // }
        return view('backend.offers.create-update-offers',compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        // dd($request);

        if($offer->start_date >= date('Y-m-d') && $offer->expire_date <= date('Y-m-d')) {
            return redirect()->route('admin.offers.index')->withInput()->with('error', 'Sorry, You cannot edit LIVE Offers!');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|'. Rule::unique('offers')->ignore($offer->id),
            'offer_type' => 'required|numeric',
            'discount_percentage' => Rule::requiredIf(!in_array($request->offer_type, [3,4])),
            'minimum_quantity' => 'required_if:offer_type,1',
            'minimum_spend' => 'required_if:offer_type,2',
            'maximum_discount' => Rule::requiredIf(!in_array($request->offer_type, [3,4])),
            "start_date" => 'required|date',
            // "start_time" => 'required',
            "expire_date" => 'required|date|after_or_equal:start_date',
            // "expire_time" => 'required',
            'discount_on' => 'required',
            'discount_items.*' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // dd($_POST);
        $slug = ModelHelper::createSlug('\App\Models\Offer', $request->name, $offer->id);
        $updateArray = [
                        'name' => $request->name,
                        'slug' => $slug,
                        'offer_type' => $request->offer_type,
                        'discount_percentage' => $request->discount_percentage,
                        'maximum_discount' => $request->maximum_discount,
                        'start_date' => $request->start_date,
                        // 'start_time' => $request->start_time,
                        'expire_date' => $request->expire_date,
                        // 'expire_time' => $request->expire_time,
                        'discount_on' => $request->discount_on
                    ];

        if ($request->offer_type == 1) {

            $updateArray['minimum_quantity'] = $request->minimum_quantity;
        }elseif ($request->offer_type == 2) {

            $updateArray['minimum_spend'] = $request->minimum_spend;
        }elseif($request->offer_type == 3){

            $updateArray['shipping_condition'] = $request->shipping_condition;

            if ($request->shipping_condition == 2) {

                $updateArray['minimum_spend'] = $request->minimum_spend;
            }elseif ($request->shipping_condition == 3) {

                $updateArray['minimum_quantity'] = $request->minimum_quantity;
            }
        }

        $offer_updated = $offer->update($updateArray);

        if ($offer_updated) {

            if ($request->discount_on == 1) {

                $discount_items = $request->discount_items;
                // dd($discount_items);
                for ($i=0; $i < count($discount_items); $i++) { 
                    
                    $offer->category_offers()->updateOrCreate(['category_id' => $discount_items[$i]]);
                }

                $offer->category_offers()->whereNotIn('category_id', $discount_items)->delete();

            }elseif ($request->discount_on == 2) {

                $discount_items = $request->discount_items;

                for ($i=0; $i < count($discount_items); $i++) { 
                    
                    $offer->product_offers()->updateOrCreate(['product_id' => $discount_items[$i]]);
                }

                $offer->product_offers()->whereNotIn('product_id', $discount_items)->delete();

            }else{
                $offer->category_offers()->delete();
                $offer->product_offers()->delete();
            }

            return redirect()->route('admin.offers.index')->with('status','Offer Updated Successfully!');

        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        $offer = Offer::where('id' , $id)->firstOrFail();

        if ($offer) {
            
            if ($offer->delete()) {
                return redirect()->back()->with('status', 'Offer Deleted Successfully!');
            }
        }

        return redirect()->back()->with('error', 'Something Went Wrong!');

    }

    public function get_discount_on_items(Request $request)
    {
        $type = $request->type;
        $items = '';
        $discount_items = [];

        // if ($request->offer_id != 0) {
        //     $offer = Offer::find(base64_decode($request->offer_id));
        //     if ($offer->discount_on == $request->type) {
        //         $discount_items = json_decode($offer->discount_items);
        //     }
        // }

        if ($type == 1) {

            if ($request->offer_id != 0) {
                $offer = Offer::find(base64_decode($request->offer_id));
                $discount_items = $offer->category_offers()->pluck('category_id')->all();
            }

            $categories = Category::where([['display',1],['child',0]])->get();
            foreach ($categories as $key => $category) {
                $selected_status = in_array($category->id, $discount_items) ? 'selected' : '';
                $items .= '<option '.$selected_status.' value="'.$category->id.'">'.$category->title.'</option>';
            }            

        }elseif($type == 2){

            if ($request->offer_id != 0) {

                $offer = Offer::find(base64_decode($request->offer_id));
                $discount_items = $offer->product_offers()->pluck('product_id')->all();

            }

            $products = Product::where('display',1)->get();
            foreach ($products as $key => $product) {
                // $items .= '<option value="'.$product->id.'">'.$product->product->title.' ( '.$product->sku.' ) </option>';
                $selected_status = in_array($product->id, $discount_items) ? 'selected' : '';
                $items .= '<option '.$selected_status.' value="'.$product->id.'">'.$product->title.'</option>';
            }

        }else{

            $items .= '<option>All Products</option>';
        }

        $response = array('items' => $items);

        echo json_encode($response);
    }
}
