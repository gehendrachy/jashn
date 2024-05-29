<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestProduct;
use App\Models\Wishlist;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    use HasRoles;

    public function my_account()
    {
    	// $customer = User::where('id',Auth::user()->id)->first();
    	// $billing_address = $customer->customer_addresses()->where('address_type', 1)->first();
    	// $shipping_address = $customer->customer_addresses()->where('address_type', 2)->first();
    	// $orders = $customer->customer_orders()->orderBy('created_at','desc')->limit(4)->get();
    	// $wishlists = $customer->wishlists;

    	// dd($wishlists);
    	return view('my-account');
    }

    public function account_information()
    {
    	$customer = User::where('id', Auth::user()->id)->first();
    	$countries = Country::where('display',1)->get();
    	// dd($billing_address);
    	return view('account-information',compact('customer', 'countries'));
    }

    public function update_account_information(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            // 'phone' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'old_password' => ['required_with:password'],
            'password' => ['confirmed']
		]);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		// dd($_POST);

		$user = User::findOrFail(Auth::user()->id);

        if ($request->old_password != '' && $request->password != '') {

            if (Hash::check($request->old_password, $user->password)) {

                $validatedData = $request->validate([
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ]);

                $user->password = Hash::make($request['password']);

            } else {
                return redirect()->back()->with('error', 'Your Current Password Doesnot Match!!')->withInput();
            }
        }

		$user->name = $request->name;
		// $user->phone = $request->phone;
		// $user->email = $request->email;
		$user->country_id = $request->country_id;
		$user->state_id = $request->state_id;
		$user->district_id = $request->district_id;
		$user->city_id = $request->city_id;
        // $user->address = $request->address;

		$userDetailsSaved = $user->save();

        if ($userDetailsSaved) {
            return redirect()->back()->with('status', 'Your Account Information has been Updated!!');
        }

    }

    public function customer_addresses()
    {
        $customer = User::where('id', Auth::user()->id)->first();
        $saved_addresses = $customer->customer_addresses;
        // $billing_address = $customer->customer_addresses()->where('address_type', 1)->first();
        // $shipping_address = $customer->customer_addresses()->where('address_type', 2)->first();
        $countries = Country::where('display',1)->get();

        return view('saved-addresses', compact('customer', 'saved_addresses', 'countries'));


    }

    public function store_new_address(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'country_id' => 'required_without:country_name',
            'state_id' => 'required_without:state_name',
            'district_id' => 'required_without:district_name',
            'city_id' => 'required_without:city_name',
            'country_name' => 'required_without:country_id',
            'state_name' => 'required_without:state_id',
            'district_name' => 'required_without:district_id',
            'city_name' => 'required_without:city_id',
            'street_address_1' => 'required'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        $detailsSaved = $user->customer_addresses()->create(
                                        [
                                            "name" => $request->name,
                                            "pan" => $request->pan,
                                            "email" => $request->email,
                                            "phone" => $request->phone,
                                            "phone2" => $request->phone2,
                                            "country_id" => $request->country_id != 0 ? $request->country_id : 0,
                                            "state_id" => $request->country_id != 0 ? $request->state_id : 0,
                                            "district_id" => $request->country_id != 0 ? $request->district_id : 0,
                                            "city_id" => $request->country_id != 0 ? $request->city_id : 0,
                                            "country_name" => $request->country_name,
                                            "state_name" => $request->state_name,
                                            "district_name" => $request->district_name,
                                            "city_name" => $request->city_name,
                                            "pin_code" => $request->pin_code,
                                            "street_address_1" => $request->street_address_1,
                                            "street_address_2" => $request->street_address_2,
                                            "is_billing_address" => $user->customer_addresses->count() > 0 ? 0 : 1,
                                            "is_shipping_address" => $user->customer_addresses->count() > 0 ? 0 : 1
                                        ]);

        if ($detailsSaved) {
            return redirect()->route('customer.addresses')->with('status','New Address Added Succcessfully!');
        }
    }

    public function edit_saved_address(Request $request)
    {
        $address_id = $request->address_id;
        $address = CustomerAddress::find($address_id);
        
        $countries = Country::where('display', 1)->get();
        $states = State::where([['display',1],['country_id',$address->country_id]])->get();
        $districts = District::where([['display',1],['state_id',$address->state_id]])->get();
        $cities = City::where([['display',1],['district_id',$address->district_id]])->get();

        $responseText = '';

        if ($address) {
            $responseText .= '<div class="row">
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-name">Name*</label>
                                <input type="text" name="name" placeholder="Name" id="input-name" class="form-control" value="'.$address->name.'" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="pan">Pan </label>
                                <input type="text" name="pan" placeholder="Eg: 88766676" class="form-control" value="'.$address->pan.'">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-num">Phone Number(Primary)*</label>
                                <input type="text" name="phone" placeholder="+977-123456789" id="input-num" class="form-control" value="'.$address->phone.'" required >
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-num2">Phone Number 2</label>
                                <input type="text" name="phone2" placeholder="+977-123456789" id="input-num2" class="form-control" value="'.$address->phone2.'">
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="input-email">E-Mail*</label>
                                <input type="email" name="email" placeholder="E-Mail" id="input-email" class="form-control" value="'.$address->email.'" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label for="name">Country*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCountry" type="text" name="country_name" class="form-control other-country" placeholder="Enter Country Name" value="'.$address->country_name.'">
                                    <i id="showCountrySelect" class="fa fa-times show-country-select"
                                        data-country-id="'.$address->country_id.'"
                                        data-state-id="'.$address->state_id.'" 
                                        data-district-id="'.$address->district_id.'" 
                                        data-city-id="'.$address->city_id.'" 
                                        data-country-input-id="editCountrySelect" 
                                        data-state-input-id="editStateSelect" 
                                        data-district-input-id="editDistrictSelect" 
                                        data-city-input-id="editCitySelect"></i>
                                </div>
                                <select name="country_id" 
                                        id="editCountrySelect" 
                                        data-state-id="'.$address->state_id.'" 
                                        data-district-id="'.$address->district_id.'" 
                                        data-city-id="'.$address->city_id.'" 
                                        data-state-input-id="editStateSelect" 
                                        data-district-input-id="editDistrictSelect" 
                                        data-city-input-id="editCitySelect" 
                                        class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select Country</option>';
                                    
                                    foreach($countries as $country){
                                        $selected = $country->id == $address->country_id ? 'selected' : '';
                                        $responseText .= '<option '.$selected.' value="'.$country->id.'">'.$country->name.'</option>';
                                    }
                                    $selected = $address->country_id == 0 ? 'selected' : '';
                                 $other_option = '<option '.$selected.' value="0">Other</option>';
                                $responseText .='</select>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="editStateSelect">State*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherState" type="text" name="state_name" class="form-control other-country" placeholder="Enter State Name" value="'.$address->state_name.'">
                                </div>
                                <select name="state_id" 
                                        id="editStateSelect" 
                                        data-district-id="'.$address->district_id.'" 
                                        data-city-id="'.$address->city_id.'" 
                                        data-district-input-id="editDistrictSelect" 
                                        data-city-input-id="editCitySelect" 
                                        class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select State</option>';
                                    foreach($states as $state){
                                        $selected = $state->id == $address->state_id ? 'selected' : '';
                                        $responseText .= '<option '.$selected.' value="'.$state->id.'">'.$state->name.'</option>';
                                    }
                                $responseText .= '</select>
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="editDistrictSelect">District*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherDistrict" type="text" name="district_name" class="form-control other-country" placeholder="Enter District Name" value="'.$address->district_name.'">
                                </div>
                                <select name="district_id" 
                                        id="editDistrictSelect" 
                                        data-city-id="'.$address->city_id.'" 
                                        data-city-input-id="editCitySelect" 
                                        class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select District</option>';
                                    foreach($districts as $district){
                                        $selected = $district->id == $address->district_id ? 'selected' : '';
                                        $responseText .= '<option '.$selected.' value="'.$district->id.'">'.$district->name.'</option>';
                                    }
                                $responseText .= '</select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="editCitySelect">City*</label>
                                <div class="other-field-wrapper" style="position:relative; display: none;">
                                    <input id="otherCity" type="text" name="city_name" class="form-control other-country" placeholder="Enter City Name" value="'.$address->city_name.'">
                                </div>
                                <select name="city_id" id="editCitySelect" class="w-100 py-1 form-control country-select" required>
                                    <option selected disabled>Select City</option>';
                                    foreach($cities as $city){
                                        $selected = $city->id == $address->city_id ? 'selected' : '';
                                        $responseText .= '<option '.$selected.' value="'.$city->id.'">'.$city->name.'</option>';
                                    }
                                $responseText .= '</select>
                            </div>

                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="pin">Pin Code</label>
                                <input type="text" name="pin_code" value="'.$address->pin_code.'" placeholder="Eg: +977" class="form-control">
                            </div>
                            
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="password">Street Address 1*</label>
                                <input type="text" name="street_address_1" value="'.$address->street_address_1.'" placeholder="Eg: 23 burrow street" class="form-control" required>
                            </div>
                            <div class="mb-2 col-sm-6">
                                <label class="control-label" for="password">Street Address 2</label>
                                <input type="text" name="street_address_2" value="'.$address->street_address_2.'" placeholder="Eg: 23 burrow street" class="form-control">
                            </div>
                        </div>';

            echo $responseText;

        }
    }

    public function update_saved_address(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'country_id' => 'required',
            'state_id' => 'required',
            'district_id' => 'required',
            'city_id' => 'required',
            'street_address_1' => 'required'
        ]);

        $user = User::findOrFail(Auth::user()->id);

        $detailsSaved = $user->customer_addresses()->where('id',$request->id)->update(
                                        [
                                            "name" => $request->name,
                                            "pan" => $request->pan,
                                            "email" => $request->email,
                                            "phone" => $request->phone,
                                            "phone2" => $request->phone2,
                                            "country_id" => $request->country_id,
                                            "state_id" => $request->state_id,
                                            "district_id" => $request->district_id,
                                            "city_id" => $request->city_id,
                                            "pin_code" => $request->pin_code,
                                            "street_address_1" => $request->street_address_1,
                                            "street_address_2" => $request->street_address_2
                                        ]);

        if ($detailsSaved) {
            return redirect()->route('customer.addresses')->with('status','Address Updated Succcessfully!');
        }
    }

    public function make_default_address(Request $request)
    {
        // dd($_POST);
        $user = User::findOrFail(Auth::user()->id);
        if ($request->address_type == 2) {
        
            $user->customer_addresses()->where('is_shipping_address', 1)->update(['is_shipping_address' => 0]);
            $user->customer_addresses()->where('id', $request->address_id)->update(['is_shipping_address' =>  1]);
        }else{
            $user->customer_addresses()->where('is_billing_address', 1)->update(['is_billing_address' => 0]);
            $user->customer_addresses()->where('id', $request->address_id)->update(['is_billing_address' =>  1]);
        }

        return redirect()->back()->with('status','Default Address Set Successfully!');
    }

    public function change_default_address(Request $request)
    {
        
        $user = User::findOrFail(Auth::user()->id);

        $user->customer_addresses()->where('address_type', $request->type)->update(['address_type' => 0]);

        $user->customer_addresses()->where('id', $request->address_id)->update(['address_type' =>  $request->type]);

        return redirect()->back()->with('status','Address Changed Successfully!');
    }

    public function orders()
    {
        $customer = User::where('id', Auth::user()->id)->first();
        $orders = $customer->customer_orders()->orderBy('created_at','desc')->paginate(15);
        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        
        return view('customer-orders',compact('customer','orders', 'order_status', 'payment_method'));
    }

    public function view_order($order_no)
    {
        $order = Order::where([['customer_id', Auth::user()->id],['order_no', base64_decode($order_no)]])->first();
        
        if (!$order) {
            return redirect()->back()->with('error','Order Detail Not Found.');
        }

        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        $canceled_reasons = Order::canceled_reasons();
        $billing_details = json_decode($order->billing_details);
        $shipping_details = json_decode($order->shipping_details);
        
        return view('view-order-details', compact('order', 'order_status', 'payment_method', 'canceled_reasons', 'billing_details', 'shipping_details'));

    }

    public function return_requests()
    {
        $customer = User::where('id', Auth::user()->id)->first();
        $return_request_products = $customer->return_request_products()->orderBy('created_at','desc')->paginate(15);
        $return_status = ReturnRequestProduct::return_status();
        
        return view('customer-return-requests',compact('customer','return_request_products', 'return_status'));
    }

    public function create_return_request()
    {
        $customer = User::where('id', Auth::user()->id)->first();
        $orders = $customer->customer_orders()->whereHas('ordered_products', function($query){
                                $query->where('status', 5);
                            })->orderBy('created_at','desc')->get();

        // dd($orders);
        // $order_status = Order::order_status();

        return view('customer-create-return-request',compact('customer','orders'));
    }


    public function get_related_ordered_products(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $ordered_products = $order->ordered_products()->where('status',5)->get();
        $response = '';
        foreach ($ordered_products as $key => $ordered_product) {
            $response .= '<tr>
                            <td>
                                <input class="ordered-product-checkbox" type="checkbox" name="return_request['.$ordered_product->id.'][id]" value="'.$ordered_product->id.'">
                            </td>
                            <td>
                                <div class="list">
                                    <div>
                                        <img src="'.asset('storage/products/'.$ordered_product->product->slug.'/thumbs/thumb_'.$ordered_product->product->image) .'" alt="'.$ordered_product->product->slug.'">
                                    </div>
                                    <div class="detail">
                                        <p>'.$ordered_product->product->title.'</p>
                                        <p>'.$ordered_product->color_name.', '.$ordered_product->size_name.'</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>Nrs. '.$ordered_product->sub_total/$ordered_product->quantity.'</p>
                            </td>
                            <td>
                                <select name="return_request['.$ordered_product->id.'][quantity]" class="form-control ordered-product-'.$ordered_product->id.'" disabled>';
                                    for ($i=1; $i <= $ordered_product->quantity; $i++) { 
                                        $response .= '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                    
                                    
                                $response .= '</select>
                            </td>
                            <td>
                                <select name="return_request['.$ordered_product->id.'][reason]" class="form-control ordered-product-'.$ordered_product->id.'" disabled>
                                    <option value="1">Damage</option>
                                    <option value="2">Different Product</option>
                                    <option value="3">Size not Fit</option>
                                    <option value="4">Spl Request</option>
                                </select>
                            </td>
                            <td>
                                <input type="file" id="img" name="return_request['.$ordered_product->id.'][image]" accept="image/*" class="ordered-product-'.$ordered_product->id.'" disabled>
                            </td>
                        </tr>';
        }

        $response = array('ordered_products' => $response);

        echo json_encode($response);
    }

    public function store_return_request(Request $request)
    {

        $validatedData = $request->validate([
                                'quantity' => ['required'],
                                'reason' => ['required'],
                                'image' => ['image', 'required']
                            ]);

        // dd($request);
        $path = public_path() . '/storage/return-requests/';
        $folderPath = 'public/return-requests/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

        }

        $max_id = ReturnRequestProduct::max('id');
        $return_request_no = (date('Y')*10000)+$max_id+1;

        $ordered_product = OrderedProduct::where('id', $request->ordered_product_id)->first();

        $offer_price = isset($ordered_product->ordered_product_offer) ? $ordered_product->ordered_product_offer->discount_amount : 0;
        $unit_offer_price = $offer_price/$ordered_product->quantity;
        $return_offer_price = $unit_offer_price * $request->quantity;

        $discount_price = isset($ordered_product->ordered_product_discount_coupon) ? $ordered_product->ordered_product_discount_coupon->discount_amount : 0;
        $unit_discount_price = $discount_price/$ordered_product->quantity;
        $return_discount_price = $unit_discount_price * $request->quantity;

        $unit_price = $ordered_product->sub_total/$ordered_product->quantity;
        $sub_total = $unit_price * $request->quantity;

        $sub_total = $sub_total - $return_offer_price - $return_discount_price;

        $returnProductArray = [
            'customer_id' => Auth::user()->id,
            'return_request_no' => $return_request_no,
            'ordered_product_id' => $ordered_product->id,
            'product_id' => $ordered_product->product_id,
            'product_color_id' => $ordered_product->product_color_id,
            'product_size_id' => $ordered_product->product_size_id,
            'weight' => $ordered_product->weight,
            'quantity' => $request->quantity,
            'sub_total' => $sub_total,
            'reason' => $request->reason,
            'created_by' => 'Customer'
        ];

        

        //Add the new photo
        $image = $request->file('image');
        $filename = time() . '_'.$ordered_product->id.'.' . $image->getClientOriginalExtension();
        $folderPath = "public/return-requests/";

        Storage::putFileAs($folderPath, new File($image), $filename);

        //Update the database
        $returnProductArray['image'] = $filename;

        

        $return_product_created = ReturnRequestProduct::create($returnProductArray);

        if ($return_product_created) {

            return redirect()->back()->with('status', 'Request for Return submitted Successfully!');
        }else{

            return redirect()->back()->with('error','Something Went Wrong on Return Request');
        }

    }

    public function post_return_request(Request $request)
    {
        // dd($request);
        $return_requests = $request->return_request;
        $return_request_images = $request->file('return_request');

        $path = public_path() . '/storage/return-requests/';
        $folderPath = 'public/return-requests/';

        if (!file_exists($path)) {

            Storage::makeDirectory($folderPath, 0777, true, true);

            if (!is_dir($path . "/thumbs")) {
                Storage::makeDirectory($folderPath . '/thumbs', 0777, true, true);
            }
        }

        $max_id = ReturnRequest::max('id');
        $return_request_no = (date('Y')*10000)+$max_id+1;

        $returnRequestProductArray = array();

        $grand_total_price = 0;

        foreach ($return_requests as $key => $return_request) {
            $ordered_product = OrderedProduct::where('id', $return_request['id'])->first();
            $unit_price = $ordered_product->sub_total/$ordered_product->quantity;
            $sub_total = $unit_price * $return_request['quantity'];

            $grand_total_price = $grand_total_price + $sub_total;

            $returnProductArray = [
                'ordered_product_id' => $ordered_product->id,
                'product_id' => $ordered_product->product_id,
                'quantity' => $return_request['quantity'],
                'sub_total' => $sub_total,
                'reason' => $return_request['reason']

            ];

            // dd($returnProductArray);

            if ($return_request_images[$key]) {

                //Add the new photo
                $image = $return_request_images[$key]['image'];
                $filename = time() . '_'.$ordered_product->id.'.' . $image->getClientOriginalExtension();
                $folderPath = "public/return-requests/";
                $thumbPath = "public/return-requests/thumbs";

                if (!file_exists($thumbPath)) {
                    
                    Storage::makeDirectory($thumbPath, 0777, true, true);
                }

                Storage::putFileAs($folderPath, new File($image), $filename);

                //Update the database
                $returnProductArray['image'] = $filename;

            }

            array_push($returnRequestProductArray, $returnProductArray);

        }

        $createArray =[
            'order_id' => $request->order_id,
            'return_request_no' => $return_request_no,
            'customer_id' => Auth::user()->id,
            'total_price' => $grand_total_price,
        ];

        $return_request_created = ReturnRequest::create($createArray);

        if ($return_request_created) {

            $return_request_created->return_request_products()->createMany($returnRequestProductArray);
            return redirect()->route('customer.return-requests')->with('status','Return Request Successful!');
        }else{
            
            return redirect()->back()->with('error','Something Went Wrong on Return Request');
        }

        

    }

    public function view_return_request($return_request_no)
    {
        $return_request = ReturnRequest::where([['customer_id', Auth::user()->id],['return_request_no', base64_decode($return_request_no)]])->first();
        
        if (!$return_request) {
            return redirect()->back()->with('error','Return Request Detail Not Found.');
        }

        // $billing_details = json_decode($return_request->billing_details);
        // $shipping_details = json_decode($return_request->shipping_details);
        $return_status = ReturnRequest::return_status();

        return view('view-return-request-details',compact('return_request', 'return_status'));
    }

    public function wishlist()
    {
        $customer = User::where('id', Auth::user()->id)->first();
        $wishlists = $customer->wishlists;
        
        return view('wishlists',compact('customer','wishlists'));
    }

    public function add_to_wishlist(Request $request)
    {
        
        if (!Auth::check()){
            
            $data = array('status' => 'login-error');   
            echo json_encode($data);
            exit();
        }
        

        if (Auth::user()->hasRole(['customer'])) {

            if ($request->product_color_id) {

                $product_color_id = $request->product_color_id;
                $productExists = Wishlist::where([['customer_id', Auth::user()->id],['product_color_id', $product_color_id]])->first();

                if ($productExists) {

                    // $productExists = Wishlist::where([['customer_id', Auth::user()->id],['product_color_id',$product_color_id]])->delete();                  
                    $data = array('status'=> 'exist');
                    echo json_encode($data);
                    exit();

                }else{

                    $wishlist_product = Wishlist::create(['customer_id' => Auth::user()->id,'product_color_id' => $product_color_id]);
                    
                    $data = array('status'=> 'success');
                    echo json_encode($data);
                    exit();
                }
            }else{

                $data = array('status'=> 'error');
                echo json_encode($data);
                exit();
            }
        }else{

            $data = array('status'=> 'not-a-customer');
            echo json_encode($data);
            exit();
        }
    }

    public function remove_from_wishlist(Request $request){
        if (@$request->action == 'delete') {

            $wishlist_id = $request->wishlist_id;
            $customer = User::where('id', Auth::user()->id)->firstOrFail();
            $wishlist = $customer->wishlists()->where('id',$wishlist_id)->delete();

            if ($wishlist) {

                $data = array('status'=> 'removed');
                echo json_encode($data);
                
            }
        }
    }

    public function nic_payment($order_no)
    {
        $order = Order::where([['customer_id', Auth::user()->id],['order_no', base64_decode($order_no)]])->first();
        
        if (!$order) {
            return redirect()->back()->with('error','Order Detail Not Found.');
        }

        $order_status = Order::order_status();
        $payment_method = Order::payment_method();
        $canceled_reasons = Order::canceled_reasons();
        $billing_details = json_decode($order->billing_details);
        $shipping_details = json_decode($order->shipping_details);

        dd($order);
    }

    public function pay_now($order_no)
    {
        $order_no = base64_decode($order_no);
        $order = Order::where([['customer_id', Auth::user()->id],['order_no', $order_no]])->first();

        if (!$order) {

            return redirect()->back()->with('error','Order Detail Not Found.');

        }elseif ($order->payment_method == 2 && $order->payment_status == 1) {

            return redirect()->back()->with('error','Order Payment is already Paid.');
        }elseif ($order->payment_method == 1) {
            
            return redirect()->back()->with('error','Order Payment method is set to Cash on Delivery.');
        }
        // dd($order);

        if ($order->payment_method == 2) {

            session()->put("order_no_for_nic", $order->order_no);

            /*------------------ NIC ASIA PAYMENT FUNCTIONALITIES ------------------*/

            $uniq = uniqid();
            $date = gmdate("Y-m-d\TH:i:s\Z");

            $billing_details = (array)json_decode($order->billing_details);
            $shipping_details = (array)json_decode($order->shipping_details);

            $billNameArray = explode(' ', $billing_details['billing_name']);

            $bill_to_last_name = end($billNameArray);
            array_pop($billNameArray);
            $bill_to_first_name = implode(' ', $billNameArray);

            $shipNameArray = explode(' ', $shipping_details['shipping_name']);

            $ship_to_last_name = end($shipNameArray);
            array_pop($shipNameArray);
            $ship_to_first_name = implode(' ', $shipNameArray);

            if( $billing_details['billing_country_id'] == 0){

                $billing_city_name = $billing_details['billing_city_name'];
                $billing_state_name = $billing_details['billing_state_name'];
                $billing_country_name = $billing_details['billing_country_name'];
            }else{

                $city = City::find($billing_details['billing_city_id']);
                $state = State::find($billing_details['billing_state_id']);
                $country = Country::find($billing_details['billing_country_id']);

                $billing_city_name = isset($city) ? $city->name : 'N/A';
                $billing_state_name = isset($state) ? $state->name : 'N/A';
                $billing_country_name = isset($country) ? $country->name : 'N/A';
                
            }

            if( $shipping_details['shipping_country_id'] == 0){

                $shipping_city_name = $shipping_details['shipping_city_name'];
                $shipping_state_name = $shipping_details['shipping_state_name'];
                $shipping_country_name = $shipping_details['shipping_country_name'];
            }else{

                $city = City::find($shipping_details['shipping_city_id']);
                $state = State::find($shipping_details['shipping_state_id']);
                $country = Country::find($shipping_details['shipping_country_id']);

                $shipping_city_name = isset($city) ? $city->name : 'N/A';
                $shipping_state_name = isset($state) ? $state->name : 'N/A';
                $shipping_country_name = isset($country) ? $country->name : 'N/A';
                
            }

            $testValues = array(
                'access_key' => 'db5ff28911b9380e88d8745d5ad3acab',
                'profile_id' =>  '24278DDF-212B-4A9E-B5C9-EA233FADBF5A',
                'transaction_uuid' => $uniq,
                'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,ship_to_forename,ship_to_surname,ship_to_email,ship_to_phone,ship_to_address_line1,ship_to_address_city,ship_to_address_state,ship_to_address_country',
                'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
                'signed_date_time' => $date,
                'locale' => 'en',
                'amount' => $order->total_price.'.00',
                'bill_to_forename' => $bill_to_first_name,
                'bill_to_surname' => $bill_to_last_name,
                'bill_to_email' => $billing_details['billing_email'],
                'bill_to_phone' => $billing_details['billing_phone'],
                'bill_to_address_line1' => $billing_details['billing_street_address_1'],
                'bill_to_address_city'=> $billing_city_name,
                'bill_to_address_state'=> $billing_state_name,
                'bill_to_address_country' => 'NP',
                'ship_to_forename' => $ship_to_first_name,
                'ship_to_surname' => $ship_to_last_name,
                'ship_to_email' => $shipping_details['shipping_email'],
                'ship_to_phone' => $shipping_details['shipping_phone'],
                'ship_to_address_line1' => $shipping_details['shipping_street_address_1'],
                'ship_to_address_city'=> $shipping_city_name,
                'ship_to_address_state'=> $shipping_state_name,
                'ship_to_address_country' => 'NP',
                'transaction_type' => 'sale',
                'reference_number' => $order_no,
                'currency' => 'NPR',
                'payment_method' => 'card'
            );
            $fieldValues = array();

            foreach(explode(',', $testValues['signed_field_names']) as $test){
                $text = $test . "=" . $testValues[$test];
                array_push($fieldValues, $text);
            }
            // dd(join(',', $fieldValues));
            $joinedValue = join(',', $fieldValues);

            $hash = base64_encode(hash_hmac('sha256', $joinedValue, '59a829a47af34eacb304ec884b669665f6d358e66d1246d69f2cdbc038d90779147bd6c5fabd4f6d9f63a6133a1a701f97eff1cb4ad548c3b34b55ec702d006010ecce1630eb40b3bde0adbe914c38e9c74931a73a224216bc38d05ec5e4a2d6ee4ea2089be6480cb8d23e77191c0bb6107f7725f79245888f74c322dad0729f', true));

            $nica_url = "https://testsecureacceptance.cybersource.com/pay";
            $data =[
                'access_key' => 'db5ff28911b9380e88d8745d5ad3acab',
                'profile_id' =>  '24278DDF-212B-4A9E-B5C9-EA233FADBF5A',
                'transaction_uuid' => $uniq,
                'signed_field_names' => 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,bill_to_forename,bill_to_surname,bill_to_email,bill_to_phone,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,ship_to_forename,ship_to_surname,ship_to_email,ship_to_phone,ship_to_address_line1,ship_to_address_city,ship_to_address_state,ship_to_address_country',
                'unsigned_field_names' => 'card_type,card_number,card_expiry_date',
                'signed_date_time' => $date,
                'locale' => 'en',
                'amount' => $order->total_price.'.00',
                'bill_to_forename' => $bill_to_first_name,
                'bill_to_surname' => $bill_to_last_name,
                'bill_to_email' => $billing_details['billing_email'],
                'bill_to_phone' => $billing_details['billing_phone'],
                'bill_to_address_line1' => $billing_details['billing_street_address_1'],
                'bill_to_address_city'=> $billing_city_name,
                'bill_to_address_state'=> $billing_state_name,
                'bill_to_address_country' => 'NP',
                'ship_to_forename' => $ship_to_first_name,
                'ship_to_surname' => $ship_to_last_name,
                'ship_to_email' => $shipping_details['shipping_email'],
                'ship_to_phone' => $shipping_details['shipping_phone'],
                'ship_to_address_line1' => $shipping_details['shipping_street_address_1'],
                'ship_to_address_city'=> $shipping_city_name,
                'ship_to_address_state'=> $shipping_state_name,
                'ship_to_address_country' => 'NP',
                'transaction_type' => 'sale',
                'reference_number' => $order_no,
                'currency' => 'NPR',
                'payment_method' => 'card',
                'signature' => $hash,
                'card_type' => '001',
                'card_number' => '',
                'card_expiry_date' => ''
            ];
            // dd(Auth::user());
            // dd($data);
            
            return view('nic-asia-payment', compact('data', 'nica_url'));
        }
    }

}
